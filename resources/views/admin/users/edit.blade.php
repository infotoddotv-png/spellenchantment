@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container" style="max-width:40rem;">
    <div class="glass-card rounded-2xl" style="padding:2rem;">
      <h1 style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;margin-bottom:1.5rem;">Edit User</h1>
      <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">New Password</label>
          <input type="password" name="password" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">Role</label>
          <select name="role" class="form-input">
            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="status" class="form-input">
            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>Blocked</option>
          </select>
        </div>
        <button class="magic-btn magic-btn-primary" type="submit">Update User</button>
      </form>
    </div>
  </div>
</div>
@endsection
