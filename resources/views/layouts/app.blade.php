<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="cart-count" content="{{ count(session('cart', [])) }}">
  <title>@yield('title', 'Spell Enchantment') — Ancient Knowledge · Mystical Arts</title>
  <link rel="stylesheet" href="{{ asset('css/arcane.css') }}">
  @stack('head')
</head>
<body>

<!-- Magic Cursor -->
<div id="magic-cursor"></div>

<!-- Particle Background -->
<canvas id="particle-canvas"></canvas>

<!-- Navbar -->
<nav id="navbar">
  <div class="container nav-inner">
    <a href="{{ route('home') }}" class="nav-logo">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
      </svg>
      Spell Enchantment
    </a>

    <div class="nav-links">
      <a href="{{ route('home') }}"          class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ route('shop.index') }}"    class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
      <a href="{{ route('library.index') }}" class="nav-link {{ request()->routeIs('library.*') ? 'active' : '' }}">Library</a>
      <a href="{{ route('blog.index') }}"    class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
    </div>

    <div class="nav-icons">
      <a href="{{ route('cart.index') }}" class="nav-icon-btn" style="display:flex;align-items:center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        @php $cartCount = count(session('cart', [])) @endphp
        @if($cartCount > 0)
          <span class="cart-badge" id="cart-badge">{{ $cartCount }}</span>
        @else
          <span class="cart-badge" id="cart-badge" style="display:none">0</span>
        @endif
      </a>
      <button class="mobile-toggle" id="mobile-toggle" aria-label="Menu">
        <svg id="icon-menu" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobile-menu">
    <a href="{{ route('home') }}"          class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('shop.index') }}"    class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
    <a href="{{ route('library.index') }}" class="{{ request()->routeIs('library.*') ? 'active' : '' }}">Library</a>
    <a href="{{ route('blog.index') }}"    class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
    <a href="{{ route('cart.index') }}">Cart ({{ $cartCount ?? 0 }})</a>
  </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
  <div style="position:fixed;top:5rem;right:1rem;z-index:100;max-width:20rem;">
    <div class="alert alert-success">{{ session('success') }}</div>
  </div>
@endif

<!-- Page Content -->
<div class="page-content" style="min-height:100vh;display:flex;flex-direction:column;">
  <main style="flex:1;">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-grid">
        <div>
          <div class="footer-logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            Spell Enchantment
          </div>
          <p class="footer-desc font-serif text-muted" style="font-family:var(--font-serif)">
            Discover forbidden spells, mystical artifacts, and sacred grimoires. The ultimate digital repository for seekers of the arcane arts.
          </p>
        </div>
        <div>
          <h3 class="footer-heading">Explore</h3>
          <ul class="footer-links">
            <li><a href="{{ route('shop.index') }}">Mystical Artifacts</a></li>
            <li><a href="{{ route('library.index') }}">The Grand Library</a></li>
            <li><a href="{{ route('blog.index') }}">Scholar's Blog</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-heading">Support</h3>
          <ul class="footer-links">
            <li><a href="#">Orders & Returns</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Contact the Keepers</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p class="footer-copy">© {{ date('Y') }} Spell Enchantment. All rights reserved.</p>
        <div class="footer-legal">
          <a href="#">Privacy</a>
          <a href="#">Terms</a>
        </div>
      </div>
    </div>
  </footer>
</div>

<script src="{{ asset('js/arcane.js') }}"></script>
@stack('scripts')
</body>
</html>
