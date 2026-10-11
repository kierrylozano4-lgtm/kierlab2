<script>
const authPage = document.body;
const authCard = document.querySelector('.auth-card');
const robot = document.querySelector('.robot-svg');
const authTransitionKey = 'campusconnect-auth-transition';
const incomingAuthRoute = sessionStorage.getItem(authTransitionKey);
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (authCard && incomingAuthRoute) {
  authPage.classList.add('auth-page--loading');
  authCard.classList.add('auth-card--loading');
  robot?.classList.add('robot-loading');
  authCard.addEventListener('animationend', (event) => {
    if (event.animationName === 'auth-zoom-in') {
      authCard.classList.remove('auth-card--zoom-in');
    }
  });

  const revealAuthCard = () => {
    authPage.classList.remove('auth-page--loading');
    authCard.classList.remove('auth-card--loading');
    robot?.classList.remove('robot-loading');
    authCard.classList.add('auth-card--zoom-in');
    sessionStorage.removeItem(authTransitionKey);
  };

  if (reduceMotion) {
    revealAuthCard();
  } else if (document.readyState === 'complete') {
    window.setTimeout(revealAuthCard, 180);
  } else {
    window.addEventListener('load', () => window.setTimeout(revealAuthCard, 180), { once: true });
  }
}

document.querySelectorAll('[data-auth-route]').forEach((link) => {
  link.addEventListener('click', (event) => {
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || link.target === '_blank') return;

    event.preventDefault();
    const destination = link.dataset.authRoute;
    sessionStorage.setItem(authTransitionKey, destination);

    if (reduceMotion) {
      window.location.assign(link.href);
      return;
    }

    authPage.classList.add('auth-page--leaving');
    authCard?.classList.remove('auth-card--zoom-in');
    authCard?.classList.add('auth-card--zoom-out');
    robot?.classList.add('robot-loading');
    window.setTimeout(() => window.location.assign(link.href), 460);
  });
});
</script>