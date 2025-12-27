<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(Request $request): View
    {
        $q = $request->get('q');
        $results = collect();
        if ($q) {
            $results = Product::where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('sku', 'like', "%$q%");
            })->limit(30)->get();
        }

        return view('pages.search', ['results' => $results, 'q' => $q]);
    }
}
