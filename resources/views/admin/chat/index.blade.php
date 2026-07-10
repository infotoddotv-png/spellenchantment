@extends('layouts.admin')
@section('title', 'Support Chat')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;">Support Chat</h1>
      <p style="color:var(--muted-fg);">Customer tickets from orders and the support inbox.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
      @foreach([['Open','open',$stats['open']],['Waiting Response','waiting_admin',$stats['waiting_admin']],['Replied','replied',$stats['replied']],['Closed','closed',$stats['closed']]] as [$label,$key,$count])
      <a href="{{ route('admin.chat.index', ['status'=>$key]) }}" class="glass-card rounded-2xl" style="padding:1.25rem;text-decoration:none;color:inherit;">
        <div style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted-fg);">{{ $label }}</div>
        <div style="font-size:2rem;font-weight:700;margin-top:0.5rem;">{{ $count }}</div>
      </a>
      @endforeach
    </div>

    <div class="glass-card rounded-2xl" style="padding:1.25rem;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
            <th style="text-align:left;padding:0.75rem;">Subject</th>
            <th style="text-align:left;padding:0.75rem;">Customer</th>
            <th style="text-align:left;padding:0.75rem;">Order</th>
            <th style="text-align:left;padding:0.75rem;">Status</th>
            <th style="text-align:left;padding:0.75rem;">Updated</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($tickets as $ticket)
          <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
            <td style="padding:0.75rem;">{{ $ticket->subject }}</td>
            <td style="padding:0.75rem;">{{ $ticket->name }}<br><span style="color:var(--muted-fg);font-size:0.8rem;">{{ $ticket->email }}</span></td>
            <td style="padding:0.75rem;">{{ $ticket->order_id ? '#'.str_pad($ticket->order_id,6,'0',STR_PAD_LEFT) : '—' }}</td>
            <td style="padding:0.75rem;"><span class="ticket-status ticket-status-{{ $ticket->status }}">{{ $ticket->statusLabel() }}</span></td>
            <td style="padding:0.75rem;color:var(--muted-fg);">{{ $ticket->last_message_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}</td>
            <td style="padding:0.75rem;text-align:right;"><a href="{{ route('admin.chat.show', $ticket) }}" style="color:var(--primary);">Open</a></td>
          </tr>
          @empty
          <tr><td colspan="6" style="padding:1.5rem;text-align:center;color:var(--muted-fg);">No tickets yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
.ticket-status { padding:0.25rem 0.75rem; border-radius:999px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap; }
.ticket-status-open { background:rgba(96,165,250,0.15); color:#60a5fa; }
.ticket-status-waiting_admin { background:rgba(250,204,21,0.15); color:#facc15; }
.ticket-status-replied { background:rgba(74,222,128,0.15); color:#4ade80; }
.ticket-status-closed { background:rgba(148,163,184,0.15); color:#94a3b8; }
</style>
@endsection
