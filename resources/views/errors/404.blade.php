@extends('layouts.app')
@section('title', '404 — Page Lost to Time')
@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:2rem;">
  <div>
    <div style="font-family:var(--font-display);font-size:8rem;font-weight:800;color:var(--primary);opacity:0.3;line-height:1;margin-bottom:1rem;">404</div>
    <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;margin-bottom:1rem;">Page Lost to Time</h1>
    <p style="font-family:var(--font-serif);color:var(--muted-fg);margin-bottom:2rem;max-width:30rem;">The page you seek has been lost to the ages, consumed by the void between dimensions.</p>
    <a href="{{ route('home') }}" class="magic-btn magic-btn-primary">Return to Sanctum</a>
  </div>
</div>
@endsection
