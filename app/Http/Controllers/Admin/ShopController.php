<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.shop.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('type', 'shop')->get();
        return view('admin.shop.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'original_price' => ['nullable', 'numeric'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'image_url' => ['nullable', 'url'],
            'type' => ['required', 'in:physical,digital'],
            'in_stock' => ['nullable', 'boolean'],
            'featured' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
            'is_bestseller' => ['nullable', 'boolean'],
            'stock_qty' => ['nullable', 'integer'],
            'digital_file' => ['nullable', 'file', 'max:51200'],
        ]);

        if ($request->hasFile('digital_file')) {
            $file = $request->file('digital_file');
            $path = $file->store('digital-products');
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }
        unset($data['digital_file']);

        Product::create($data);
        return redirect()->route('admin.shop.index')->with('success', 'Product created.');
    }

    public function edit(Product $shop)
    {
        $categories = Category::where('type', 'shop')->get();
        $product = $shop;
        return view('admin.shop.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $shop)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $shop->id],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'original_price' => ['nullable', 'numeric'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'image_url' => ['nullable', 'url'],
            'type' => ['required', 'in:physical,digital'],
            'in_stock' => ['nullable', 'boolean'],
            'featured' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
            'is_bestseller' => ['nullable', 'boolean'],
            'stock_qty' => ['nullable', 'integer'],
            'digital_file' => ['nullable', 'file', 'max:51200'],
        ]);

        if ($request->hasFile('digital_file')) {
            $file = $request->file('digital_file');
            $path = $file->store('digital-products');
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }
        unset($data['digital_file']);

        $shop->update($data);
        return redirect()->route('admin.shop.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $shop)
    {
        $shop->delete();
        return redirect()->route('admin.shop.index')->with('success', 'Product deleted.');
    }
}
