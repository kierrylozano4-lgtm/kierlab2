<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register · CampusConnect</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page min-h-screen px-4 py-6 text-slate-900 sm:px-6 sm:py-10">
<main class="auth-shell register-shell mx-auto w-full">
    @include('auth.partials.showcase', ['eyebrow' => 'Your campus, connected', 'heading' => 'Make it', 'highlight' => 'yours.', 'description' => 'Meet your people, find your next project, and make campus life feel a little smaller.', 'robotMessage' => 'A great campus story starts with you.'])
    <section class="auth-card login-content" aria-labelledby="register-title">
        <div class="w-full max-w-md">
            <div class="mb-7 login-intro">
                <p class="auth-kicker text-xs font-bold uppercase tracking-[0.18em] text-orange-700">New member</p>
                <h1 id="register-title" class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">Create your account</h1>
                <p class="mt-3 text-sm leading-6 text-slate-500">One account brings your campus community together.</p>
            </div>
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('register.store') }}" class="login-form space-y-4" id="registerForm">
                @csrf
                <div class="form-field">
                    <label class="auth-label mb-2 block text-sm font-bold text-slate-700" for="name">Full name</label>
                      <input class="login-input w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Your name" autocomplete="name" required>
                </div>
                <div class="form-field">
                    <label class="auth-label mb-2 block text-sm font-bold text-slate-700" for="email">Email address</label>
                    <input class="login-input w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@campus.edu" autocomplete="email" required>
                </div>
                <div class="register-password-grid grid gap-4 sm:grid-cols-2">
                    <div class="form-field">
                        <label class="auth-label mb-2 block text-sm font-bold text-slate-700" for="password">Password</label>
                        <input class="login-input w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition" id="password" name="password" type="password" autocomplete="new-password" required>
                    </div>
                    <div class="form-field">
                        <label class="auth-label mb-2 block text-sm font-bold text-slate-700" for="password_confirmation">Confirm password</label>
                        <input class="login-input w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    </div>
                </div>
                <button class="login-submit flex w-full items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700" type="submit">
                    <span class="submit-label">Create account</span>
                    <svg viewBox="0 0 20 20" class="h-4 w-4 transition-transform" fill="none" aria-hidden="true"><path d="M4 10h12m-5-5 5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="auth-switch pt-1 text-center text-sm text-slate-500">Already have an account? <a data-auth-route="login" href="{{ route('login') }}" class="auth-route-link font-bold text-orange-700 decoration-2 underline-offset-4 hover:underline">Sign in</a></div>
            </form>
            <div class="mt-7 flex items-center gap-3 text-xs text-slate-400"><span class="h-px flex-1 bg-slate-200"></span><span>YOUR CAMPUS COMMUNITY</span><span class="h-px flex-1 bg-slate-200"></span></div>
        </div>
    </section>
</main>
<script>
const registerForm = document.getElementById('registerForm');

registerForm.addEventListener('submit', () => {
    document.querySelector('.robot-svg').classList.add('celebrate');
    registerForm.querySelector('.submit-label').textContent = 'Creating account';
});
</script>
@include('auth.partials.route-transition')
</body>
</html>