@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <h1 class="page-title">My Bookings</h1>

    @if($bookings->isEmpty())
    <div class="empty-state">
        <p>You have no bookings yet.</p>
        <a href="/services" class="btn-primary" style="margin-top:16px;display:inline-block">Find a Pro</a>
    </div>
    @else
    <div class="bookings-grid">
        @foreach($bookings as $b)
        <div class="booking-card">
            <div class="booking-card-top">
                <div class="pro-avatar" style="width:48px;height:48px;font-size:.9rem;margin:0">
                    {{ strtoupper(substr($b->professional->first_name ?? 'P', 0, 1) . substr($b->professional->last_name ?? 'R', 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:700;font-family:'Syne',sans-serif">
                        {{ $b->professional->first_name ?? 'Professional' }} {{ $b->professional->last_name ?? '' }}
                    </div>
                    <div style="font-size:.85rem;color:var(--gray-mid)">
                        {{ $b->professional->specialty ?? '—' }}
                    </div>
                </div>
                <span class="booking-status {{ $b->status }}">{{ ucfirst($b->status) }}</span>
            </div>
            <div class="booking-meta">
                <div><span>📅</span> {{ \Carbon\Carbon::parse($b->service_date)->format('F j, Y') }}</div>
                <div><span>🕐</span> {{ \Carbon\Carbon::parse($b->service_time)->format('g:i A') }}</div>
                <div><span>📍</span> {{ $b->address }}</div>
                @if($b->notes)
                <div><span>📝</span> {{ $b->notes }}</div>
                @endif
                @if($b->estimated_hours)
                <div><span>⏱</span> {{ $b->estimated_hours }} hour{{ $b->estimated_hours > 1 ? 's' : '' }}</div>
                @endif
                @if($b->payment_method)
                <div><span>💳</span> {{ $b->payment_label }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection