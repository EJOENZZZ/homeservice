@extends('admin.layout')
@section('page-title', 'Dashboard')

@section('content')

<style>
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 18px;
        margin-bottom: 0;
    }
    .stat-card {
        padding: 26px 28px;
        min-height: 126px;
    }
    .stat-card .label {
        font-size: .84rem;
        margin-bottom: 10px;
    }
    .stat-card .value {
        font-size: 2.35rem;
        line-height: 1;
    }
</style>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="label">Total Users</div>
        <div class="value">{{ $stats['users'] }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Professionals</div>
        <div class="value">{{ $stats['professionals'] }}</div>
    </div>
    <div class="stat-card amber">
        <div class="label">Pending Bookings</div>
        <div class="value">{{ $stats['pending'] }}</div>
    </div>
    <div class="stat-card blue">
        <div class="label">Confirmed</div>
        <div class="value">{{ $stats['confirmed'] }}</div>
    </div>
    <div class="stat-card green">
        <div class="label">Completed</div>
        <div class="value">{{ $stats['completed'] }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Total Bookings</div>
        <div class="value">{{ $stats['bookings'] }}</div>
    </div>
</div>

@endsection