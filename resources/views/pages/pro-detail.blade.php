@extends('layouts.app')

@section('content')
<div class="pro-detail-wrap">
    <div class="pro-detail-card">
        <div class="pro-detail-header">
            <div class="pro-detail-avatar">
                {{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}
            </div>
            <div>
                <span class="pro-badge {{ strtolower(str_replace(' ','',$pro->badge)) }}">{{ $pro->badge }}</span>
                <h1 class="pro-detail-name">{{ $pro->first_name }} {{ $pro->last_name }}</h1>
                <p class="pro-detail-spec">{{ $pro->specialty }}</p>
                <div class="pro-rating" style="justify-content:flex-start;margin-bottom:0">
                    <span class="star">★</span>
                    <span>{{ number_format($pro->rating,2) }}</span>
                    <span class="dot">·</span>
                    <span>{{ $pro->jobs_count }} jobs completed</span>
                </div>
            </div>
        </div>

        @if($pro->bio)
        <div class="pro-detail-section">
            <h3>About</h3>
            <p>{{ $pro->bio }}</p>
        </div>
        @endif

        @if($pro->hourly_rate)
        <div class="pro-detail-section">
            <h3>Rate</h3>
            <p>₱{{ number_format($pro->hourly_rate,2) }} / hour</p>
        </div>
        @endif

        @if($pro->location)
        <div class="pro-detail-section">
            <h3>Location</h3>
            <p>{{ $pro->location }}</p>
        </div>
        @endif

        <div class="pro-detail-actions">
            @auth
                <a href="/book?professional_id={{ $pro->id }}" class="btn-primary" style="padding:14px 40px;font-size:1rem">
                    Book Now
                </a>
            @else
                <a href="/login" class="btn-primary" style="padding:14px 40px;font-size:1rem">
                    Log in to Book
                </a>
            @endauth
            <a href="/services" class="btn-outline">Browse Other Pros</a>
        </div>
    </div>
</div>
@endsection