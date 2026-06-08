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

    {{-- LEAVE A REVIEW FORM --}}
    <div style="max-width:560px;margin:48px auto 0;background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:36px">
        <h3 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.15rem;margin-bottom:6px;text-align:center">Leave a Review</h3>
        <p style="text-align:center;color:var(--gray-mid);font-size:.88rem;margin-bottom:24px">Share your experience with HomeFix</p>

        @if(session('review_success'))
        <div style="background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:.88rem;display:flex;align-items:center;gap:8px">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#059669" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('review_success') }}
        </div>
        @endif

        <form method="POST" action="/testimonials">
            @csrf
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px">Your Name</label>
                <input type="text" name="author_name" value="{{ auth()->check() ? Auth::user()->name : old('author_name') }}" placeholder="Juan dela Cruz" required
                    style="width:100%;border:1.5px solid var(--gray-border);border-radius:10px;padding:10px 14px;font-size:.9rem;outline:none;font-family:'DM Sans',sans-serif;transition:border-color .2s"
                    onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--gray-border)'">
            </div>

            <div style="margin-bottom:16px">
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:8px">Rating</label>
                <div style="display:flex;gap:6px" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <label style="cursor:pointer;font-size:1.6rem;color:#D1D5DB;transition:color .15s" id="star-{{ $i }}"
                        onmouseover="hoverStars({{ $i }})" onmouseout="resetStars()" onclick="selectStar({{ $i }})">★</label>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="5">
            </div>

            <div style="margin-bottom:22px">
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px">Your Review</label>
                <textarea name="content" rows="4" placeholder="Tell others about your experience..." required
                    style="width:100%;border:1.5px solid var(--gray-border);border-radius:10px;padding:10px 14px;font-size:.9rem;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;transition:border-color .2s"
                    onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--gray-border)'">{{{ old('content') }}}</textarea>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Submit Review</button>
        </form>
    </div>
</section>

<script>
let selectedRating = 5;
document.addEventListener('DOMContentLoaded', () => selectStar(5));
function hoverStars(n) {
    for (let i = 1; i <= 5; i++)
        document.getElementById('star-' + i).style.color = i <= n ? '#F59E0B' : '#D1D5DB';
}
function resetStars() { selectStar(selectedRating, true); }
function selectStar(n, silent) {
    if (!silent) { selectedRating = n; document.getElementById('rating-input').value = n; }
    for (let i = 1; i <= 5; i++)
        document.getElementById('star-' + i).style.color = i <= n ? '#F59E0B' : '#D1D5DB';
}
</script>

@endsection