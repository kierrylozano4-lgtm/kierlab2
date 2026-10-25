@extends('layouts.app', ['title' => 'Overview'])

@section('content')
<div class="hero-card">
    <div class="hero-copy">
        <p class="eyebrow">Campus intelligence</p>
        <h2>Real-time monitoring for a safer campus.</h2>
        <p>Track system health, manage campus access, and prioritize risk areas from a single geo-aware command center.</p>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.users.index') }}" class="btn-primary">Manage users</a>
        <a href="{{ route('admin.weather.page') }}" class="btn-secondary">Open weather report</a>
    </div>
</div>

<section class="stats-grid">
    <article class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">Total users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
            <span class="stat-icon">U</span>
        </div>
        <div class="stat-meta"><span class="trend-up">+12.4%</span><span>vs. last month</span></div>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">Admins</div>
                <div class="stat-value">{{ $adminUsers }}</div>
            </div>
            <span class="stat-icon" style="color:#7b8cff;">A</span>
        </div>
        <div class="stat-meta"><span class="trend-up">+4.8%</span><span>privileged access</span></div>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">Members</div>
                <div class="stat-value">{{ $memberUsers }}</div>
            </div>
            <span class="stat-icon" style="color:#4de4d6;">M</span>
        </div>
        <div class="stat-meta"><span class="trend-up">+7.1%</span><span>active campus accounts</span></div>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">Risk score</div>
                <div class="stat-value">76</div>
            </div>
            <span class="stat-icon" style="color:#ff677d;">R</span>
        </div>
        <div class="stat-meta"><span class="trend-down">-2.6%</span><span>stability index</span></div>
    </article>
</section>

<div class="panel-layout">
    <section class="panel-card">
        <div class="panel-header">
            <h3>Operational pulse</h3>
            <span class="status-badge">Live</span>
        </div>

        <div class="map-surface">
            <div class="map-layer"></div>
            <svg class="map-svg" viewBox="0 0 700 340" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M30 200C120 90 160 140 240 180C310 215 350 210 420 160C510 100 560 120 670 70" fill="none" stroke="rgba(98, 156, 214, 0.35)" stroke-width="1.2" stroke-dasharray="6 8"/>
                <path d="M80 270C170 210 220 80 330 120C420 150 500 260 620 210" fill="none" stroke="rgba(78, 228, 214, 0.28)" stroke-width="1.4" stroke-dasharray="5 10"/>
                <path d="M110 80L190 120L290 100L410 170L510 140L620 180" fill="none" stroke="rgba(85, 185, 255, 0.3)" stroke-width="1.2"/>
            </svg>
            <span class="signal-dot" style="top:42%; left:28%;"></span>
            <span class="signal-dot alt" style="top:62%; left:52%;"></span>
            <span class="signal-dot" style="top:30%; left:70%;"></span>
            <span class="signal-dot alt" style="top:58%; left:78%;"></span>
        </div>
    </section>

    <aside class="panel-card">
        <div class="panel-header">
            <h3>Risk watch</h3>
            <div class="tag-row">
                <span class="tag">High priority</span>
            </div>
        </div>

        <div class="risk-list">
            <div class="risk-item">
                <div class="risk-name"><span class="risk-dot" style="background:#ff677d;"></span> Parcel access</div>
                <span class="risk-severity high">High</span>
            </div>
            <div class="risk-item">
                <div class="risk-name"><span class="risk-dot" style="background:#fbbf24;"></span> Weather drift</div>
                <span class="risk-severity medium">Medium</span>
            </div>
            <div class="risk-item">
                <div class="risk-name"><span class="risk-dot" style="background:#4de4d6;"></span> Network latency</div>
                <span class="risk-severity low">Low</span>
            </div>
        </div>
    </aside>
</div>
@endsection
