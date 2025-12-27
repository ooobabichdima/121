<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category', 'brand')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:products,slug',
            'sku' => 'required|string|unique:products,sku',
            'price' => 'required|integer',
            'old_price' => 'nullable|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
        ]);
        Product::create($data);
        return redirect()->route('admin.products.index')->with('status', 'Товар создан');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:products,slug,'.$product->id,
            'sku' => 'required|string|unique:products,sku,'.$product->id,
            'price' => 'required|integer',
            'old_price' => 'nullable|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
        ]);
        $product->update($data);
        return redirect()->route('admin.products.index')->with('status', 'Товар обновлен');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Товар удалён');
    }
}
