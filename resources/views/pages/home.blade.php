@extends('layouts.app')

@section('content')

<section class="hero">
    <div class="hero-grid-bg"></div>
    <div class="hero-content">
        <h1 class="hero-title">
            Expert Home<br>Services,<br>
            <span class="hero-accent">On Demand</span>
        </h1>
        <div class="hero-underline"></div>
        <p class="hero-sub">Find verified plumbers, electricians, carpenters, and more.<br>Get quotes in minutes — not days.</p>

    </div>
</section>

<section class="stats-section">
    <div class="stats-inner">
        <div class="stat-item">
            <div class="stat-num">4+</div>
            <div class="stat-label">Verified Pros</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-num">5.0★</div>
            <div class="stat-label">Average Rating</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-num">2 hrs</div>
            <div class="stat-label">Avg. Response Time</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-num">100%</div>
            <div class="stat-label">Satisfaction Guarantee</div>
        </div>
    </div>
</section>

<section class="pros-section">
    <div class="section-label">TOP RATED</div>
    <h2 class="section-title">Featured Professionals</h2>
    <div class="pros-grid">
        @forelse($professionals ?? [] as $pro)
        <div class="pro-card">
            <span class="pro-badge {{ strtolower(str_replace(' ','',$pro->badge)) }}">{{ $pro->badge }}</span>
            <div class="pro-avatar" style="padding:0;overflow:hidden">
                @if($pro->avatar_url)
                    <img src="{{ $pro->avatar_url }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                @else
                    {{ $pro->initials }}
                @endif
            </div>
            <h3 class="pro-name">{{ $pro->first_name }} {{ $pro->last_name }}</h3>
            <p class="pro-specialty">{{ $pro->specialty }}</p>
            <div class="pro-rating">
                <span class="star">★</span>
                <span>{{ number_format($pro->rating,2) }}</span>
                <span class="dot">·</span>
                <span>{{ $pro->jobs_count }} jobs</span>
            </div>
            <a href="/pros/{{ $pro->id }}" class="btn-outline">Book Now</a>
        </div>
        @empty
        @foreach([
            ['GD','Grace Dela Cruz','Plumber','ELITE','elite',5.00,451],
            ['MR','Marco Reyes','Electrician','TOP PRO','toppro',4.98,312],
        ] as $d)
        <div class="pro-card">
            <span class="pro-badge {{ $d[4] }}">{{ $d[3] }}</span>
            <div class="pro-avatar">{{ $d[0] }}</div>
            <h3 class="pro-name">{{ $d[1] }}</h3>
            <p class="pro-specialty">{{ $d[2] }}</p>
            <div class="pro-rating">
                <span class="star">★</span>
                <span>{{ number_format($d[5],2) }}</span>
                <span class="dot">·</span>
                <span>{{ $d[6] }} jobs</span>
            </div>
            <a href="#" class="btn-outline">Book Now</a>
        </div>
        @endforeach
        @endforelse
    </div>
</section>

<section class="testimonials-section">
    <div class="section-label">HAPPY CUSTOMERS</div>
    <h2 class="section-title">What Homeowners Say</h2>
    <div class="testimonials-grid">
        @forelse($testimonials ?? [] as $review)
        <div class="review-card">
            <div class="review-stars">★★★★★</div>
            <p class="review-text">"{{ $review->content }}"</p>
            <div class="review-author">{{ $review->author_name }}</div>
        </div>
        @empty
        <div class="review-card empty-review">
            <p>No reviews yet. Be the first!</p>
        </div>
        @endforelse
    </div>
</section>

@endsection