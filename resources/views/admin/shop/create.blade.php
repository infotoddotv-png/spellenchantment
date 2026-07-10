@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:46rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1.5rem;">Add Product</h1>
      <form method="POST" action="{{ route('admin.shop.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Slug</label>
          <input type="text" name="slug" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-input" rows="4"></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Price</label>
          <input type="number" step="0.01" name="price" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Original Price</label>
          <input type="number" step="0.01" name="original_price" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-input">
            <option value="">None</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Image URL</label>
          <input type="url" name="image_url" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">Type</label>
          <select name="type" class="form-input">
            <option value="physical">Physical</option>
            <option value="digital">Digital</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Featured</label>
          <input type="checkbox" name="featured" value="1">
        </div>
        <div class="form-group">
          <label class="form-label">New</label>
          <input type="checkbox" name="is_new" value="1">
        </div>
        <div class="form-group">
          <label class="form-label">Bestseller</label>
          <input type="checkbox" name="is_bestseller" value="1">
        </div>
        <div class="form-group">
          <label class="form-label">In Stock</label>
          <input type="checkbox" name="in_stock" value="1" checked>
        </div>
        <div class="form-group">
          <label class="form-label">Stock Quantity (physical, optional)</label>
          <input type="number" name="stock_qty" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">Digital File (for digital products — enables secure download delivery)</label>
          <input type="file" name="digital_file" class="form-input">
        </div>
        <button class="magic-btn magic-btn-primary" type="submit">Save Product</button>
      </form>
    </div>
  </div>
</div>
@endsection
