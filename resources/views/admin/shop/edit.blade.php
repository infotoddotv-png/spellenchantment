@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:46rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1.5rem;">Edit Product</h1>
      <form method="POST" action="{{ route('admin.shop.update', ['shop' => ($product->id ?? request()->route('shop'))]) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-input" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Slug</label>
          <input type="text" name="slug" class="form-input" value="{{ old('slug', $product->slug) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-input" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Price</label>
          <input type="number" step="0.01" name="price" class="form-input" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Original Price</label>
          <input type="number" step="0.01" name="original_price" class="form-input" value="{{ old('original_price', $product->original_price) }}">
        </div>
        <div class="form-group">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-input">
            <option value="">None</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Image URL</label>
          <input type="url" name="image_url" class="form-input" value="{{ old('image_url', $product->image_url) }}">
        </div>
        <div class="form-group">
          <label class="form-label">Type</label>
          <select name="type" class="form-input">
            <option value="physical" {{ $product->type === 'physical' ? 'selected' : '' }}>Physical</option>
            <option value="digital" {{ $product->type === 'digital' ? 'selected' : '' }}>Digital</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Featured</label>
          <input type="checkbox" name="featured" value="1" {{ $product->featured ? 'checked' : '' }}>
        </div>
        <div class="form-group">
          <label class="form-label">New</label>
          <input type="checkbox" name="is_new" value="1" {{ $product->is_new ? 'checked' : '' }}>
        </div>
        <div class="form-group">
          <label class="form-label">Bestseller</label>
          <input type="checkbox" name="is_bestseller" value="1" {{ $product->is_bestseller ? 'checked' : '' }}>
        </div>
        <div class="form-group">
          <label class="form-label">In Stock</label>
          <input type="checkbox" name="in_stock" value="1" {{ $product->in_stock ? 'checked' : '' }}>
        </div>
        <div class="form-group">
          <label class="form-label">Stock Quantity (physical, optional)</label>
          <input type="number" name="stock_qty" class="form-input" value="{{ old('stock_qty', $product->stock_qty) }}">
        </div>
        <div class="form-group">
          <label class="form-label">Digital File</label>
          @if($product->file_path)
            <p style="color:var(--muted-fg);font-size:0.85rem;">Current file: {{ $product->file_name }}</p>
          @endif
          <input type="file" name="digital_file" class="form-input">
        </div>
        <button class="magic-btn magic-btn-primary" type="submit">Update Product</button>
      </form>
    </div>
  </div>
</div>
@endsection
