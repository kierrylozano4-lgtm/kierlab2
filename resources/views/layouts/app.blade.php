<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CampusConnect' }} · CampusConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f7fa] text-[#172b4d]">
    <header class="fixed inset-x-0 top-0 z-40 h-[72px] bg-[#0b1830] text-white shadow-lg">
        <div class="flex h-full items-center justify-between px-5 lg:px-8">
            <a href="{{ auth()->user()?->role === 'Admin' ? route('admin') : route('users.index') }}" class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#1464e8] shadow-lg shadow-blue-950/30">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m2 9 10-5 10 5-10 5L2 9Zm4 3.1v4.6c0 1.4 2.7 3.3 6 3.3s6-1.9 6-3.3v-4.6l-6 3-6-3Z"/><path d="M21 10v6h-2v-5l2-1Z"/></svg>
                </span>
                <span><span class="block text-lg font-black tracking-tight">CampusConnect</span><span class="hidden text-[10px] tracking-wide text-slate-300 sm:block">Learn <span class="text-blue-400">•</span> Manage <span class="text-blue-400">•</span> Grow</span></span>
            </a>
            <div class="flex items-center gap-4">
                <button type="button" class="relative rounded-lg p-2 text-slate-200 hover:bg-white/10" aria-label="Notifications"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17H9m10-1H5l1.4-1.8A2 2 0 0 0 6.8 13V10a5.2 5.2 0 0 1 10.4 0v3c0 .4.1.8.4 1.2L19 16ZM13.7 20a2 2 0 0 1-3.4 0"/></svg><span class="absolute right-1 top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#ef4444] px-1 text-[9px] font-bold">3</span></button>
                @auth
                    <div class="flex items-center gap-2 border-l border-white/15 pl-4"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-blue-200 to-slate-100 text-sm font-black text-[#1464e8]">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span class="hidden text-sm font-semibold sm:block">{{ auth()->user()->name }}</span><span class="hidden text-xs text-slate-300 sm:block">{{ auth()->user()->role }}</span><svg class="h-4 w-4 text-slate-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.2 7.5a.75.75 0 0 1 1.05.1L10 11.7l3.75-4.1a.75.75 0 1 1 1.1 1.02l-4.3 4.7a.75.75 0 0 1-1.1 0l-4.3-4.7a.75.75 0 0 1 .05-1.12Z" clip-rule="evenodd"/></svg></div>
                    <form method="POST" action="{{ route('logout') }}" class="md:hidden">
                        @csrf
                        <button type="submit" class="rounded-lg p-2 text-slate-200 transition hover:bg-red-500/15 hover:text-red-200" aria-label="Log out" title="Log out">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 5H6a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h4m5-4 4-3-4-3m4 3H9"/></svg>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>
    <aside class="fixed bottom-0 left-0 top-[72px] z-30 hidden w-[252px] overflow-hidden bg-[#101d35] text-slate-300 md:block">
        <nav class="space-y-2 px-4 py-7" aria-label="Primary navigation">
            <p class="mb-4 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Workspace</p>
            <a href="{{ route('admin') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin') ? 'bg-[#1464e8] text-white shadow-lg shadow-blue-950/40' : 'hover:bg-white/10 hover:text-white' }}"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 11 9-8 9 8v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9Z"/></svg>Dashboard</a>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('users.*') ? 'bg-[#1464e8] text-white shadow-lg shadow-blue-950/40' : 'hover:bg-white/10 hover:text-white' }}"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2"/><path d="M3.5 19a5.5 5.5 0 0 1 11 0M15 16c2.8-.4 5.5 1.2 5.5 3"/></svg>Campus Users</a>
            <a href="{{ route('weather.page') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('weather.*') ? 'bg-[#1464e8] text-white shadow-lg shadow-blue-950/40' : 'hover:bg-white/10 hover:text-white' }}"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 19h11a4 4 0 0 0 .5-8A6 6 0 0 0 6 12a3.5 3.5 0 0 0 0 7Z"/></svg>Weather Report</a>
            <div class="my-6 border-t border-white/10"></div>
            @foreach (['Programs', 'Announcements', 'Reports', 'Settings'] as $item)<span class="flex cursor-not-allowed items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-500"><span class="h-5 w-5 rounded-md border border-slate-600"></span>{{ $item }}</span>@endforeach
            <div class="my-6 border-t border-white/10"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-slate-300 transition hover:bg-red-500/15 hover:text-red-200">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 5H6a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h4m5-4 4-3-4-3m4 3H9"/></svg>
                    Log out
                </button>
            </form>
        </nav>
        <div class="pointer-events-none absolute bottom-0 left-0 right-0 px-6 pb-8"><div class="mb-5 h-20 overflow-hidden rounded-full bg-blue-500/10 blur-sm"></div><p class="text-center text-xs leading-5 text-slate-400">Better Management<br>for a Brighter Campus.</p></div>
    </aside>
    <main class="min-h-screen pt-[72px] md:pl-[252px]">
        <div class="mx-auto max-w-[1600px] px-4 py-5 sm:px-6 lg:px-10 lg:py-8">
            @if (session('status'))<div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>@endif
            @if ($errors->any())<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><p class="font-semibold">Please correct the highlighted fields.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </div>
    </main>
</body>
</html>
