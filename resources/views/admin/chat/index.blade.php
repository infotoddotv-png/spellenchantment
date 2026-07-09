@extends('layouts.app')
@section('title', 'Support Chat')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:42rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1rem;">Support Chat</h1>
      <p style="color:var(--muted-fg);margin-bottom:1.5rem;">Send a message to the admin team about an order, a request, or a product issue.</p>
      <form method="POST" action="{{ route('admin.chat.store') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Your message</label>
          <textarea name="message" class="form-input" rows="6" placeholder="Describe your request or issue..."></textarea>
        </div>
        <button class="magic-btn magic-btn-primary" type="submit">Send Message</button>
      </form>
    </div>
  </div>
</div>
@endsection
