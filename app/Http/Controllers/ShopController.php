<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('type', 'shop')->get();

        $query = Product::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products        = $query->get();
        $activeCategory  = $request->category ?? '';
        $searchQuery     = $request->search ?? '';

        return view('pages.shop.index', compact('products', 'categories', 'activeCategory', 'searchQuery'));
    }

    public function show(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        return view('pages.shop.show', compact('product'));
    }
}
