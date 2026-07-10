@extends('layouts.app')
@section('title', 'Support — ' . $ticket->subject)

@section('content')
<div style="padding:8rem 0 4rem;">
  <div class="container" style="max-width:42rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;">{{ $ticket->subject }}</h1>
      <span class="ticket-status ticket-status-{{ $ticket->status }}">{{ $ticket->statusLabel() }}</span>
    </div>

    @if($order)
      <p style="color:var(--muted-fg);margin-bottom:1.5rem;">Regarding order #{{ str_pad($order->id,6,'0',STR_PAD_LEFT) }} — {{ $order->email }}</p>
    @endif

    <div class="glass-card rounded-2xl" style="padding:1.5rem;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:1rem;max-height:28rem;overflow-y:auto;">
      @forelse($ticket->messages as $message)
        <div style="align-self:{{ $message->sender === 'admin' ? 'flex-start' : 'flex-end' }};max-width:80%;">
          <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted-fg);margin-bottom:0.25rem;">
            {{ $message->sender === 'admin' ? 'Arcane Sanctum Team' : 'You' }} · {{ $message->created_at->diffForHumans() }}
          </div>
          <div style="background:{{ $message->sender === 'admin' ? 'rgba(255,255,255,0.06)' : 'rgba(139,92,246,0.15)' }};padding:0.75rem 1rem;border-radius:0.75rem;white-space:pre-line;">{{ $message->message }}</div>
        </div>
      @empty
        <p style="color:var(--muted-fg);">No messages yet — send one below.</p>
      @endforelse
    </div>

    @if($ticket->status !== 'closed')
    <form method="POST" action="{{ $order ? route('support.order.store', $order) : route('support.reply', $ticket) }}">
      @csrf
      @if($order)
        <input type="hidden" name="email" value="{{ request('email', $order->email) }}">
      @endif
      <div class="form-group">
        <label class="form-label">Reply</label>
        <textarea name="message" class="form-input" rows="4" placeholder="Type your message..." required></textarea>
      </div>
      <button class="magic-btn magic-btn-primary" type="submit">Send</button>
    </form>
    @else
      <p style="color:var(--muted-fg);">This ticket is closed. Start a new one from your order page if you need further help.</p>
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
