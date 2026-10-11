<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login · CampusConnect</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page min-h-screen px-4 py-6 text-slate-900 sm:px-6 sm:py-10">
<main class="auth-shell login-shell mx-auto w-full">
  @include('auth.partials.showcase', ['eyebrow' => 'Your campus, connected', 'heading' => 'Good to see you', 'highlight' => 'again.', 'description' => 'Pick up where you left off. Your people, projects, and campus life are right here.', 'robotMessage' => 'Your campus crew is just a sign-in away.'])
  <section class="auth-card login-content" aria-labelledby="login-title">
    <div class="w-full max-w-md">
      <div class="mb-8 login-intro">
        <p class="auth-kicker text-xs font-bold uppercase tracking-[0.18em] text-orange-600">Member access</p>
        <h1 id="login-title" class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">Welcome back</h1>
        <p class="mt-3 text-sm leading-6 text-slate-500">Sign in with your campus account to continue.</p>
      </div>
      @if (session('status'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('status') }}</div>
      @endif
      @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">{{ $errors->first() }}</div>
      @endif
      <form method="POST" action="{{ route('login.store') }}" class="login-form space-y-5" id="loginForm">
        @csrf
        <div class="form-field">
          <label class="auth-label mb-2 block text-sm font-bold text-slate-700" for="email">Email address</label>
          <input class="login-input w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@campus.edu" autocomplete="username" required>
        </div>
        <div class="form-field">
          <div class="mb-2 flex items-center justify-between gap-3"><label class="auth-label block text-sm font-bold text-slate-700" for="password">Password</label></div>
          <div class="relative">
            <input class="login-input w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 pr-20 text-sm text-slate-900 outline-none transition" id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>
            <button class="password-toggle absolute inset-y-0 right-3 my-auto rounded-md px-2 text-xs font-bold text-slate-500 transition hover:text-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600" type="button" id="togglePassword" aria-controls="password" aria-pressed="false">Show</button>
          </div>
        </div>
        <label class="remember-option flex w-fit cursor-pointer items-center gap-2.5 text-sm text-slate-600">
          <input name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-600">
          Remember me
        </label>
        <button class="login-submit flex w-full items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700" type="submit">
          <span class="submit-label">Sign in</span>
          <svg viewBox="0 0 20 20" class="h-4 w-4 transition-transform" fill="none" aria-hidden="true"><path d="M4 10h12m-5-5 5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <div class="auth-switch pt-1 text-center text-sm text-slate-500">New to CampusConnect? <a data-auth-route="register" href="{{ route('register') }}" class="auth-route-link font-bold text-orange-700 decoration-2 underline-offset-4 hover:underline">Create an account</a></div>
      </form>
      <div class="mt-8 flex items-center gap-3 text-xs text-slate-400"><span class="h-px flex-1 bg-slate-200"></span><span>YOUR CAMPUS COMMUNITY</span><span class="h-px flex-1 bg-slate-200"></span></div>
      <p class="mt-5 text-center text-xs text-slate-400">Demo users use the password <strong class="font-semibold text-slate-500">password</strong>.</p>
    </div>
  </section>
</main>
<script>
const loginForm = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const passwordToggle = document.getElementById('togglePassword');
const robotEyes = document.querySelectorAll('.robot-eyes .pupil');
const robotText = document.querySelector('.robot-text-content');

passwordToggle.addEventListener('click', () => {
  const isVisible = passwordInput.type === 'text';
  passwordInput.type = isVisible ? 'password' : 'text';
  passwordToggle.textContent = isVisible ? 'Show' : 'Hide';
  passwordToggle.setAttribute('aria-pressed', String(!isVisible));
  passwordInput.focus();
});

document.addEventListener('pointermove', (event) => {
  if (event.pointerType !== 'mouse') return;

  const robotContainer = document.querySelector('.robot-container');
  if (!robotContainer) return;

  const bounds = robotContainer.getBoundingClientRect();
  const angle = Math.atan2(event.clientY - (bounds.top + bounds.height / 2), event.clientX - (bounds.left + bounds.width / 2));

  robotEyes.forEach((pupil) => {
    const baseX = Number(pupil.dataset.baseCx);
    const baseY = Number(pupil.dataset.baseCy);
    pupil.setAttribute('cx', baseX + Math.cos(angle) * 3);
    pupil.setAttribute('cy', baseY + Math.sin(angle) * 3);
  });
});

emailInput.addEventListener('focus', () => {
  document.querySelector('.right-arm').classList.add('wave');
  if (robotText) robotText.textContent = 'Use your campus email to get right back in.';
});

passwordInput.addEventListener('focus', () => {
  if (robotText) robotText.textContent = 'Almost there. Your campus crew is waiting.';
});

loginForm.addEventListener('submit', () => {
  document.querySelector('.robot-svg').classList.add('celebrate');
  loginForm.querySelector('.submit-label').textContent = 'Signing in';
});
</script>
@include('auth.partials.route-transition')
</body>
</html>