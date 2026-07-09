@extends('layouts.app')
@section('title', 'Users')

@section('content')
<div style="padding:6rem 0 4rem;">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
      <div>
        <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:700;">Users</h1>
        <p style="color:var(--muted-fg);">Manage customer, moderator, and admin accounts.</p>
      </div>
      <a href="{{ route('admin.users.create') }}" class="magic-btn magic-btn-primary">Create User</a>
    </div>

    <div class="glass-card rounded-2xl" style="padding:1.25rem;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
            <th style="text-align:left;padding:0.75rem;">Name</th>
            <th style="text-align:left;padding:0.75rem;">Email</th>
            <th style="text-align:left;padding:0.75rem;">Role</th>
            <th style="text-align:left;padding:0.75rem;">Status</th>
            <th style="text-align:right;padding:0.75rem;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
            <td style="padding:0.75rem;">{{ $user->name }}</td>
            <td style="padding:0.75rem;">{{ $user->email }}</td>
            <td style="padding:0.75rem;">{{ $user->role }}</td>
            <td style="padding:0.75rem;">{{ $user->status }}</td>
            <td style="padding:0.75rem;text-align:right;">
              <a href="{{ route('admin.users.edit', $user) }}" style="margin-right:0.5rem;color:var(--primary);">Edit</a>
              <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;color:#ff7b7b;cursor:pointer;">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
