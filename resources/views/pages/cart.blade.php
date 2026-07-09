@extends('layouts.app')
@section('title', 'Your Satchel — Arcane Sanctum')

@section('content')
<div style="padding-top:6rem;padding-bottom:6rem;">
  <div class="container" style="max-width:64rem;">

    <div data-fadein>
      <h1 style="font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:0.5rem;">Your Satchel</h1>
      <div style="width:4rem;height:4px;background:var(--primary);margin-bottom:2rem;border-radius:2px;"></div>
    </div>

    @if(empty($items))
      <div class="glass-card rounded-2xl" style="padding:5rem 2rem;text-align:center;border-color:rgba(255,255,255,0.05);" data-fadein>
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:rgba(255,255,255,0.2);margin:0 auto 1.5rem;display:block;">
          <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <h2 style="font-family:var(--font-display);font-size:1.5rem;margin-bottom:0.75rem;">Your satchel is empty</h2>
        <p style="font-family:var(--font-serif);color:var(--muted-fg);margin-bottom:2rem;">The artifacts await your discovery in the shop.</p>
        <a href="{{ route('shop.index') }}" class="magic-btn magic-btn-primary">Return to Shop</a>
      </div>
    @else
      <div class="cart-layout">

        {{-- ITEMS --}}
        <div style="display:flex;flex-direction:column;gap:1rem;">
          @foreach($items as $item)
          <div class="glass-card cart-item" style="border-color:rgba(255,255,255,0.05);" data-fadein>
            <div class="cart-item-image">
              @if($item['image_url'])
                <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
              @else
                <div class="cart-item-placeholder">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                  </svg>
                </div>
              @endif
            </div>

            <div style="flex-grow:1;">
              <a href="{{ route('shop.show', $item['slug']) }}" style="font-family:var(--font-display);font-weight:700;font-size:1rem;display:block;margin-bottom:0.25rem;transition:color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">
                {{ $item['name'] }}
              </a>
              <div style="font-family:var(--font-sans);font-size:0.8rem;color:var(--muted-fg);margin-bottom:0.5rem;">
                Qty: {{ $item['quantity'] }}
                @if($item['type']) • {{ $item['type'] }} @endif
              </div>
              <div style="font-family:var(--font-sans);font-weight:700;color:var(--primary);">
                ${{ number_format($item['price'] * $item['quantity'], 2) }}
              </div>
            </div>

            {{-- Update qty --}}
            <form action="{{ route('cart.update') }}" method="POST" style="display:flex;align-items:center;background:rgba(0,0,0,0.4);border:1px solid rgba(255,255,255,0.1);border-radius:var(--radius);">
              @csrf
              <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
              <button type="button" class="qty-btn" data-action="dec" style="padding:0.5rem 0.75rem;color:var(--muted-fg);font-size:1rem;">−</button>
              <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                style="width:2.5rem;text-align:center;background:none;border:none;color:var(--foreground);font-weight:700;font-size:0.9rem;" readonly>
              <button type="button" class="qty-btn" data-action="inc" style="padding:0.5rem 0.75rem;color:var(--muted-fg);font-size:1rem;">+</button>
            </form>

            {{-- Remove --}}
            <form action="{{ route('cart.remove') }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
              <button type="submit" style="padding:0.75rem;color:var(--muted-fg);border-radius:50%;transition:all 0.2s;" onmouseover="this.style.color='#f87171';this.style.background='rgba(248,113,113,0.1)'" onmouseout="this.style.color='var(--muted-fg)';this.style.background='none'" title="Remove item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
              </button>
            </form>
          </div>
          @endforeach
        </div>

        {{-- ORDER SUMMARY --}}
        <div>
          <div class="glass-card rounded-xl" style="padding:1.5rem;position:sticky;top:6rem;border-color:rgba(255,255,255,0.05);">
            <h3 style="font-family:var(--font-display);font-size:1.25rem;font-weight:700;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid rgba(255,255,255,0.08);">Order Summary</h3>

            <div style="font-family:var(--font-sans);font-size:0.875rem;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:0.75rem;">
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--muted-fg);">Subtotal ({{ count($items) }} items)</span>
                <span>${{ number_format($subtotal,2) }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--muted-fg);">Ethereal Shipping</span>
                <span>Free</span>
              </div>
            </div>

            <div style="padding-top:1rem;border-top:1px solid rgba(255,255,255,0.08);margin-bottom:1.5rem;">
              <div style="display:flex;justify-content:space-between;align-items:baseline;">
                <span style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;">Total</span>
                <span style="font-family:var(--font-display);font-size:1.75rem;font-weight:700;color:var(--primary);text-shadow:0 0 10px rgba(201,168,76,0.3);">${{ number_format($total,2) }}</span>
              </div>
            </div>

            <a href="{{ route('checkout.index') }}" class="magic-btn magic-btn-primary" style="width:100%;justify-content:center;">
              Proceed to Checkout
            </a>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
