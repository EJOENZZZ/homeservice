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
                    @if($b->professional?->avatar_url)
                        <img src="{{ $b->professional->avatar_url }}" alt="{{ $b->professional->full_name ?? 'Professional' }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                    @else
                        {{ strtoupper(substr($b->professional->first_name ?? 'P', 0, 1) . substr($b->professional->last_name ?? 'R', 0, 1)) }}
                    @endif
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

            @if($b->status === 'completed')
                @if($b->user_rating)
                <div style="margin-top:16px;padding:14px 16px;background:#ECFDF5;border:1px solid #A7F3D0;border-radius:14px">
                    <div style="font-weight:700;color:#065F46;margin-bottom:6px">Your Rating</div>
                    <div style="color:#047857;font-size:.92rem;margin-bottom:6px">
                        {{ str_repeat('⭐', (int) $b->user_rating) }}
                    </div>
                    @if($b->user_review)
                    <div style="font-size:.86rem;color:#047857;line-height:1.5">{{ $b->user_review }}</div>
                    @endif
                </div>
                @else
                <form method="POST" action="{{ route('booking.rate', $b->id) }}" style="margin-top:16px;padding:16px;border:1px solid #BFDBFE;background:#EFF6FF;border-radius:14px">
                    @csrf
                    <div style="font-weight:700;color:#1E40AF;margin-bottom:10px">Rate this service</div>
                    <div class="form-group" style="margin-bottom:10px">
                        <label style="font-size:.85rem;font-weight:600;color:#1E3A8A">Rating</label>
                        <select name="user_rating" required style="width:100%;border:1.5px solid #BFDBFE;border-radius:10px;padding:10px 12px;background:#fff">
                            <option value="">Select rating</option>
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Okay</option>
                            <option value="2">2 - Poor</option>
                            <option value="1">1 - Bad</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:12px">
                        <label style="font-size:.85rem;font-weight:600;color:#1E3A8A">Review (optional)</label>
                        <textarea name="user_review" rows="3" placeholder="Tell us about your experience..." style="width:100%;border:1.5px solid #BFDBFE;border-radius:10px;padding:10px 12px;resize:vertical"></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Submit Rating</button>
                </form>
                @endif
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
