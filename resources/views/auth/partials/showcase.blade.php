@include('auth.partials.dna-background')
<header class="auth-scene-header auth-mascot" aria-label="CampusConnect">
  <a class="brand-lockup flex w-fit items-center gap-3 text-white no-underline" href="{{ route('login') }}" aria-label="CampusConnect sign in">
    <span class="brand-mark grid h-11 w-11 place-items-center rounded-2xl bg-white text-blue-700 shadow-lg shadow-blue-950/20" aria-hidden="true">
      <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none"><path d="M4 19.5V8.7a1 1 0 0 1 1.48-.88l6.04 3.32a1 1 0 0 0 .96 0l6.04-3.32A1 1 0 0 1 20 8.7v10.8M7 5.5h10M9 3.5h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 12v7.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
    </span>
    <span class="text-lg font-extrabold tracking-tight">CampusConnect</span>
  </a>
  <div class="robot-stage">
    <div class="robot-container">
      <svg viewBox="0 0 200 280" class="robot-svg" role="img" aria-label="CampusConnect mascot robot">
        <defs>
          <linearGradient id="robot-head" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#9bdcff"/><stop offset=".42" stop-color="#438cf4"/><stop offset="1" stop-color="#2851c8"/></linearGradient>
          <linearGradient id="robot-body" x1="0" y1="0" x2="0.9" y2="1"><stop stop-color="#72c8ff"/><stop offset=".55" stop-color="#397ce7"/><stop offset="1" stop-color="#244cb7"/></linearGradient>
          <linearGradient id="robot-glass" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#d8f8ff"/><stop offset="1" stop-color="#78d7fa"/></linearGradient>
          <filter id="robot-shadow" x="-30%" y="-20%" width="160%" height="160%"><feDropShadow dx="0" dy="7" stdDeviation="5" flood-color="#061b4b" flood-opacity=".38"/></filter>
        </defs>
        <g class="robot-antenna"><path d="M100 36V17" stroke="#a8eaff" stroke-width="5" stroke-linecap="round"/><circle class="antenna-light" cx="100" cy="12" r="8" fill="#ffd76a" stroke="#fff1b7" stroke-width="2"/><path d="M100 4v-3" stroke="#fff5cb" stroke-width="2" stroke-linecap="round"/></g>
        <g filter="url(#robot-shadow)">
        <path d="M51 52 38 61v40l13 8M149 52l13 9v40l-13 8" fill="#2f61ca" stroke="#a6dfff" stroke-width="3"/>
        <circle cx="43" cy="81" r="5" fill="#ffd76a"/><circle cx="157" cy="81" r="5" fill="#ffd76a"/>
        <rect x="48" y="38" width="104" height="104" rx="25" fill="url(#robot-head)" stroke="#c9f2ff" stroke-width="3"/>
        <path d="M59 52q6-9 17-9h49" fill="none" stroke="#fff" stroke-opacity=".52" stroke-width="4" stroke-linecap="round"/>
        <g class="robot-eyes">
            <g class="eye"><rect x="62" y="63" width="32" height="31" rx="12" fill="#f5fcff" stroke="#1750a5" stroke-width="2"/><circle class="pupil" cx="78" cy="78" data-base-cx="78" data-base-cy="78" r="8" fill="#183b8c"/><circle cx="81" cy="74" r="2.5" fill="#fff"/></g>
            <g class="eye"><rect x="106" y="63" width="32" height="31" rx="12" fill="#f5fcff" stroke="#1750a5" stroke-width="2"/><circle class="pupil" cx="122" cy="78" data-base-cx="122" data-base-cy="78" r="8" fill="#183b8c"/><circle cx="125" cy="74" r="2.5" fill="#fff"/></g>
        </g>
        <path d="M79 111q21 18 42 0" stroke="#17429c" stroke-width="4" fill="none" stroke-linecap="round"/>
        <circle cx="59" cy="105" r="5" fill="#ff9eaf" fill-opacity=".8"/><circle cx="141" cy="105" r="5" fill="#ff9eaf" fill-opacity=".8"/>
        <path d="M93 143v10h14v-10" fill="#2456bf" stroke="#a5dfff" stroke-width="2"/>
        <rect x="43" y="151" width="114" height="91" rx="19" fill="url(#robot-body)" stroke="#bceeff" stroke-width="3"/>
        <path d="M56 163q4-7 13-7h62" fill="none" stroke="#fff" stroke-opacity=".45" stroke-width="4" stroke-linecap="round"/>
        <rect x="61" y="169" width="78" height="55" rx="11" fill="#174caa" stroke="#a6ddff" stroke-width="2"/>
        <rect x="67" y="175" width="66" height="43" rx="8" fill="url(#robot-glass)"/>
        <path d="M73 207h54" stroke="#2671c9" stroke-width="2" stroke-linecap="round"/>
        <circle class="chest-light chest-light-one" cx="84" cy="191" r="5" fill="#ffcf62"/><circle class="chest-light chest-light-two" cx="100" cy="191" r="5" fill="#ff8297"/><circle class="chest-light chest-light-three" cx="116" cy="191" r="5" fill="#42dfc1"/>
        <circle cx="52" cy="158" r="5" fill="#e0f8ff"/><circle cx="148" cy="158" r="5" fill="#e0f8ff"/>
        <g class="robot-arm robot-arm-left"><path d="M46 174 30 186" stroke="#74caff" stroke-width="13" stroke-linecap="round"/><circle cx="28" cy="188" r="11" fill="#397ce7" stroke="#c1efff" stroke-width="3"/></g>
        <g class="right-arm"><path d="M154 174 172 160" stroke="#74caff" stroke-width="13" stroke-linecap="round"/><circle cx="177" cy="156" r="12" fill="#397ce7" stroke="#c1efff" stroke-width="3"/><path d="m173 146 2-9m7 9 5-8" stroke="#ffd76a" stroke-width="3" stroke-linecap="round"/></g>
        <path d="M75 243v19m50-19v19" stroke="#74caff" stroke-width="15" stroke-linecap="round"/>
        <circle cx="75" cy="253" r="6" fill="#d7f4ff"/><circle cx="125" cy="253" r="6" fill="#d7f4ff"/>
        <path d="M65 267h20m30 0h20" stroke="#2758c4" stroke-width="12" stroke-linecap="round"/><path d="M67 264h15m35 0h15" stroke="#a9dfff" stroke-width="3" stroke-linecap="round"/>
        </g>
      </svg>
      <div class="robot-text" role="status" aria-live="polite"><span class="robot-text-content">{{ $robotMessage }}</span></div>
    </div>
  </div>
</header>