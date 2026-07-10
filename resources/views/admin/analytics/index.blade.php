@extends('layouts.admin')
@section('title', 'Analytics')

@section('content')
<div class="admin-page-head">
  <div>
    <h1>Analytics</h1>
    <p>Store performance over the last 30 days.</p>
  </div>
</div>

<div class="admin-stats-grid">
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Total Revenue</div>
    <div style="font-size:1.6rem;font-weight:700;">${{ number_format($totalRevenue, 2) }}</div>
  </div>
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Total Orders</div>
    <div style="font-size:1.6rem;font-weight:700;">{{ $totalOrders }}</div>
  </div>
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Avg Order Value</div>
    <div style="font-size:1.6rem;font-weight:700;">${{ number_format($avgOrderValue, 2) }}</div>
  </div>
  <div class="glass-card rounded-2xl" style="padding:1.1rem;">
    <div style="font-size:0.75rem;text-transform:uppercase;color:var(--muted-fg);">Conversion Rate</div>
    <div style="font-size:1.6rem;font-weight:700;">{{ $conversion }}%</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.25rem;">
  <div class="glass-card rounded-2xl" style="padding:1.5rem;">
    <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Revenue (30 days)</h2>
    <div style="display:flex;align-items:flex-end;gap:2px;height:180px;">
      @php $max = max(1, $revenueByDay->max('revenue')); @endphp
      @foreach($revenueByDay as $day)
        <div title="{{ $day['label'] }}: ${{ number_format($day['revenue'],2) }}" style="flex:1;background:var(--primary);opacity:0.75;height:{{ max(2, ($day['revenue']/$max)*100) }}%;border-radius:2px 2px 0 0;"></div>
      @endforeach
    </div>
    <div style="display:flex;justify-content:space-between;color:var(--muted-fg);font-size:0.75rem;margin-top:0.5rem;">
      <span>{{ $revenueByDay->first()['label'] }}</span>
      <span>{{ $revenueByDay->last()['label'] }}</span>
    </div>
  </div>

  <div class="glass-card rounded-2xl" style="padding:1.5rem;">
    <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Order Status</h2>
    @foreach($statusBreakdown as $status => $count)
      <div style="display:flex;justify-content:space-between;padding:0.4rem 0;border-bottom:1px solid rgba(255,255,255,0.05);">
        <span class="badge badge-{{ $status }}">{{ str_replace('_',' ',$status) }}</span>
        <span>{{ $count }}</span>
      </div>
    @endforeach
  </div>
</div>

<div class="glass-card rounded-2xl admin-table-wrap" style="padding:1rem;margin-top:1.25rem;">
  <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Top Products</h2>
  <table class="admin-table">
    <thead><tr><th>Product</th><th>Units Sold</th><th>Revenue</th></tr></thead>
    <tbody>
      @forelse($topProducts as $p)
      <tr><td>{{ $p['name'] }}</td><td>{{ $p['qty'] }}</td><td>${{ number_format($p['revenue'],2) }}</td></tr>
      @empty
      <tr><td colspan="3" style="text-align:center;color:var(--muted-fg);padding:2rem;">No sales yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
