<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function category(string $slug, Request $request): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Product::with('brand')->where('category_id', $category->id)->where('is_active', true);

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('sku', 'like', "%$search%");
            });
        }

        if ($brand = $request->get('brand')) {
            $query->whereHas('brand', fn($q) => $q->whereIn('slug', (array)$brand));
        }

        if ($platform = $request->get('platform')) {
            $query->whereHas('attributes', function ($q) use ($platform) {
                $q->whereHas('attribute', fn($a) => $a->where('code', 'platform'))
                    ->whereIn('value_string', (array)$platform);
            });
        }

        if ($minPrice = $request->get('min_price')) {
            $query->where('price', '>=', (int)$minPrice);
        }
        if ($maxPrice = $request->get('max_price')) {
            $query->where('price', '<=', (int)$maxPrice);
        }

        $sort = $request->get('sort');
        $query->when($sort === 'price_asc', fn($q) => $q->orderBy('price'))
            ->when($sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when($sort === 'new', fn($q) => $q->orderByDesc('created_at'));

        $products = $query->paginate(12)->withQueryString();

        return view('pages.category', [
            'category' => $category,
            'products' => $products,
            'filters' => $request->all(),
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::with(['brand', 'category', 'images', 'attributes.attribute', 'recommended', 'tuningKits'])->where('slug', $slug)->firstOrFail();
        $recommended = $product->recommended()->take(4)->get();
        $tuningKits = $product->tuningKits;

        return view('pages.product', compact('product', 'recommended', 'tuningKits'));
    }
}
