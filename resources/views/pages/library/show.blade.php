@extends('layouts.app')
@section('title', $entry->title . ' — The Grand Library')

@section('content')
<div style="padding-top:6rem;padding-bottom:6rem;position:relative;overflow:hidden;">
  <div class="glow-blob glow-purple glow-lg" style="top:5rem;left:-5rem;opacity:0.2;"></div>

  <div class="container" style="max-width:48rem;">
    <a href="{{ route('library.index') }}" style="display:inline-flex;align-items:center;gap:0.5rem;font-family:var(--font-sans);font-size:0.875rem;color:var(--muted-fg);margin-bottom:2rem;transition:color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">
      ← Back to Library
    </a>

    <div data-fadein>
      <div style="display:flex;justify-content:space-between;align-items:start;flex-wrap:wrap;gap:0.75rem;margin-bottom:1.5rem;">
        <span style="font-family:var(--font-sans);font-size:0.75rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);">{{ $entry->category }}</span>
        <span class="difficulty-badge {{ $entry->difficulty_color }}">{{ $entry->difficulty }}</span>
      </div>

      <h1 style="font-family:var(--font-display);font-size:clamp(1.75rem,5vw,3rem);font-weight:700;margin-bottom:1.5rem;line-height:1.2;">{{ $entry->title }}</h1>

      @if($entry->tags)
      <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:2rem;">
        @foreach($entry->tags as $tag)
          <span style="font-size:0.75rem;font-family:var(--font-sans);color:var(--muted-fg);background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);padding:0.25rem 0.6rem;border-radius:9999px;">#{{ $tag }}</span>
        @endforeach
      </div>
      @endif

      <div class="glass-card rounded-xl" style="padding:0.5rem;margin-bottom:2rem;">
        <div style="background:rgba(201,168,76,0.04);border-radius:0.6rem;padding:1.5rem;border-left:3px solid var(--primary);">
          <p style="font-family:var(--font-serif);font-size:1.1rem;font-style:italic;color:rgba(255,255,255,0.85);line-height:1.7;">{{ $entry->excerpt }}</p>
        </div>
      </div>

      <div style="font-family:var(--font-serif);font-size:1.05rem;line-height:1.9;color:rgba(255,255,255,0.8);">
        {!! nl2br(e($entry->content)) !!}
      </div>
    </div>

    <div style="margin-top:4rem;padding-top:2rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;gap:1rem;flex-wrap:wrap;">
      <a href="{{ route('library.index') }}" class="magic-btn magic-btn-outline">← Return to Library</a>
      <a href="{{ route('shop.index') }}" class="magic-btn magic-btn-primary">Browse Artifacts</a>
    </div>
  </div>
</div>
@endsection
