@extends('layouts.app')
@section('title', "The Scholar's Chronicles — Arcane Sanctum")

@section('content')
<div style="padding-top:6rem;padding-bottom:5rem;">
  <div class="container">

    <div class="page-header" data-fadein>
      <h1 class="page-title">The Scholar's Chronicles</h1>
      <div class="page-divider"></div>
      <p style="font-family:var(--font-serif);color:var(--muted-fg);max-width:40rem;margin:0 auto;">Tales, discoveries, and warnings from the masters of the Sanctum.</p>
    </div>

    {{-- FEATURED POST --}}
    @if($featuredPost)
    <div style="margin-bottom:5rem;" data-fadein data-delay="100">
      <a href="{{ route('blog.show', $featuredPost->slug) }}" style="display:block;">
        <div class="glass-card blog-featured" style="border-color:rgba(255,255,255,0.1);">
          <div class="blog-featured-image">
            @if($featuredPost->image_url)
              <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->title }}">
            @else
              <div style="width:100%;height:100%;min-height:250px;background:linear-gradient(135deg,var(--secondary),var(--muted));display:flex;align-items:center;justify-content:center;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:rgba(255,255,255,0.15)">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
              </div>
            @endif
            <span class="blog-badge-featured">Featured</span>
          </div>
          <div class="blog-featured-body">
            <div class="blog-meta">
              <span style="display:flex;align-items:center;gap:0.3rem;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $featuredPost->formatted_date }}
              </span>
              <span style="display:flex;align-items:center;gap:0.3rem;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $featuredPost->reading_time }} min read
              </span>
            </div>
            <h2 style="font-family:var(--font-display);font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;margin-bottom:1rem;color:var(--foreground);transition:color 0.3s;line-height:1.25;">{{ $featuredPost->title }}</h2>
            <p style="font-family:var(--font-serif);color:var(--muted-fg);font-size:1.1rem;line-height:1.6;margin-bottom:2rem;">{{ $featuredPost->excerpt }}</p>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:auto;">
              <span style="font-family:var(--font-sans);font-size:0.9rem;font-weight:500;">{{ $featuredPost->author }}</span>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary);">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
              </svg>
            </div>
          </div>
        </div>
      </a>
    </div>
    @endif

    {{-- POST GRID --}}
    <div class="blog-cards">
      @foreach($regularPosts as $i => $post)
      <div data-fadein data-delay="{{ 200 + $i * 100 }}">
        <a href="{{ route('blog.show', $post->slug) }}" style="display:block;height:100%;">
          <div class="glass-card blog-card">
            <div class="blog-card-image">
              @if($post->image_url)
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
              @else
                <div style="width:100%;height:100%;min-height:120px;background:linear-gradient(135deg,var(--secondary),var(--muted));"></div>
              @endif
            </div>
            <div class="blog-card-body">
              <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.65rem;font-family:var(--font-sans);color:var(--muted-fg);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem;">
                <span>{{ $post->formatted_date }}</span>
                <span>•</span>
                <span>{{ $post->reading_time }} min read</span>
              </div>
              <h3 style="font-family:var(--font-display);font-size:1.15rem;font-weight:700;color:var(--foreground);margin-bottom:0.75rem;line-height:1.3;transition:color 0.3s;">{{ $post->title }}</h3>
              <p style="font-family:var(--font-serif);color:var(--muted-fg);font-size:0.875rem;line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:1.5rem;">{{ $post->excerpt }}</p>
              <div class="blog-card-footer">
                <span style="font-family:var(--font-sans);font-size:0.8rem;color:rgba(255,255,255,0.7);">{{ $post->author }}</span>
                <span style="font-family:var(--font-sans);font-size:0.7rem;color:var(--primary);text-transform:uppercase;letter-spacing:0.1em;font-weight:700;">Read</span>
              </div>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>

  </div>
</div>
@endsection
