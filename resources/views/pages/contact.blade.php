@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="max-width:560px">
        <h1 class="auth-title">Contact Us</h1>
        <p class="auth-sub">We'd love to hear from you.</p>

        <form class="auth-form" onsubmit="this.querySelector('button').textContent='Sent!';return false;">
            <div class="form-group">
                <label>Your name</label>
                <input type="text" placeholder="Juan dela Cruz" required>
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" placeholder="you@email.com" required>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" placeholder="How can we help?">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea rows="5" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit" class="btn-primary btn-full">Send Message</button>
        </form>
    </div>
</div>
@endsection