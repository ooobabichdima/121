<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Services\MonobankService;
use App\Services\NovaPoshtaService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected MonobankService $mono,
        protected NovaPoshtaService $np
    ) {}

    public function form(): View
    {
        [$items, $totals] = app(CartController::class)->buildCart();
        return view('pages.checkout', [
            'items' => $items,
            'totals' => $totals,
        ]);
    }

    public function submit(CheckoutRequest $request)
    {
        [$items, $totals] = app(CartController::class)->buildCart();
        if (empty($items)) {
            return redirect()->route('cart')->withErrors('Корзина пуста');
        }

        $promo = strtoupper($request->promo_code ?? '');
        $shippingCost = match ($request->delivery_method) {
            'courier' => 200,
            'pickup' => 0,
            default => 150,
        };

        $upsellQty = max(0, (int)$request->upsell_mag_qty);
        if ($upsellQty > 0) {
            $mag = Product::where('sku', 'MAG-1')->first();
            if ($mag) {
                $items[] = ['product' => $mag, 'qty' => $upsellQty, 'line' => $mag->price * $upsellQty];
                $totals['subtotal'] += $mag->price * $upsellQty;
            }
        }

        $discount = promo_discount($promo, $totals['subtotal']);
        $total = max(0, $totals['subtotal'] - $discount + $shippingCost);

        $order = Order::create([
            'number' => 'ORD-'.now()->format('ymd').'-'.random_int(1000, 9999),
            'user_id' => optional($request->user())->id,
            'status' => 'new',
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subtotal' => $totals['subtotal'],
            'discount' => $discount,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'shipping_provider' => $request->delivery_method,
            'shipping_city' => $request->city,
            'shipping_ref' => $request->warehouse,
            'shipping_address' => $request->address,
            'comment' => $request->comment,
            'promo_code' => $promo ?: null,
        ]);

        foreach ($items as $line) {
            $product = $line['product'];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'name_snapshot' => $product->name,
                'sku_snapshot' => $product->sku,
                'price_snapshot' => $product->price,
                'qty' => $line['qty'],
            ]);
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => $request->payment_method === 'monobank' ? 'monobank' : ($request->payment_method === 'parts' ? 'monobank_parts' : 'cod'),
            'status' => 'pending',
            'amount' => $total,
            'currency' => 'UAH',
            'payload_json' => [],
        ]);

        Session::forget('cart');

        if ($request->payment_method === 'monobank') {
            return redirect()->route('pay.monobank', $order);
        }

        return redirect()->route('home')->with('status', 'Заказ оформлен: '.$order->number);
    }
}
