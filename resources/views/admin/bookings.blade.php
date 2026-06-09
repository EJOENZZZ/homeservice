@extends('admin.layout')

@section('page-title', 'Bookings')

@section('content')

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.bookings') }}"
      style="display:flex;gap:10px;align-items:center;margin-bottom:24px;flex-wrap:wrap;">
    <select name="status"
        style="border:1.5px solid var(--gray-border);border-radius:8px;padding:9px 12px;
               font-size:.88rem;font-family:'DM Sans',sans-serif;outline:none;background:#fff;min-width:160px;">
        <option value="">All Statuses</option>
        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    <button type="submit" class="btn btn-blue">Filter</button>
    @if(request('status'))
        <a href="{{ route('admin.bookings') }}" class="btn btn-ghost">Reset</a>
    @endif
    <span style="margin-left:auto;font-size:.85rem;color:var(--gray-mid);">
        {{ $bookings->total() }} booking{{ $bookings->total() != 1 ? 's' : '' }} found
    </span>
</form>

{{-- Table --}}
<div class="card" style="padding:0;overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Professional</th>
                    <th>Service Date & Time</th>
                    <th>Address</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                <tr>
                    <td style="color:var(--gray-mid);font-size:.8rem;">{{ $booking->id }}</td>

                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;overflow:hidden;flex-shrink:0;">
                                @if($booking->user?->avatar_url)
                                    <img src="{{ $booking->user->avatar_url }}" alt="{{ $booking->user->name ?? 'User' }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    {{ $booking->user?->initials ?? 'U' }}
                                @endif
                            </div>
                            <div>
                                <div style="font-weight:500;line-height:1.2;">{{ $booking->user->name ?? 'N/A' }}</div>
                                <div style="font-size:.78rem;color:var(--gray-mid);line-height:1.2;">{{ $booking->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>

                    <td>{{ $booking->professional->name ?? 'N/A' }}</td>

                    <td style="font-size:.85rem;white-space:nowrap;">
                        {{ \Carbon\Carbon::parse($booking->service_date)->format('M d, Y') }}<br>
                        <span style="color:var(--gray-mid);font-size:.78rem;">
                            {{ $booking->service_time }}
                        </span>
                    </td>

                    <td style="font-size:.85rem;max-width:160px;">
                        {{ $booking->address ?? '-' }}
                    </td>

                    <td style="font-size:.82rem;color:var(--gray-mid);max-width:140px;">
                        <div>{{ $booking->notes ?? '-' }}</div>
                        @if($booking->user_rating)
                        <div style="margin-top:8px;font-size:.75rem;color:#0F766E">
                            <strong>Rating:</strong> {{ str_repeat('⭐', (int) $booking->user_rating) }}
                            @if($booking->user_review)
                            <div style="margin-top:4px;color:#475569;line-height:1.4">{{ $booking->user_review }}</div>
                            @endif
                        </div>
                        @endif
                    </td>

                    <td>
                        <span class="badge badge-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>

                    <td>
                        <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}"
                              style="display:flex;gap:8px;align-items:center;">
                            @csrf
                            <select name="status"
                                style="border:1.5px solid var(--gray-border);border-radius:8px;
                                       padding:6px 10px;font-size:.82rem;font-family:'DM Sans',sans-serif;
                                       outline:none;background:#fff;">
                                <option value="pending"   {{ $booking->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-blue" style="padding:6px 12px;">Save</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:48px;color:var(--gray-mid);">
                        No bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if ($bookings->hasPages())
    <div class="pagination">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
@endif

@endsection