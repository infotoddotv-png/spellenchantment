@extends('layouts.admin')
@section('title', 'Shop Management')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
      <div>
        <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;">Shop Management</h1>
        <p style="color:var(--muted-fg);">Create, edit, and manage products in the storefront.</p>
      </div>
      <a href="{{ route('admin.shop.create') }}" class="magic-btn magic-btn-primary">Add Product</a>
    </div>

    <div class="glass-card rounded-2xl" style="padding:1.25rem;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
            <th style="text-align:left;padding:0.75rem;">Name</th>
            <th style="text-align:left;padding:0.75rem;">Category</th>
            <th style="text-align:left;padding:0.75rem;">Price</th>
            <th style="text-align:left;padding:0.75rem;">Stock</th>
            <th style="text-align:right;padding:0.75rem;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
            <td style="padding:0.75rem;">{{ $product->name }}</td>
            <td style="padding:0.75rem;">{{ $product->category?->name ?? '-' }}</td>
            <td style="padding:0.75rem;">${{ number_format($product->price, 2) }}</td>
            <td style="padding:0.75rem;">{{ $product->in_stock ? 'In stock' : 'Out of stock' }}</td>
            <td style="padding:0.75rem;text-align:right;">
              <a href="{{ route('admin.shop.edit', ['shop' => $product->id]) }}" style="margin-right:0.5rem;color:var(--primary);">Edit</a>
              <form action="{{ route('admin.shop.destroy', ['shop' => $product->id]) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;color:#ff7b7b;cursor:pointer;">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
