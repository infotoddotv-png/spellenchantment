@extends('layouts.app')
@section('title', 'Create Account')

@section('content')
<div style="padding:7rem 0 5rem;">
  <div class="container" style="max-width:36rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.8rem;font-weight:700;margin-bottom:1rem;">Create your account</h1>
      <p style="color:var(--muted-fg);margin-bottom:1.5rem;">Register to shop, save your cart, and track orders.</p>

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" required>
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-input" required>
        </div>
        <button type="submit" class="magic-btn magic-btn-primary" style="width:100%;justify-content:center;">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
