@extends('layouts.app')
@section('title', 'Secure Checkout — Arcane Sanctum')

@section('content')
<div style="padding-top:6rem;padding-bottom:6rem;">
  <div class="container" style="max-width:64rem;">

    <div data-fadein style="display:flex;align-items:center;gap:0.75rem;margin-bottom:2rem;">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--primary);">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;">Secure Checkout</h1>
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:3rem;">

      {{-- FORM --}}
      <div class="glass-card rounded-2xl" style="padding:2rem;border-color:rgba(255,255,255,0.05);" data-fadein>
        <form action="{{ route('checkout.store') }}" method="POST">
          @csrf

          <h3 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:1.5rem;padding-bottom:0.75rem;border-bottom:1px solid rgba(255,255,255,0.08);">Seeker Details</h3>

          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-input" placeholder="Eldritch Scholar" value="{{ old('name') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Scroll Address (Email)</label>
            <input type="email" name="email" class="form-input" placeholder="scholar@sanctum.edu" value="{{ old('email') }}" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <h3 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin:2rem 0 1rem;padding-bottom:0.75rem;border-bottom:1px solid rgba(255,255,255,0.08);">Offering Method</h3>

          <div style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:2rem;">
            @foreach([['card','Standard Card'],['crypto','Aetherial Coin (Crypto)'],['paypal','PayPal']] as [$val,$label])
            <label class="radio-option" style="cursor:pointer;">
              <input type="radio" name="payment_method" value="{{ $val }}" {{ old('payment_method','card') === $val ? 'checked' : '' }} style="accent-color:var(--primary);">
              <span style="font-family:var(--font-sans);font-weight:500;">{{ $label }}</span>
            </label>
            @endforeach
            @error('payment_method')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <button type="submit" class="magic-btn magic-btn-primary" style="width:100%;justify-content:center;font-size:1rem;padding:1rem 2rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:0.5rem;">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Complete Order • ${{ number_format($total,2) }}
          </button>
        </form>
      </div>

      {{-- ORDER MANIFEST --}}
      <div style="position:sticky;top:6rem;align-self:start;">
        <div class="glass-card rounded-2xl" style="padding:1.5rem;border-color:rgba(255,255,255,0.05);background:rgba(0,0,0,0.2);" data-fadein data-delay="150">
          <h3 style="font-family:var(--font-display);font-size:1.15rem;font-weight:700;margin-bottom:1.5rem;">Order Manifest</h3>

          <div style="max-height:16rem;overflow-y:auto;display:flex;flex-direction:column;gap:1rem;margin-bottom:1.5rem;padding-right:0.25rem;">
            @foreach($items as $item)
            <div style="display:flex;gap:0.75rem;align-items:center;">
              <div style="width:4rem;height:4rem;border-radius:var(--radius);background:rgba(0,0,0,0.5);overflow:hidden;flex-shrink:0;position:relative;">
                @if($item['image_url'])
                  <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                  <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:rgba(255,255,255,0.2)">
                      <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                  </div>
                @endif
                <span style="position:absolute;top:-0.25rem;right:-0.25rem;background:var(--primary);color:var(--primary-fg);font-size:0.6rem;font-weight:700;width:1.1rem;height:1.1rem;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $item['quantity'] }}</span>
              </div>
              <div style="flex-grow:1;min-width:0;">
                <div style="font-family:var(--font-sans);font-weight:700;font-size:0.8rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item['name'] }}</div>
                <div style="font-family:var(--font-sans);font-size:0.7rem;color:var(--muted-fg);">${{ number_format($item['price'],2) }} each</div>
              </div>
              <div style="font-family:var(--font-sans);font-weight:700;color:var(--primary);font-size:0.875rem;flex-shrink:0;">
                ${{ number_format($item['price']*$item['quantity'],2) }}
              </div>
            </div>
            @endforeach
          </div>

          <div style="border-top:1px solid rgba(255,255,255,0.08);padding-top:1rem;display:flex;flex-direction:column;gap:0.6rem;font-family:var(--font-sans);font-size:0.875rem;">
            <div style="display:flex;justify-content:space-between;color:var(--muted-fg);">
              <span>Subtotal</span><span>${{ number_format($subtotal,2) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;color:var(--muted-fg);">
              <span>Ethereal Delivery</span><span>Free</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:baseline;padding-top:0.75rem;border-top:1px solid rgba(255,255,255,0.08);">
              <span style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;">Total</span>
              <span style="font-family:var(--font-display);font-size:1.5rem;font-weight:700;color:var(--primary);text-shadow:0 0 8px rgba(201,168,76,0.3);">${{ number_format($total,2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
