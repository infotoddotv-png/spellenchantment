@extends('layouts.admin')
@section('title', 'Tools')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:48rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1.5rem;">Tools</h1>
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <form method="POST" action="{{ route('admin.tools.cache-clear') }}">
          @csrf
          <button class="magic-btn magic-btn-outline" type="submit">Clear Cache</button>
        </form>
        <a href="{{ route('admin.tools.backup') }}" class="magic-btn magic-btn-primary" style="display:inline-flex;max-width:12rem;justify-content:center;">Download Backup</a>
      </div>
    </div>
  </div>
</div>
@endsection
