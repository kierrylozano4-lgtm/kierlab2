@extends('layouts.app', ['title' => 'Weather report'])

@section('content')
<div class="hero-card">
    <div class="hero-copy">
        <p class="eyebrow">Environmental telemetry</p>
        <h2>Weather and risk analysis</h2>
        <p>Track live conditions across key campus zones and compare local patterns with operational risk indicators.</p>
    </div>
    <div class="hero-actions">
        <span class="status-badge">Live</span>
    </div>
</div>

<section class="panel-card">
    <div class="panel-header">
        <h3>Search live conditions</h3>
        <span class="tag">Updated in real time</span>
    </div>

    <form id="weather-search-form" class="flex flex-col gap-3 sm:flex-row">
        <label class="sr-only" for="weather-location">Search location</label>
        <input id="weather-location" type="search" maxlength="100" placeholder="Search a city, e.g. Tokyo" class="form-input flex-1" style="background: rgba(7, 18, 27, 0.8);">
        <button type="submit" class="btn-primary">Search weather</button>
    </form>

    <p id="weather-status" class="mt-4 hidden rounded-xl border border-cyan-400/20 bg-cyan-500/10 px-4 py-3 text-sm text-cyan-100"></p>

    <div id="weather-result" class="mt-6 hidden rounded-2xl border border-white/10 bg-white/5 p-5">
        <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
            <div>
                <p id="weather-city" class="text-3xl font-black tracking-tight"></p>
                <p id="weather-condition" class="mt-1 text-sm text-slate-300"></p>
            </div>
            <p id="weather-updated" class="text-xs uppercase tracking-[0.18em] text-slate-400"></p>
        </div>
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="metric-box"><strong id="weather-temperature">—</strong><span>Temperature</span></div>
            <div class="metric-box"><strong id="weather-humidity">—</strong><span>Humidity</span></div>
            <div class="metric-box"><strong id="weather-wind">—</strong><span>Wind</span></div>
            <div class="metric-box"><strong id="weather-country">—</strong><span>Country</span></div>
        </div>
    </div>
</section>

<script>
(() => {
    const form = document.getElementById('weather-search-form');
    const input = document.getElementById('weather-location');
    const status = document.getElementById('weather-status');
    const result = document.getElementById('weather-result');
    const setStatus = (message = '') => {
        status.textContent = message;
        status.classList.toggle('hidden', !message);
    };

    const loadWeather = async (location = '') => {
        setStatus('Loading weather report...');
        result.classList.add('hidden');

        try {
            const response = await fetch(`{{ route('admin.weather.data') }}${location ? `?location=${encodeURIComponent(location)}` : ''}`, {
                headers: { Accept: 'application/json' },
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Weather information is unavailable.');

            document.getElementById('weather-city').textContent = data.city;
            document.getElementById('weather-country').textContent = data.country || '—';
            document.getElementById('weather-condition').textContent = data.condition;
            document.getElementById('weather-temperature').textContent = `${Number(data.temperature).toFixed(1)} °C`;
            document.getElementById('weather-humidity').textContent = `${data.humidity}%`;
            document.getElementById('weather-wind').textContent = `${Number(data.wind_speed).toFixed(1)} m/s`;
            document.getElementById('weather-updated').textContent = `Updated ${data.observed_at}`;
            setStatus();
            result.classList.remove('hidden');
        } catch (error) {
            setStatus(error.message);
        }
    };

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        loadWeather(input.value.trim());
    });

    loadWeather();
})();
</script>
@endsection
