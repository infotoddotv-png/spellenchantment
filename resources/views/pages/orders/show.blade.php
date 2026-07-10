@extends('layouts.app')
@section('title', 'Order Confirmed — Arcane Sanctum')

@section('content')
<div style="padding-top:6rem;padding-bottom:6rem;">
  <div class="container" style="max-width:40rem;text-align:center;">

    <div class="glow-blob glow-gold glow-lg" style="top:0;left:50%;transform:translateX(-50%);opacity:0.2;"></div>

    <div data-fadein>
      <div class="order-success-icon">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>

      <h1 style="font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:0.75rem;">
        Order Confirmed
      </h1>
      <p style="font-family:var(--font-serif);color:var(--muted-fg);font-size:1.1rem;margin-bottom:2.5rem;">
        Your artifacts are being prepared for ethereal transit. A scroll will arrive at your address shortly.
      </p>

      <div class="glass-card rounded-2xl" style="padding:2rem;text-align:left;margin-bottom:2rem;border-color:rgba(255,255,255,0.05);">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid rgba(255,255,255,0.08);">
          <div>
            <div style="font-family:var(--font-sans);font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted-fg);margin-bottom:0.25rem;">Order ID</div>
            <div style="font-family:var(--font-display);font-weight:700;color:var(--primary);">#{{ str_pad($order->id,6,'0',STR_PAD_LEFT) }}</div>
          </div>
          <div>
            <div style="font-family:var(--font-sans);font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted-fg);margin-bottom:0.25rem;">Status</div>
            <div style="font-family:var(--font-sans);font-size:0.875rem;font-weight:600;color:#4ade80;">✓ {{ ucfirst($order->status) }}</div>
          </div>
          <div>
            <div style="font-family:var(--font-sans);font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted-fg);margin-bottom:0.25rem;">Seeker</div>
            <div style="font-family:var(--font-sans);font-size:0.9rem;">{{ $order->name }}</div>
          </div>
          <div>
            <div style="font-family:var(--font-sans);font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted-fg);margin-bottom:0.25rem;">Scroll Address</div>
            <div style="font-family:var(--font-sans);font-size:0.9rem;overflow:hidden;text-overflow:ellipsis;">{{ $order->email }}</div>
          </div>
        </div>

        {{-- Items --}}
        @if($order->items)
        <div style="display:flex;flex-direction:column;gap:0.75rem;margin-bottom:1.5rem;">
          @foreach($order->items as $item)
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
              <div style="font-family:var(--font-sans);font-size:0.875rem;font-weight:600;">{{ $item['name'] }}</div>
              <div style="font-family:var(--font-sans);font-size:0.75rem;color:var(--muted-fg);">Qty: {{ $item['quantity'] }}</div>
            </div>
            <div style="font-family:var(--font-sans);font-weight:700;color:var(--primary);">
              ${{ number_format($item['price']*$item['quantity'],2) }}
            </div>
          </div>
          @endforeach
        </div>
        @endif

        <div style="padding-top:1rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;justify-content:space-between;align-items:baseline;">
          <span style="font-family:var(--font-display);font-weight:700;">Total Offering</span>
          <span style="font-family:var(--font-display);font-size:1.5rem;font-weight:700;color:var(--primary);">${{ number_format($order->total,2) }}</span>
        </div>
      </div>

      @if($order->downloads->count())
      <div class="glass-card rounded-2xl" style="padding:1.5rem;text-align:left;margin-bottom:2rem;border-color:rgba(255,255,255,0.05);">
        <h3 style="font-family:var(--font-display);font-weight:700;margin-bottom:1rem;">Your Downloads</h3>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
          @foreach($order->downloads as $dl)
            <a href="{{ route('downloads.show', $dl->token) }}" class="magic-btn magic-btn-outline" style="justify-content:space-between;">
              <span>{{ $dl->product->name }}</span>
              <span style="color:var(--muted-fg);font-size:0.8rem;">{{ $dl->download_count }}/{{ $dl->max_downloads }} used</span>
            </a>
          @endforeach
        </div>
      </div>
      @elseif($order->payment_method === 'manual' && $order->status === 'pending_payment')
      <div class="glass-card rounded-2xl" style="padding:1.5rem;text-align:left;margin-bottom:2rem;border-color:rgba(255,255,255,0.05);">
        <h3 style="font-family:var(--font-display);font-weight:700;margin-bottom:0.75rem;">Payment Instructions</h3>
        <p style="color:var(--muted-fg);white-space:pre-line;">{{ \App\Models\PaymentSetting::get('manual_instructions', 'Please contact us to complete payment for this order.') }}</p>
      </div>
      @endif

      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('shop.index') }}" class="magic-btn magic-btn-primary">Continue Seeking</a>
        <a href="{{ route('home') }}" class="magic-btn magic-btn-outline">Return to Sanctum</a>
      </div>
    </div>
  </div>
</div>
@endsection
