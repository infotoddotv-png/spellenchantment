@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
      <div>
        <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;">Dashboard</h1>
        <p style="color:var(--muted-fg);">Welcome back to the Spell Enchantment control center.</p>
      </div>
      <a href="{{ route('admin.users.create') }}" class="magic-btn magic-btn-primary">Create User</a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem;">
      @foreach([
        ['Users', $stats['users'], 'users'],
        ['Active', $stats['activeUsers'], 'active'],
        ['Products', $stats['products'], 'products'],
        ['Orders', $stats['orders'], 'orders'],
      ] as [$label, $value, $key])
      <div class="glass-card rounded-2xl" style="padding:1.25rem;">
        <div style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--muted-fg);">{{ $label }}</div>
        <div style="font-size:2rem;font-weight:700;margin-top:0.5rem;">{{ $value }}</div>
      </div>
      @endforeach
    </div>

    <div style="margin-bottom:1.5rem;">
      <h2 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:1rem;">Support Tickets</h2>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;">
        @foreach([['Open','open',$ticketStats['open'],'#60a5fa'],['Waiting Response','waiting_admin',$ticketStats['waiting_admin'],'#facc15'],['Replied','replied',$ticketStats['replied'],'#4ade80'],['Closed','closed',$ticketStats['closed'],'#94a3b8']] as [$label,$key,$count,$color])
        <a href="{{ route('admin.chat.index', ['status'=>$key]) }}" class="glass-card rounded-2xl" style="padding:1.25rem;text-decoration:none;color:inherit;">
          <div style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted-fg);">{{ $label }}</div>
          <div style="font-size:2rem;font-weight:700;margin-top:0.5rem;color:{{ $color }};">{{ $count }}</div>
        </a>
        @endforeach
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 0.8fr;gap:1rem;">
      <div class="glass-card rounded-2xl" style="padding:1.5rem;">
        <h2 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:1rem;">Recent Orders</h2>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
          @foreach($recentOrders as $order)
            <div style="display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.08);padding-bottom:0.75rem;">
              <div>
                <div style="font-weight:700;">{{ $order->name }}</div>
                <div style="color:var(--muted-fg);font-size:0.85rem;">{{ $order->email }}</div>
              </div>
              <div style="text-align:right;">
                <div style="font-weight:700;">${{ number_format($order->total, 2) }}</div>
                <div style="color:var(--muted-fg);font-size:0.8rem;">{{ $order->status }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="glass-card rounded-2xl" style="padding:1.5rem;">
        <h2 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:1rem;">Recent Activity</h2>
        <div style="display:flex;flex-direction:column;gap:0.6rem;">
          @forelse($recentActivity as $log)
            <div style="border-bottom:1px solid rgba(255,255,255,0.08);padding-bottom:0.6rem;">
              <div style="font-size:0.85rem;">{{ $log->description ?? $log->action }}</div>
              <div style="color:var(--muted-fg);font-size:0.75rem;">{{ $log->user->name ?? 'Guest' }} · {{ $log->created_at->diffForHumans() }}</div>
            </div>
          @empty
            <p style="color:var(--muted-fg);font-size:0.85rem;">No activity yet.</p>
          @endforelse
        </div>
        <a href="{{ route('admin.audit-logs.index') }}" style="display:block;margin-top:0.75rem;color:var(--primary);font-size:0.85rem;">View all logs →</a>
      </div>

      <div class="glass-card rounded-2xl" style="padding:1.5rem;">
        <h2 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:1rem;">Quick Links</h2>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
          <a href="{{ route('admin.users.index') }}" class="magic-btn magic-btn-outline" style="justify-content:center;">Manage Users</a>
          <a href="{{ route('admin.shop.index') }}" class="magic-btn magic-btn-outline" style="justify-content:center;">Shop Manager</a>
          <a href="{{ route('admin.chat.index') }}" class="magic-btn magic-btn-outline" style="justify-content:center;">Support Chat</a>
          <a href="{{ route('admin.settings.index') }}" class="magic-btn magic-btn-outline" style="justify-content:center;">Settings</a>
          <a href="{{ route('admin.tools.index') }}" class="magic-btn magic-btn-outline" style="justify-content:center;">Tools</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
