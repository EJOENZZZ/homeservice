@extends('admin.layout')
@section('page-title', 'Users')

@section('content')

<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px">
        <div class="card-title" style="margin:0">All Users</div>
        <form method="GET" style="display:flex;gap:8px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..." style="border:1.5px solid #E5E7EB;border-radius:8px;padding:8px 14px;font-size:.85rem;width:240px">
            <button type="submit" class="btn btn-blue">Search</button>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Verified</th><th>Joined</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td style="color:#9CA3AF">{{ $u->id }}</td>
                    <td style="font-weight:600">{{ $u->name }}</td>
                    <td style="color:#6B7280">{{ $u->email }}</td>
                    <td>
                        <span class="badge {{ $u->is_verified ? 'badge-verified' : 'badge-unverified' }}">
                            {{ $u->is_verified ? '✓ Verified' : 'Unverified' }}
                        </span>
                    </td>
                    <td style="color:#9CA3AF;font-size:.82rem">{{ $u->created_at?->format('M j, Y') }}</td>
                    <td>
                        <form method="POST" action="/admin/users/{{ $u->id }}" onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-red">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#9CA3AF;padding:40px">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $users->links() }}</div>
</div>

@endsection