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

        <form class="search-bar" action="/services" method="GET">
            <div class="search-field">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" name="service" placeholder="What service do you need?">
            </div>
            <div class="search-divider"></div>
            <div class="search-field">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5"/>
                </svg>
                <input type="text" name="location" placeholder="Your location">
            </div>
            <button type="submit" class="btn-primary search-btn">Find Pros</button>
        </form>

        <div class="popular-tags">
            <span class="pop-label">Popular:</span>
            @foreach([
                ['Plumbing',   '🔧'],
                ['Electrical', '⚡'],
                ['Carpentry',  '🪚'],
                ['Cleaning',   '🧹'],
                ['Painting',   '🎨'],
            ] as [$tag, $icon])
                <a href="/services?service={{ $tag }}" class="category-pill">
                    <span class="category-pill-icon">{{ $icon }}</span>
                    <span>{{ $tag }}</span>
                </a>
            @endforeach
        </div>
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
            <div class="pro-avatar">{{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}</div>
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
            ['AS','Ana Santos','Carpenter','VERIFIED','verified',4.97,284],
            ['LB','Luis Bautista','Cleaner','TOP PRO','toppro',4.95,198],
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