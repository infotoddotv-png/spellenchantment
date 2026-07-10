<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') — Spell Enchantment Console</title>
  <link rel="stylesheet" href="{{ asset('css/arcane.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  @stack('head')
</head>
<body class="admin-body">

@php
  $navGroups = [
    'Overview' => [
      ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'grid'],
      ['route' => 'admin.analytics.index', 'pattern' => 'admin.analytics.*', 'label' => 'Analytics', 'icon' => 'chart'],
    ],
    'Sales' => [
      ['route' => 'admin.orders.index', 'pattern' => 'admin.orders.*', 'label' => 'Orders', 'icon' => 'box'],
      ['route' => 'admin.shop.index', 'pattern' => 'admin.shop.*', 'label' => 'Products', 'icon' => 'tag'],
      ['route' => 'admin.coupons.index', 'pattern' => 'admin.coupons.*', 'label' => 'Coupons', 'icon' => 'percent'],
    ],
    'Content' => [
      ['route' => 'admin.blog.index', 'pattern' => 'admin.blog.*', 'label' => 'Blog Posts', 'icon' => 'file'],
      ['route' => 'admin.library.index', 'pattern' => 'admin.library.*', 'label' => 'Library', 'icon' => 'book'],
    ],
    'People' => [
      ['route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'label' => 'Users', 'icon' => 'users'],
      ['route' => 'admin.chat.index', 'pattern' => 'admin.chat.*', 'label' => 'Support Chat', 'icon' => 'chat'],
    ],
    'System' => [
      ['route' => 'admin.payments.index', 'pattern' => 'admin.payments.*', 'label' => 'Payments', 'icon' => 'card'],
      ['route' => 'admin.settings.index', 'pattern' => 'admin.settings.*', 'label' => 'Settings', 'icon' => 'settings'],
      ['route' => 'admin.audit-logs.index', 'pattern' => 'admin.audit-logs.*', 'label' => 'Audit Log', 'icon' => 'log'],
      ['route' => 'admin.tools.index', 'pattern' => 'admin.tools.*', 'label' => 'Tools', 'icon' => 'wrench'],
    ],
  ];
@endphp

<div class="admin-shell">
  <aside class="admin-sidebar" id="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
      </svg>
      <span>Spell Enchantment<small>Admin Console</small></span>
    </a>

    <nav class="admin-nav">
      @foreach($navGroups as $group => $items)
        <div class="admin-nav-group">
          <div class="admin-nav-label">{{ $group }}</div>
          @foreach($items as $item)
            @if(\Illuminate\Support\Facades\Route::has($item['route']))
            <a href="{{ route($item['route']) }}" class="admin-nav-link {{ request()->routeIs($item['pattern']) ? 'active' : '' }}">
              <span class="admin-nav-icon" data-icon="{{ $item['icon'] }}"></span>
              {{ $item['label'] }}
            </a>
            @endif
          @endforeach
        </div>
      @endforeach
    </nav>

    <div class="admin-sidebar-footer">
      <a href="{{ route('admin.profile') }}" class="admin-nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
        <span class="admin-nav-icon" data-icon="user"></span> My Profile
      </a>
      <a href="{{ route('home') }}" class="admin-nav-link">
        <span class="admin-nav-icon" data-icon="home"></span> View Storefront
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="admin-nav-link admin-nav-logout">
          <span class="admin-nav-icon" data-icon="logout"></span> Logout
        </button>
      </form>
    </div>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <button class="admin-menu-toggle" id="admin-menu-toggle" aria-label="Toggle menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
      <div class="admin-topbar-title">@yield('title', 'Admin')</div>
      <div class="admin-topbar-user">
        @auth
          <span>{{ auth()->user()->name }}</span>
          <span class="admin-role-badge">{{ auth()->user()->role }}</span>
        @endauth
      </div>
    </header>

    <main class="admin-content">
      @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:1rem;">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error" style="margin-bottom:1rem;">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-error" style="margin-bottom:1rem;">
          <ul style="margin:0;padding-left:1.2rem;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
