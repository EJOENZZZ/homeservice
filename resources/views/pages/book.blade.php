@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="max-width:560px">
        <h1 class="auth-title">Book a Service</h1>

        <div class="booking-pro-summary">
            <div class="pro-avatar" style="margin:0;width:48px;height:48px;font-size:.95rem">
                {{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}
            </div>
            <div>
                <div style="font-weight:700;font-family:'Syne',sans-serif">{{ $pro->first_name }} {{ $pro->last_name }}</div>
                <div style="font-size:.85rem;color:var(--gray-mid)">{{ $pro->specialty }} · ★ {{ number_format($pro->rating,2) }}</div>
            </div>
        </div>

        @if($errors->any())
        <div class="form-error-box">
            <ul style="margin:0;padding-left:16px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/book" class="auth-form">
            @csrf
            <input type="hidden" name="professional_id" value="{{ $pro->id }}">

            <div class="form-group">
                <label>Service Date</label>
                <input type="date" name="service_date" value="{{ old('service_date') }}"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
            </div>
            <div class="form-group">
                <label>Preferred Time</label>
                <input type="time" name="service_time" value="{{ old('service_time') }}" required>
            </div>
            <div class="form-group">
                <label>Your Address</label>
                <input type="text" name="address" value="{{ old('address') }}"
                    placeholder="123 Rizal St, Quezon City" required>
            </div>
            <div class="form-group">
                <label>Notes (optional)</label>
                <textarea name="notes" rows="3"
                    placeholder="Describe what needs to be done...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn-primary btn-full">Confirm Booking</button>
        </form>
    </div>
</div>
@endsection