@extends('layouts.app')
@section('title', 'Spell Enchantment')

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────────────── --}}
<section class="hero">
  <div class="glow-blob glow-purple glow-xl" style="top:-5rem;left:-5rem;opacity:0.45;"></div>
  <div class="glow-blob glow-gold glow-lg"   style="bottom:5rem;right:-5rem;opacity:0.3;"></div>

  <div class="hero-bg">
    <img src="{{ asset('images/hero-bg.jpg') }}" alt="Arcane Library" onerror="this.style.display='none'">
    <div class="hero-overlay"></div>
  </div>

  <div class="hero-content" data-fadein>
    <div style="margin-bottom:1.5rem;">
      <svg class="animate-spin-slow" style="width:4rem;height:4rem;color:var(--primary);display:inline-block;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
      </svg>
    </div>

    <h1 class="hero-title fade-in-up">
      Welcome to<br>
      <span>Spell Enchantment</span>
    </h1>

    <p class="hero-sub fade-in-up-delay-1">
      Ancient Knowledge &bull; Mystical Arts &bull; Digital Grimoires
    </p>

    <div class="btn-group fade-in-up-delay-2">
      <a href="{{ route('shop.index') }}" class="magic-btn magic-btn-primary">Browse Artifacts</a>
      <a href="{{ route('library.index') }}" class="magic-btn magic-btn-outline">Explore Library</a>
    </div>
  </div>

  <div class="hero-scroll-indicator animate-bounce">
    <span>Descend</span>
    <div class="scroll-line"></div>
  </div>
</section>

{{-- ── FEATURED PRODUCTS ────────────────────────────────────────────────── --}}
<section class="py-24" style="position:relative;z-index:1;">
  <div class="container">
    <div class="section-header" data-fadein>
      <h2>Sacred Relics</h2>
      <div class="section-divider"></div>
    </div>

    <div class="product-grid">
      @foreach($featuredProducts as $i => $product)
      <div data-fadein data-delay="{{ $i * 100 }}">
        <a href="{{ route('shop.show', $product->slug) }}" style="display:block;">
          <div class="glass-card product-card">
            <div class="product-card-image">
              @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
              @else
                <div style="width:100%;height:100%;background:var(--secondary);display:flex;align-items:center;justify-content:center;">
                  <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color:var(--muted-fg)">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                  </svg>
                </div>
              @endif
              <div class="product-card-gradient"></div>
              <div class="product-card-badges">
                @if($product->is_new)<span class="badge-new">New</span>@endif
                @if($product->category)<span class="badge-cat">{{ $product->category->name }}</span>@endif
              </div>
            </div>
            <div class="product-card-body">
              <div class="product-card-name">{{ $product->name }}</div>
              <div class="product-card-desc">{{ $product->description }}</div>
              <div class="product-card-footer">
                <span class="product-price">${{ number_format($product->price, 2) }}</span>
                <span class="product-stars">{{ $product->stars_html }}</span>
              </div>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>

    <div style="text-align:center;margin-top:3rem;">
      <a href="{{ route('shop.index') }}" class="magic-btn magic-btn-outline">View All Relics</a>
    </div>
  </div>
</section>

{{-- ── DIVIDER ──────────────────────────────────────────────────────────── --}}
<div style="display:flex;align-items:center;justify-content:center;padding:1rem 0;opacity:0.5;">
  <div style="flex:1;max-width:250px;height:1px;background:linear-gradient(to right,transparent,var(--primary));"></div>
  <svg style="margin:0 1rem;width:1rem;height:1rem;color:var(--primary);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
  </svg>
  <div style="flex:1;max-width:250px;height:1px;background:linear-gradient(to left,transparent,var(--primary));"></div>
</div>

{{-- ── LIBRARY PREVIEW ──────────────────────────────────────────────────── --}}
<section class="py-24" style="position:relative;z-index:1;overflow:hidden;">
  <div class="glow-blob glow-cyan glow-lg" style="top:50%;right:-5rem;transform:translateY(-50%);"></div>
  <div class="container">
    <div class="section-header" data-fadein>
      <h2>The Grand Library</h2>
      <div class="section-divider section-divider-accent"></div>
      <p class="section-sub">Delve into centuries of gathered wisdom. From beginner rituals to advanced enchantments.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;">
      @foreach($libraryEntries as $i => $entry)
      <div data-fadein data-delay="{{ $i * 150 }}">
        <a href="{{ route('library.show', $entry->slug) }}" style="display:block;height:100%;">
          <div class="glass-card rounded-xl" style="padding:1.5rem;height:100%;display:flex;flex-direction:column;border-color:rgba(255,255,255,0.05);position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;right:0;width:8rem;height:8rem;background:rgba(124,58,237,0.05);border-radius:0 0 0 100%;z-index:0;"></div>
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;position:relative;z-index:1;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--accent);">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
              </svg>
              <span style="font-family:var(--font-sans);font-size:0.7rem;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted-fg);">{{ $entry->category }}</span>
            </div>
            <h3 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:0.75rem;color:var(--foreground);position:relative;z-index:1;">{{ $entry->title }}</h3>
            <p style="font-family:var(--font-serif);color:var(--muted-fg);font-size:0.875rem;flex-grow:1;margin-bottom:1.5rem;position:relative;z-index:1;">{{ $entry->excerpt }}</p>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.05);">
              <span class="difficulty-badge {{ $entry->difficulty_color }}" style="font-size:0.7rem;padding:0.2rem 0.5rem;">{{ $entry->difficulty }}</span>
              <span style="font-family:var(--font-sans);font-size:0.75rem;color:var(--primary);">Read entry →</span>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ── STATS ────────────────────────────────────────────────────────────── --}}
<section style="padding:5rem 0;background:rgba(0,0,0,0.4);border-top:1px solid rgba(255,255,255,0.05);border-bottom:1px solid rgba(255,255,255,0.05);">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-item" data-fadein data-delay="100">
        <div class="stat-number text-primary">{{ $stats['totalProducts'] }}</div>
        <div class="stat-label">Artifacts</div>
      </div>
      <div class="stat-item" data-fadein data-delay="200">
        <div class="stat-number" style="color:var(--accent);">{{ $stats['totalLibraryEntries'] }}</div>
        <div class="stat-label">Grimoires</div>
      </div>
      <div class="stat-item" data-fadein data-delay="300">
        <div class="stat-number text-white">{{ $stats['totalOrders'] }}+</div>
        <div class="stat-label">Seekers</div>
      </div>
      <div class="stat-item" data-fadein data-delay="400">
        <div class="stat-number text-primary">{{ $stats['totalBlogPosts'] }}</div>
        <div class="stat-label">Chronicles</div>
      </div>
    </div>
  </div>
</section>

{{-- ── TESTIMONIALS ─────────────────────────────────────────────────────── --}}
@if($testimonials->isNotEmpty())
<section class="py-24" style="position:relative;z-index:1;">
  <div class="container">
    <div class="section-header" data-fadein>
      <h2>Voices from the Sanctum</h2>
      <div class="section-divider"></div>
    </div>
    <div class="testimonials-grid">
      @foreach($testimonials as $t)
      <div class="glass-card testimonial-card" data-fadein>
        <div class="testimonial-stars">{{ $t->stars_html }}</div>
        <p class="testimonial-content">"{{ $t->content }}"</p>
        <div>
          <div class="testimonial-author">{{ $t->author }}</div>
          <div class="testimonial-location">{{ $t->location }}</div>
          @if($t->product)
            <div style="font-family:var(--font-sans);font-size:0.7rem;color:var(--primary);margin-top:0.25rem;">{{ $t->product }}</div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection
