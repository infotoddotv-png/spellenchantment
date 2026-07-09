@extends('layouts.app')
@section('title', $product->name . ' — Arcane Sanctum')

@section('content')
<div style="padding-top:6rem;padding-bottom:6rem;position:relative;overflow:hidden;">
  <div class="glow-blob glow-gold glow-lg" style="top:5rem;right:-5rem;opacity:0.2;"></div>

  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;">

      {{-- IMAGE --}}
      <div data-fadein>
        <div class="glass-card rounded-2xl" style="aspect-ratio:1;overflow:hidden;padding:0.5rem;position:relative;">
          <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(201,168,76,0.05),transparent);z-index:1;border-radius:1rem;pointer-events:none;"></div>
          @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:0.75rem;">
          @else
            <div style="width:100%;height:100%;background:var(--secondary);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
              <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:var(--muted-fg)">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
              </svg>
            </div>
          @endif
        </div>
      </div>

      {{-- DETAILS --}}
      <div data-fadein data-delay="150">
        {{-- Category & badges --}}
        <div style="display:flex;gap:0.75rem;margin-bottom:1rem;flex-wrap:wrap;">
          @if($product->category)
            <span style="padding:0.25rem 0.75rem;font-size:0.7rem;font-family:var(--font-sans);font-weight:700;letter-spacing:0.1em;text-transform:uppercase;border:1px solid rgba(201,168,76,0.3);color:var(--primary);border-radius:9999px;background:rgba(201,168,76,0.05);">
              {{ $product->category->name }}
            </span>
          @endif
          @if($product->is_new)
            <span style="padding:0.25rem 0.75rem;font-size:0.7rem;font-family:var(--font-sans);font-weight:700;letter-spacing:0.1em;text-transform:uppercase;background:rgba(124,58,237,0.7);color:#fff;border-radius:9999px;">New Arrival</span>
          @endif
        </div>

        <h1 style="font-family:var(--font-display);font-size:2.5rem;font-weight:800;margin-bottom:0.5rem;line-height:1.15;">{{ $product->name }}</h1>

        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
          <span class="product-stars" style="font-size:1rem;">{{ $product->stars_html }}</span>
          <span style="font-family:var(--font-sans);font-size:0.875rem;color:var(--muted-fg);">({{ $product->review_count }} scholarly reviews)</span>
        </div>

        <div style="display:flex;align-items:baseline;gap:1rem;margin-bottom:2rem;">
          <span style="font-family:var(--font-display);font-size:2.5rem;font-weight:700;color:var(--primary);text-shadow:0 0 15px rgba(201,168,76,0.4);">${{ number_format($product->price,2) }}</span>
          @if($product->original_price)
            <span style="font-family:var(--font-sans);font-size:1.25rem;color:var(--muted-fg);text-decoration:line-through;">${{ number_format($product->original_price,2) }}</span>
          @endif
        </div>

        {{-- Lore --}}
        @if($product->lore)
        <div class="glass-card rounded-xl" style="padding:1.5rem;margin-bottom:2rem;border-left:2px solid var(--primary);position:relative;overflow:hidden;">
          <svg style="position:absolute;top:0.5rem;right:0.5rem;width:1rem;height:1rem;color:rgba(201,168,76,0.3);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
          </svg>
          <h3 style="font-family:var(--font-display);font-weight:700;margin-bottom:0.5rem;color:rgba(255,255,255,0.9);">Lore & Origins</h3>
          <p style="font-family:var(--font-serif);color:var(--muted-fg);line-height:1.7;font-style:italic;">{{ $product->lore }}</p>
        </div>
        @endif

        <p style="font-family:var(--font-sans);color:rgba(255,255,255,0.8);line-height:1.6;margin-bottom:2rem;">{{ $product->description }}</p>

        {{-- Add to Cart --}}
        @if($product->in_stock)
          <form action="{{ route('cart.add') }}" method="POST" style="display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div style="display:flex;align-items:center;background:rgba(0,0,0,0.4);border:1px solid rgba(255,255,255,0.1);border-radius:var(--radius);">
              <button type="button" class="qty-btn" data-action="dec"
                style="padding:0.75rem 1rem;color:var(--muted-fg);font-size:1.2rem;">−</button>
              <input type="number" name="quantity" value="1" min="1"
                style="width:3rem;text-align:center;background:none;border:none;color:var(--foreground);font-size:1rem;font-weight:700;" readonly>
              <button type="button" class="qty-btn" data-action="inc"
                style="padding:0.75rem 1rem;color:var(--muted-fg);font-size:1.2rem;">+</button>
            </div>
            <button type="submit" class="magic-btn magic-btn-primary" style="flex:1;min-width:160px;justify-content:center;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
              </svg>
              Secure Artifact
            </button>
          </form>
        @else
          <button class="magic-btn" style="opacity:0.5;cursor:not-allowed;background:var(--muted);color:var(--muted-fg);margin-bottom:2rem;" disabled>Out of Stock</button>
        @endif

        {{-- Trust badges --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;border-top:1px solid rgba(255,255,255,0.08);padding-top:2rem;">
          <div style="display:flex;align-items:center;gap:0.75rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;color:var(--primary);">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
              <div style="font-family:var(--font-sans);font-size:0.75rem;font-weight:700;">Warded</div>
              <div style="font-family:var(--font-sans);font-size:0.65rem;color:var(--muted-fg);">Safe to handle</div>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:0.75rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;color:var(--accent);">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
              <div style="font-family:var(--font-sans);font-size:0.75rem;font-weight:700;">Authenticated</div>
              <div style="font-family:var(--font-sans);font-size:0.65rem;color:var(--muted-fg);">Archmage certified</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.qty-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const input = this.closest('form').querySelector('input[name="quantity"]');
    let val = parseInt(input.value) || 1;
    if (this.dataset.action === 'inc') val++;
    else if (this.dataset.action === 'dec' && val > 1) val--;
    input.value = val;
  });
});
</script>
@endpush
