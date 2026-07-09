@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div style="padding:7rem 0 5rem;">
  <div class="container" style="max-width:32rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.8rem;font-weight:700;margin-bottom:1rem;">Welcome back</h1>
      <p style="color:var(--muted-fg);margin-bottom:1.5rem;">Log in to continue your Spell Enchantment journey.</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" required>
        </div>
        <label style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
          <input type="checkbox" name="remember" value="1">
          <span>Remember me</span>
        </label>
        <button type="submit" class="magic-btn magic-btn-primary" style="width:100%;justify-content:center;">Log in</button>
      </form>

      <p style="margin-top:1rem;color:var(--muted-fg);">
        New here? <a href="{{ route('register') }}" style="color:var(--primary);">Create account</a>
      </p>
    </div>
  </div>
</div>
@endsection
