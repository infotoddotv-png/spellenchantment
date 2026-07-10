@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="admin-page-head">
  <div>
    <h1>Orders</h1>
    <p>Track and fulfill customer orders.</p>
  </div>
</div>

<div class="admin-stats-grid">
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Total Orders</div>
    <div style="font-size:1.6rem;font-weight:700;">{{ $stats['total'] }}</div>
  </div>
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Revenue</div>
    <div style="font-size:1.6rem;font-weight:700;">${{ number_format($stats['revenue'], 2) }}</div>
  </div>
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Pending</div>
    <div style="font-size:1.6rem;font-weight:700;">{{ $stats['pending'] }}</div>
  </div>
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Today</div>
    <div style="font-size:1.6rem;font-weight:700;">{{ $stats['today'] }}</div>
  </div>
</div>

<form method="GET" style="display:flex;gap:0.75rem;margin-bottom:1.25rem;flex-wrap:wrap;">
  <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or ID" class="magic-input" style="flex:1;min-width:220px;">
  <select name="status" class="magic-input" style="max-width:200px;">
    <option value="">All statuses</option>
    @foreach(['pending','pending_payment','confirmed','shipped','fulfilled','cancelled','failed','refunded'] as $s)
      <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
    @endforeach
  </select>
  <button type="submit" class="magic-btn magic-btn-primary">Filter</button>
</form>

<div class="glass-card rounded-2xl admin-table-wrap" style="padding:0.5rem;">
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th><th>Customer</th><th>Total</th><th>Gateway</th><th>Status</th><th>Date</th><th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
      <tr>
        <td>#{{ $order->id }}</td>
        <td>{{ $order->name }}<br><span style="color:var(--muted-fg);font-size:0.8rem;">{{ $order->email }}</span></td>
        <td>${{ number_format($order->total, 2) }}</td>
        <td>{{ ucfirst($order->payment_gateway ?? '-') }}</td>
        <td><span class="badge badge-{{ $order->status }}">{{ str_replace('_',' ',$order->status) }}</span></td>
        <td>{{ $order->created_at->format('M j, Y') }}</td>
        <td style="text-align:right;"><a href="{{ route('admin.orders.show', $order) }}" style="color:var(--primary);">View</a></td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;color:var(--muted-fg);padding:2rem;">No orders found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:1rem;">{{ $orders->links() }}</div>
@endsection
