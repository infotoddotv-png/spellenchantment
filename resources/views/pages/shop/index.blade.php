@extends('layouts.app')
@section('title', 'Mystical Artifacts — Shop')

@section('content')
<div style="padding-top:6rem;padding-bottom:4rem;">
  <div class="container">

    {{-- HEADER --}}
    <div class="page-header" data-fadein>
      <h1 class="page-title">Mystical Artifacts</h1>
      <div class="page-divider"></div>
      <p style="font-family:var(--font-serif);color:var(--muted-fg);max-width:40rem;margin:0 auto;">
        Curated tools for the practicing mage. Each item is authenticated and bound with protective wards.
      </p>
    </div>

    <div class="shop-layout">

      {{-- SIDEBAR --}}
      <aside>
        <div class="glass-card rounded-xl shop-sidebar" style="padding:1.25rem;">
          <form method="GET" action="{{ route('shop.index') }}" style="margin-bottom:1.5rem;">
            <div class="sidebar-search">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
              </svg>
              <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search artifacts..." autocomplete="off">
              @if($activeCategory)<input type="hidden" name="category" value="{{ $activeCategory }}">@endif
            </div>
          </form>

          <div class="sidebar-title" style="display:flex;align-items:center;gap:0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="12" y1="18" x2="20" y2="18"/>
            </svg>
            Categories
          </div>
          <div class="sidebar-divider"></div>

          <ul style="list-style:none;display:flex;flex-direction:column;gap:0.25rem;">
            <li>
              <a href="{{ route('shop.index', $searchQuery ? ['search'=>$searchQuery] : []) }}"
                 class="sidebar-btn {{ $activeCategory === '' ? 'active' : '' }}" style="text-decoration:none;">
                All Artifacts
              </a>
            </li>
            @foreach($categories as $cat)
            <li>
              <a href="{{ route('shop.index', array_filter(['category'=>$cat->slug,'search'=>$searchQuery])) }}"
                 class="sidebar-btn {{ $activeCategory === $cat->slug ? 'active' : '' }}" style="text-decoration:none;">
                <span>{{ $cat->icon }} {{ $cat->name }}</span>
                <span class="sidebar-count">{{ $cat->products->count() }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
      </aside>

      {{-- PRODUCT GRID --}}
      <div>
        @if($products->isEmpty())
          <div class="glass-card rounded-xl" style="padding:3rem;text-align:center;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:var(--muted-fg);margin:0 auto 1rem;display:block;">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            <h3 style="font-family:var(--font-display);font-size:1.25rem;margin-bottom:0.5rem;">No artifacts found</h3>
            <p style="font-family:var(--font-sans);color:var(--muted-fg);font-size:0.875rem;">The archives contain nothing matching your query.</p>
          </div>
        @else
          <div class="product-grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr));">
            @foreach($products as $i => $product)
            <div data-fadein data-delay="{{ min($i * 50, 300) }}">
              <a href="{{ route('shop.show', $product->slug) }}" style="display:block;height:100%;">
                <div class="glass-card product-card" style="border-color:rgba(255,255,255,0.05);">
                  <div class="product-card-image" style="aspect-ratio:1;">
                    @if($product->image_url)
                      <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    @else
                      <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:rgba(255,255,255,0.08)">
                          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                      </div>
                    @endif
                    @if(!$product->in_stock)
                      <div class="out-of-stock-overlay">
                        <div class="out-of-stock-label">Out of Stock</div>
                      </div>
                    @endif
                  </div>
                  <div class="product-card-body">
                    <div class="product-card-name">{{ $product->name }}</div>
                    <div class="product-card-desc">{{ $product->description }}</div>
                    <div class="product-card-footer">
                      <div>
                        <span class="product-price">${{ number_format($product->price,2) }}</span>
                        @if($product->original_price)
                          <span class="product-price-original">${{ number_format($product->original_price,2) }}</span>
                        @endif
                      </div>
                      <span style="font-family:var(--font-sans);font-size:0.7rem;color:var(--muted-fg);padding:0.2rem 0.5rem;background:rgba(255,255,255,0.05);border-radius:4px;">{{ $product->type }}</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
