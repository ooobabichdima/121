<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PickupLead;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Product::where('is_featured', true)->take(8)->get();
        $new = Product::where('is_new', true)->take(8)->get();
        $bundles = Product::with('category')->take(8)->get();

        return view('pages.home', [
            'featured' => $featured,
            'new' => $new,
            'bundles' => $bundles,
        ]);
    }

    public function lead(Request $request)
    {
        $data = $request->validate([
            'contact' => 'required|string|max:150',
            'answers' => 'nullable|array',
        ]);
        PickupLead::create([
            'contact' => $data['contact'],
            'answers_json' => $data['answers'] ?? [],
        ]);
        return redirect()->back()->with('status', 'Заявка отправлена. Мы свяжемся с тобой.');
    }
}
