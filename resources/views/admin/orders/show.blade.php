@extends('layouts.admin')
@section('title', 'Order #' . $order->id)

@section('content')
<div class="admin-page-head">
  <div>
    <h1>Order #{{ $order->id }}</h1>
    <p>Placed {{ $order->created_at->format('M j, Y g:ia') }}</p>
  </div>
  <a href="{{ route('admin.orders.index') }}" class="magic-btn magic-btn-outline">&larr; Back to Orders</a>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.25rem;">
  <div class="glass-card rounded-2xl" style="padding:1.5rem;">
    <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Items</h2>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
        <tbody>
          @foreach($order->items as $item)
          <tr>
            <td>{{ $item['name'] }}</td>
            <td>${{ number_format($item['price'], 2) }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div style="text-align:right;margin-top:1rem;">
      <div>Subtotal: ${{ number_format($order->subtotal, 2) }}</div>
      @if($order->discount > 0)
        <div>Discount ({{ $order->coupon_code }}): -${{ number_format($order->discount, 2) }}</div>
      @endif
      <div style="font-weight:700;font-size:1.2rem;">Total: ${{ number_format($order->total, 2) }}</div>
    </div>

    @if($order->downloads->count())
    <h2 style="font-family:var(--font-display);margin:1.5rem 0 1rem;">Digital Deliveries</h2>
    <ul style="list-style:none;padding:0;">
      @foreach($order->downloads as $dl)
        <li style="margin-bottom:0.5rem;">
          {{ $dl->product->name }} — {{ $dl->download_count }}/{{ $dl->max_downloads }} downloads used
          <a href="{{ route('downloads.show', $dl->token) }}" style="color:var(--primary);margin-left:0.5rem;">Link</a>
        </li>
      @endforeach
    </ul>
    @endif
  </div>

  <div class="glass-card rounded-2xl" style="padding:1.5rem;">
    <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Customer</h2>
    <p><strong>{{ $order->name }}</strong><br>{{ $order->email }}</p>

    <h2 style="font-family:var(--font-display);margin:1.5rem 0 1rem;">Payment</h2>
    <p>Method: {{ ucfirst($order->payment_method) }}<br>
    Gateway: {{ ucfirst($order->payment_gateway ?? '-') }}<br>
    Reference: {{ $order->payment_reference ?? '-' }}<br>
    Paid at: {{ $order->paid_at?->format('M j, Y g:ia') ?? 'Not paid' }}</p>

    <h2 style="font-family:var(--font-display);margin:1.5rem 0 1rem;">Update Status</h2>
    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
      @csrf @method('PUT')
      <select name="status" class="magic-input" style="width:100%;margin-bottom:0.75rem;">
        @foreach(['pending','pending_payment','confirmed','shipped','fulfilled','cancelled','failed','refunded'] as $s)
          <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
        @endforeach
      </select>
      <button type="submit" class="magic-btn magic-btn-primary" style="width:100%;">Save Status</button>
    </form>
  </div>
</div>
@endsection
