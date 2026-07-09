@extends('layouts.app')
@section('title', 'The Grand Library — Arcane Sanctum')

@section('content')
<div style="padding-top:6rem;padding-bottom:5rem;position:relative;">
  <div class="glow-blob glow-purple glow-xl" style="position:fixed;top:-10rem;left:-10rem;opacity:0.15;"></div>

  <div class="container" style="position:relative;z-index:1;">

    {{-- HEADER --}}
    <div style="max-width:48rem;margin:0 auto;text-align:center;margin-bottom:4rem;" data-fadein>
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
           style="color:var(--accent);margin:0 auto 1.5rem;display:block;">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
      </svg>
      <h1 style="font-family:var(--font-display);font-size:clamp(2rem,6vw,4rem);font-weight:700;margin-bottom:1.5rem;">The Grand Library</h1>
      <p style="font-family:var(--font-serif);font-size:1.2rem;color:var(--muted-fg);">
        A repository of arcane knowledge, spells, and forgotten rituals.<br>Tread carefully, for some pages turn themselves.
      </p>
    </div>

    {{-- TABS --}}
    <div class="library-tabs" data-fadein data-delay="100">
      @foreach($categories as $cat)
        <button class="library-tab {{ $activeTab === $cat ? 'active' : '' }}" data-tab="{{ $cat }}">
          {{ $cat }}
        </button>
      @endforeach
    </div>

    {{-- GRID --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;">
      @foreach($filtered as $i => $entry)
      <div data-fadein data-delay="{{ min($i * 60, 300) }}" data-category-filter="{{ $entry->category }}">
        <a href="{{ route('library.show', $entry->slug) }}" style="display:block;height:100%;">
          <div class="glass-card rounded-xl" style="padding:1.5rem;height:100%;display:flex;flex-direction:column;border-color:rgba(255,255,255,0.05);position:relative;overflow:hidden;">
            <div style="position:absolute;bottom:-2.5rem;right:-2.5rem;opacity:0.05;">
              <svg width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
              </svg>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:1rem;">
              <span style="font-family:var(--font-sans);font-size:0.7rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);">{{ $entry->category }}</span>
              @if($entry->difficulty)
                <span class="difficulty-badge {{ $entry->difficulty_color }}">{{ $entry->difficulty }}</span>
              @endif
            </div>

            <h2 style="font-family:var(--font-display);font-size:1.25rem;font-weight:700;color:var(--foreground);margin-bottom:0.75rem;position:relative;z-index:1;transition:color 0.3s;">{{ $entry->title }}</h2>
            <p style="font-family:var(--font-serif);color:var(--muted-fg);font-size:0.875rem;line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:1.5rem;position:relative;z-index:1;">{{ $entry->excerpt }}</p>

            @if($entry->tags)
            <div style="margin-top:auto;display:flex;gap:0.35rem;flex-wrap:wrap;position:relative;z-index:1;">
              @foreach(array_slice($entry->tags, 0, 3) as $tag)
                <span style="font-size:0.65rem;font-family:var(--font-sans);color:var(--muted-fg);background:rgba(0,0,0,0.4);padding:0.2rem 0.4rem;border-radius:4px;">#{{ $tag }}</span>
              @endforeach
            </div>
            @endif
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
