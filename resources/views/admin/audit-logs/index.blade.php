@extends('layouts.admin')
@section('title', 'Audit Log')

@section('content')
<div class="admin-page-head">
  <div>
    <h1>Audit Log</h1>
    <p>A record of important admin actions for accountability.</p>
  </div>
</div>

<div class="glass-card rounded-2xl admin-table-wrap" style="padding:0.5rem;">
  <table class="admin-table">
    <thead><tr><th>When</th><th>User</th><th>Action</th><th>Description</th><th>IP</th></tr></thead>
    <tbody>
      @forelse($logs as $log)
      <tr>
        <td>{{ $log->created_at->format('M j, Y g:ia') }}</td>
        <td>{{ $log->user?->name ?? 'System' }}</td>
        <td><span class="badge badge-active">{{ $log->action }}</span></td>
        <td>{{ $log->description }}</td>
        <td style="color:var(--muted-fg);">{{ $log->ip_address }}</td>
      </tr>
      @empty
      <tr><td colspan="5" style="text-align:center;color:var(--muted-fg);padding:2rem;">No activity recorded yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:1rem;">{{ $logs->links() }}</div>
@endsection
