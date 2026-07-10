@extends('layouts.admin')
@section('title', 'Payment Settings')

@section('content')
<div class="admin-page-head">
  <div>
    <h1>Payment Gateways</h1>
    <p>Configure Stripe, PayPal, and manual payment options.</p>
  </div>
</div>

<form method="POST" action="{{ route('admin.payments.store') }}">
  @csrf
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
    <div class="glass-card rounded-2xl" style="padding:1.5rem;">
      <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Stripe</h2>
      <label>Publishable Key</label>
      <input type="text" name="stripe_publishable_key" value="{{ $settings['stripe_publishable_key'] ?? '' }}" class="magic-input" style="width:100%;margin-bottom:0.75rem;">
      <label>Secret Key</label>
      <input type="password" name="stripe_secret_key" value="{{ $settings['stripe_secret_key'] ?? '' }}" class="magic-input" style="width:100%;margin-bottom:0.75rem;">
      <label>Webhook Secret</label>
      <input type="password" name="stripe_webhook_secret" value="{{ $settings['stripe_webhook_secret'] ?? '' }}" class="magic-input" style="width:100%;">
      <p style="color:var(--muted-fg);font-size:0.8rem;margin-top:0.75rem;">Webhook URL: <code>{{ url('/webhooks/stripe') }}</code></p>
    </div>

    <div class="glass-card rounded-2xl" style="padding:1.5rem;">
      <h2 style="font-family:var(--font-display);margin-bottom:1rem;">PayPal</h2>
      <label>Client ID</label>
      <input type="text" name="paypal_client_id" value="{{ $settings['paypal_client_id'] ?? '' }}" class="magic-input" style="width:100%;margin-bottom:0.75rem;">
      <label>Secret</label>
      <input type="password" name="paypal_secret" value="{{ $settings['paypal_secret'] ?? '' }}" class="magic-input" style="width:100%;margin-bottom:0.75rem;">
      <label>Mode</label>
      <select name="paypal_mode" class="magic-input" style="width:100%;">
        <option value="sandbox" {{ ($settings['paypal_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
        <option value="live" {{ ($settings['paypal_mode'] ?? '') === 'live' ? 'selected' : '' }}>Live</option>
      </select>
    </div>

    <div class="glass-card rounded-2xl" style="padding:1.5rem;">
      <h2 style="font-family:var(--font-display);margin-bottom:1rem;">Manual Payment</h2>
      <label>Instructions shown to customer</label>
      <textarea name="manual_instructions" rows="8" class="magic-input" style="width:100%;">{{ $settings['manual_instructions'] ?? '' }}</textarea>
    </div>
  </div>

  <button type="submit" class="magic-btn magic-btn-primary" style="margin-top:1.25rem;">Save Payment Settings</button>
</form>
@endsection
