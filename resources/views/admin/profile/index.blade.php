@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:40rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1rem;">My Profile</h1>
      <p style="color:var(--muted-fg);margin-bottom:1rem;">Manage your admin profile details.</p>
      <div style="display:flex;flex-direction:column;gap:0.75rem;">
        <div><strong>Name:</strong> {{ $user->name }}</div>
        <div><strong>Email:</strong> {{ $user->email }}</div>
        <div><strong>Role:</strong> {{ $user->role }}</div>
        <div><strong>Status:</strong> {{ $user->status }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
