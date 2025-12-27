<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        [$items, $totals] = $this->buildCart();
        return view('pages.cart', ['items' => $items, 'totals' => $totals]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1|max:99'
        ]);

        $cart = Session::get('cart', []);
        $productId = (int)$request->product_id;
        $qty = (int)$request->get('qty', 1);
        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;
        Session::put('cart', $cart);

        return redirect()->back()->with('status', 'Товар добавлен в корзину');
    }

    public function update(Request $request)
    {
        $request->validate([
            'items' => 'required|array'
        ]);
        $cart = [];
        foreach ($request->items as $productId => $qty) {
            $qty = max(0, (int)$qty);
            if ($qty > 0) {
                $cart[(int)$productId] = min($qty, 99);
            }
        }
        Session::put('cart', $cart);
        return redirect()->back()->with('status', 'Корзина обновлена');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);
        $cart = Session::get('cart', []);
        unset($cart[(int)$request->product_id]);
        Session::put('cart', $cart);
        return redirect()->back()->with('status', 'Товар удалён');
    }

    public function buildCart(): array
    {
        $cart = Session::get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        $items = [];
        $subtotal = 0;
        foreach ($products as $product) {
            $qty = $cart[$product->id] ?? 1;
            $line = $product->price * $qty;
            $subtotal += $line;
            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'line' => $line,
            ];
        }
        $totals = [
            'subtotal' => $subtotal,
            'shipping' => 0,
            'discount' => 0,
            'total' => $subtotal,
        ];
        return [$items, $totals];
    }
}
