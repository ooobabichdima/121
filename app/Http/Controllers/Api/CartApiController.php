<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartApiController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1|max:99'
        ]);
        $cart = Session::get('cart', []);
        $cart[(int)$request->product_id] = ($cart[(int)$request->product_id] ?? 0) + (int)$request->get('qty', 1);
        Session::put('cart', $cart);
        return response()->json(['ok' => true, 'cart' => $cart]);
    }

    public function update(Request $request)
    {
        $request->validate(['items' => 'required|array']);
        $cart = [];
        foreach ($request->items as $productId => $qty) {
            $qty = max(0, (int)$qty);
            if ($qty > 0) {
                $cart[(int)$productId] = min($qty, 99);
            }
        }
        Session::put('cart', $cart);
        return response()->json(['ok' => true, 'cart' => $cart]);
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);
        $cart = Session::get('cart', []);
        unset($cart[(int)$request->product_id]);
        Session::put('cart', $cart);
        return response()->json(['ok' => true, 'cart' => $cart]);
    }

    public function show()
    {
        $cart = Session::get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        $items = [];
        $subtotal = 0;
        foreach ($products as $product) {
            $qty = $cart[$product->id] ?? 1;
            $line = $product->price * $qty;
            $subtotal += $line;
            $items[] = ['id' => $product->id, 'name' => $product->name, 'qty' => $qty, 'line' => $line];
        }
        return response()->json(['items' => $items, 'subtotal' => $subtotal]);
    }
}
