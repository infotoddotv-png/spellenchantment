@extends('layouts.app')
@section('title', 'Create User')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:40rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1.5rem;">Create User</h1>
      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Role</label>
          <select name="role" class="form-input">
            <option value="customer">Customer</option>
            <option value="moderator">Moderator</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="status" class="form-input">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
            <option value="blocked">Blocked</option>
          </select>
        </div>
        <button class="magic-btn magic-btn-primary" type="submit">Save User</button>
      </form>
    </div>
  </div>
</div>
@endsection
