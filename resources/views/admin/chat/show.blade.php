@extends('layouts.admin')
@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:44rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;">{{ $ticket->subject }}</h1>
      <span class="ticket-status ticket-status-{{ $ticket->status }}">{{ $ticket->statusLabel() }}</span>
    </div>
    <p style="color:var(--muted-fg);margin-bottom:1.5rem;">
      {{ $ticket->name }} &lt;{{ $ticket->email }}&gt;
      @if($ticket->order_id) · <a href="{{ route('admin.orders.show', $ticket->order_id) }}" style="color:var(--primary);">Order #{{ str_pad($ticket->order_id,6,'0',STR_PAD_LEFT) }}</a> @endif
    </p>

    <div class="glass-card rounded-2xl" style="padding:1.5rem;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:1rem;max-height:28rem;overflow-y:auto;">
      @forelse($ticket->messages as $message)
        <div style="align-self:{{ $message->sender === 'admin' ? 'flex-end' : 'flex-start' }};max-width:80%;">
          <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted-fg);margin-bottom:0.25rem;">
            {{ $message->sender === 'admin' ? 'You (Admin)' : $ticket->name }} · {{ $message->created_at->diffForHumans() }}
          </div>
          <div style="background:{{ $message->sender === 'admin' ? 'rgba(139,92,246,0.15)' : 'rgba(255,255,255,0.06)' }};padding:0.75rem 1rem;border-radius:0.75rem;white-space:pre-line;">{{ $message->message }}</div>
        </div>
      @empty
        <p style="color:var(--muted-fg);">No messages yet.</p>
      @endforelse
    </div>

    <form method="POST" action="{{ route('admin.chat.store', $ticket) }}" style="margin-bottom:1rem;">
      @csrf
      <div class="form-group">
        <label class="form-label">Reply to customer</label>
        <textarea name="message" class="form-input" rows="4" placeholder="Type your reply..." required></textarea>
      </div>
      <div style="display:flex;gap:0.75rem;">
        <button class="magic-btn magic-btn-primary" type="submit">Send Reply</button>
      </div>
    </form>

    @if($ticket->status !== 'closed')
    <form method="POST" action="{{ route('admin.chat.close', $ticket) }}">
      @csrf
      <button class="magic-btn magic-btn-outline" type="submit">Mark as Closed</button>
    </form>
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
