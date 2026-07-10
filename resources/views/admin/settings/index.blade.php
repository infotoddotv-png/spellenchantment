@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:46rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1.5rem;">General Settings</h1>
      <form method="POST" action="{{ route('admin.settings.store') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Site Name</label>
          <input type="text" name="site_name" class="form-input" value="{{ old('site_name') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Tagline</label>
          <input type="text" name="site_tagline" class="form-input" value="{{ old('site_tagline') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Contact Email</label>
          <input type="email" name="contact_email" class="form-input" value="{{ old('contact_email') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Facebook URL</label>
          <input type="url" name="facebook_url" class="form-input" value="{{ old('facebook_url') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Instagram URL</label>
          <input type="url" name="instagram_url" class="form-input" value="{{ old('instagram_url') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Twitter URL</label>
          <input type="url" name="twitter_url" class="form-input" value="{{ old('twitter_url') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Footer Text</label>
          <textarea name="footer_text" class="form-input" rows="4">{{ old('footer_text') }}</textarea>
        </div>
        <button class="magic-btn magic-btn-primary" type="submit">Save Settings</button>
      </form>
    </div>
  </div>
</div>
@endsection
