@extends('admin.layout')
@section('page-title', 'Dashboard')

@section('content')

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="label">Total Users</div>
        <div class="value">{{ $stats['users'] }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Professionals</div>
        <div class="value">{{ $stats['professionals'] }}</div>
    </div>
    <div class="stat-card amber">
        <div class="label">Pending Bookings</div>
        <div class="value">{{ $stats['pending'] }}</div>
    </div>
    <div class="stat-card blue">
        <div class="label">Confirmed</div>
        <div class="value">{{ $stats['confirmed'] }}</div>
    </div>
    <div class="stat-card green">
        <div class="label">Completed</div>
        <div class="value">{{ $stats['completed'] }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Total Bookings</div>
        <div class="value">{{ $stats['bookings'] }}</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;flex-wrap:wrap">

    <div class="card" style="grid-column:1/-1">
        <div class="card-title">Recent Bookings</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Professional</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                    <tr>
                        <td>{{ $b->user->name ?? '—' }}</td>
                        <td>{{ $b->professional->first_name ?? '—' }} {{ $b->professional->last_name ?? '' }}</td>
                        <td>{{ $b->professional->specialty ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->service_date)->format('M j, Y') }}</td>
                        <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                        <td>
                            <form method="POST" action="/admin/bookings/{{ $b->id }}">
                                @csrf
                                <select name="status" onchange="this.form.submit()" style="border:1px solid #E5E7EB;border-radius:6px;padding:4px 8px;font-size:.8rem;cursor:pointer">
                                    @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $b->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:#9CA3AF;padding:32px">No bookings yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:16px">
            <a href="/admin/bookings" class="btn btn-ghost">View All Bookings →</a>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Recent Users</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td style="color:#6B7280;font-size:.82rem">{{ $u->email }}</td>
                        <td>
                            <span class="badge {{ $u->is_verified ? 'badge-verified' : 'badge-unverified' }}">
                                {{ $u->is_verified ? 'Verified' : 'Unverified' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:#9CA3AF">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:16px">
            <a href="/admin/users" class="btn btn-ghost">View All Users →</a>
        </div>
    </div>

</div>

@endsection