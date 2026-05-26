@extends('layouts.app')

@section('content')
<div class="page-wrap" style="max-width:800px">
    <div style="text-align:center;margin-bottom:64px">
        <div class="section-label">SIMPLE PROCESS</div>
        <h1 class="page-title">How HomeFix Works</h1>
        <p style="color:var(--gray-mid);font-size:1.05rem">Book a verified professional in 3 easy steps</p>
    </div>

    <div class="steps-list">
        <div class="step-item">
            <div class="step-num">1</div>
            <div class="step-body">
                <h3>Search for a Service</h3>
                <p>Enter the service you need and your location. Browse verified professionals with real ratings and job history.</p>
            </div>
        </div>
        <div class="step-item">
            <div class="step-num">2</div>
            <div class="step-body">
                <h3>Book Instantly</h3>
                <p>Choose your preferred date and time. Fill in your address and any notes. Confirm your booking in seconds.</p>
            </div>
        </div>
        <div class="step-item">
            <div class="step-num">3</div>
            <div class="step-body">
                <h3>Get It Done</h3>
                <p>Your professional arrives on time, completes the job, and you can leave a review. 100% satisfaction guaranteed.</p>
            </div>
        </div>
    </div>

    <div style="text-align:center;margin-top:64px">
        <a href="/services" class="btn-primary" style="padding:14px 40px;font-size:1rem">Find a Pro Now</a>
    </div>
</div>
@endsection