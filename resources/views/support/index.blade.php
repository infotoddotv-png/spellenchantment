@extends('layouts.app')
@section('title', 'Support')

@section('content')
<div style="padding:8rem 0 4rem;">
  <div class="container" style="max-width:48rem;">
    <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;margin-bottom:0.5rem;">Your Support Tickets</h1>
    <p style="color:var(--muted-fg);margin-bottom:2rem;">Messages you've sent to the Arcane Sanctum team, and their replies.</p>

    @if($tickets->isEmpty())
      <div class="glass-card rounded-2xl" style="padding:2rem;text-align:center;color:var(--muted-fg);">
        No tickets yet. Open one of your orders and choose "Contact Support" to start a conversation.
      </div>
    @else
      <div style="display:flex;flex-direction:column;gap:0.75rem;">
        @foreach($tickets as $ticket)
        <a href="{{ route('support.show', $ticket) }}" class="glass-card rounded-2xl" style="padding:1.25rem;display:flex;justify-content:space-between;align-items:center;color:inherit;text-decoration:none;">
          <div>
            <div style="font-weight:700;">{{ $ticket->subject }}</div>
            <div style="color:var(--muted-fg);font-size:0.85rem;">Updated {{ $ticket->last_message_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}</div>
          </div>
          <span class="ticket-status ticket-status-{{ $ticket->status }}">{{ $ticket->statusLabel() }}</span>
        </a>
        @endforeach
      </div>
    @endif
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
