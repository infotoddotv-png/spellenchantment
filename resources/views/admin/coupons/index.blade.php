@extends('layouts.admin')
@section('title', 'Coupons')

@section('content')
<div class="admin-page-head">
  <div>
    <h1>Coupons</h1>
    <p>Create discount codes to drive conversions.</p>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:1.25rem;">
  <div class="glass-card rounded-2xl" style="padding:1.5rem;">
    <h2 style="font-family:var(--font-display);margin-bottom:1rem;">New Coupon</h2>
    <form method="POST" action="{{ route('admin.coupons.store') }}">
      @csrf
      <div style="margin-bottom:0.75rem;">
        <label>Code</label>
        <input type="text" name="code" class="magic-input" style="width:100%;" required placeholder="SPELL20">
      </div>
      <div class="admin-form-grid" style="margin-bottom:0.75rem;">
        <div>
          <label>Type</label>
          <select name="type" class="magic-input" style="width:100%;">
            <option value="percent">Percent %</option>
            <option value="fixed">Fixed $</option>
          </select>
        </div>
        <div>
          <label>Value</label>
          <input type="number" step="0.01" name="value" class="magic-input" style="width:100%;" required>
        </div>
      </div>
      <div class="admin-form-grid" style="margin-bottom:0.75rem;">
        <div>
          <label>Usage limit</label>
          <input type="number" name="usage_limit" class="magic-input" style="width:100%;" placeholder="Unlimited">
        </div>
        <div>
          <label>Min order total</label>
          <input type="number" step="0.01" name="min_order_total" class="magic-input" style="width:100%;">
        </div>
      </div>
      <div style="margin-bottom:0.75rem;">
        <label>Expires at</label>
        <input type="date" name="expires_at" class="magic-input" style="width:100%;">
      </div>
      <label style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
        <input type="checkbox" name="active" value="1" checked> Active
      </label>
      <button type="submit" class="magic-btn magic-btn-primary" style="width:100%;">Create Coupon</button>
    </form>
  </div>

  <div class="glass-card rounded-2xl admin-table-wrap" style="padding:0.5rem;">
    <table class="admin-table">
      <thead><tr><th>Code</th><th>Discount</th><th>Used</th><th>Expires</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse($coupons as $coupon)
        <tr>
          <td><strong>{{ $coupon->code }}</strong></td>
          <td>{{ $coupon->type === 'percent' ? $coupon->value.'%' : '$'.number_format($coupon->value,2) }}</td>
          <td>{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / '.$coupon->usage_limit : '' }}</td>
          <td>{{ $coupon->expires_at?->format('M j, Y') ?? 'Never' }}</td>
          <td><span class="badge badge-{{ $coupon->active ? 'active' : 'inactive' }}">{{ $coupon->active ? 'Active' : 'Inactive' }}</span></td>
          <td style="text-align:right;white-space:nowrap;">
            <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" style="display:inline;">
              @csrf @method('PUT')
              <input type="hidden" name="active" value="{{ $coupon->active ? 0 : 1 }}">
              <button type="submit" style="background:none;border:none;color:var(--primary);cursor:pointer;">{{ $coupon->active ? 'Disable' : 'Enable' }}</button>
            </form>
            <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" style="background:none;border:none;color:#ff7b7b;cursor:pointer;">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:var(--muted-fg);padding:2rem;">No coupons yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
