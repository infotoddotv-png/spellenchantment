@extends('layouts.app')
@section('title', $post->title . ' — Arcane Sanctum')

@section('content')
<div style="padding-top:6rem;padding-bottom:6rem;position:relative;overflow:hidden;">
  <div class="glow-blob glow-purple glow-lg" style="top:5rem;right:-5rem;opacity:0.2;"></div>
  <div class="container" style="max-width:52rem;">

    <a href="{{ route('blog.index') }}" style="display:inline-flex;align-items:center;gap:0.5rem;font-family:var(--font-sans);font-size:0.875rem;color:var(--muted-fg);margin-bottom:2rem;transition:color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">
      ← Back to Chronicles
    </a>

    <div data-fadein>
      {{-- Meta --}}
      <div style="display:flex;align-items:center;gap:1rem;font-family:var(--font-sans);font-size:0.75rem;color:var(--muted-fg);margin-bottom:1.5rem;flex-wrap:wrap;">
        <span>{{ $post->formatted_date }}</span>
        <span>•</span>
        <span>{{ $post->reading_time }} min read</span>
        @if($post->tags)
          @foreach(array_slice($post->tags,0,3) as $tag)
            <span style="background:rgba(255,255,255,0.05);padding:0.15rem 0.5rem;border-radius:4px;">#{{ $tag }}</span>
          @endforeach
        @endif
      </div>

      <h1 style="font-family:var(--font-display);font-size:clamp(2rem,5vw,3.25rem);font-weight:700;line-height:1.2;margin-bottom:2rem;">{{ $post->title }}</h1>

      {{-- Hero image --}}
      @if($post->image_url)
        <div style="border-radius:1rem;overflow:hidden;margin-bottom:2.5rem;aspect-ratio:2/1;">
          <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="width:100%;height:100%;object-fit:cover;opacity:0.9;">
        </div>
      @endif

      {{-- Author --}}
      <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:2.5rem;padding-bottom:2rem;border-bottom:1px solid rgba(255,255,255,0.08);">
        <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:var(--secondary);flex-shrink:0;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:0.875rem;color:var(--primary);">
          {{ strtoupper(substr($post->author,0,1)) }}
        </div>
        <div>
          <div style="font-family:var(--font-sans);font-weight:600;font-size:0.9rem;">{{ $post->author }}</div>
          <div style="font-family:var(--font-sans);font-size:0.75rem;color:var(--muted-fg);">Scholar of the Sanctum</div>
        </div>
      </div>

      {{-- Content --}}
      <div style="font-family:var(--font-serif);font-size:1.1rem;line-height:1.9;color:rgba(255,255,255,0.85);">
        {!! nl2br(e($post->content)) !!}
      </div>
    </div>

    <div style="margin-top:4rem;padding-top:2rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;gap:1rem;flex-wrap:wrap;">
      <a href="{{ route('blog.index') }}" class="magic-btn magic-btn-outline">← All Chronicles</a>
      <a href="{{ route('shop.index') }}" class="magic-btn magic-btn-primary">Visit the Shop</a>
    </div>
  </div>
</div>
@endsection
