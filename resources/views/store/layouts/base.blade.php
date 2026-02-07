<!DOCTYPE html>
@php
$theme = session('store_theme', $store->theme ?? 'auto');
@endphp

<html lang="{{ app()->getLocale() }}" class="{{ $theme === 'dark' ? 'dark' : '' }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ __('dashboard.store_panel') }}</title>
  <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">


  {{-- Chart.js & Tailwind --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  tailwind = {
    config: {
      darkMode: 'class'
    }
  }
</script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  {{-- Optional: Add custom master design style --}}
  <style>
    /* =========================
   Dark mode overrides (class-based)
   Works even with Tailwind CDN CSS file
   ========================= */

html.dark body {
  background-color: #0f172a;
  color: #f1f5f9;
}

/* Layout backgrounds */
html.dark #sidebar {
  background-color: #1f2937 !important;
}

html.dark main {
  background-color: #111827 !important;
}

/* Any white "card" inside main becomes dark */
html.dark main .bg-white {
  background-color: #1f2937;
}

/* Only darken cards that DON'T already have a Tailwind dark:bg-... */
html.dark main .bg-white:not([class*="dark:bg-"]) {
  background-color: #1f2937;
}

/* only convert THESE containers, not every bg-white in the whole app */
html.dark .panel {
  background-color: #1f2937;
}
  

/* Mobile top bar (yours has bg-white) */
html.dark .md\:hidden.bg-white {
  background-color: #1f2937 !important;
}

/* Borders */
html.dark .border-gray-200,
html.dark .border-gray-300 {
  border-color: #374151 !important;
}

/* Inputs/select/file controls */
html.dark input,
html.dark select,
html.dark textarea {
  background-color: #111827 !important;
  color: #f1f5f9 !important;
  border-color: #374151 !important;
}

html.dark input::placeholder,
html.dark textarea::placeholder {
  color: #9ca3af !important;
}

    .glass-card {
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .section-heading {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .transition-card {
      transition: all 0.3s ease;
    }

    .transition-card:hover {
      transform: scale(1.02);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    @keyframes logoFadeZoom {
    0% {
      opacity: 0;
      transform: scale(0.8) rotate(-5deg);
    }
    100% {
      opacity: 1;
      transform: scale(1) rotate(0deg);
    }
  }

  .animate-logo-spin {
    animation: logoFadeZoom 0.6s ease-out forwards;
  }

  /* =========================
   Dark mode text visibility fixes
   ========================= */


/* Fix labels becoming unreadable */
html.dark label {
  color: #e5e7eb !important; /* Tailwind gray-200 */
}

/* Fix section headings */
html.dark h1,
html.dark h2,
html.dark h3 {
  color: #f9fafb !important;
}

/* Fix muted helper text */
html.dark .text-gray-500,
html.dark .text-gray-600 {
  color: #d1d5db !important; /* gray-300 */
}

/* Fix headings / strong text that stays dark in dark mode */
html.dark .text-gray-800 {
  color: #f9fafb !important; /* almost white */
}
html.dark .text-gray-700 {
  color: #e5e7eb !important; /* gray-200 */
}

/* Tables (Store panel)
   ========================= */
html.dark .dark-table thead { background: #374151 !important; }
html.dark .dark-table thead th { color: #e5e7eb !important; }
html.dark .dark-table tbody { background: #1f2937 !important; }
html.dark .dark-table tbody tr:hover { background: #334155 !important; }
html.dark .dark-table td { border-color: rgba(148,163,184,0.15) !important; }

/* Dark mode border system
   ========================= */

/* Generic borders */
html.dark .border,
html.dark .border-gray-200,
html.dark .border-gray-300 {
  border-color: rgba(148, 163, 184, 0.15) !important;
}

/* Table row dividers */
html.dark tbody tr {
  border-color: rgba(148, 163, 184, 0.12) !important;
}

/* Table header bottom line */
html.dark thead tr {
  border-color: rgba(148, 163, 184, 0.18) !important;
}

/* Inputs / selects / textareas */
html.dark input,
html.dark select,
html.dark textarea {
  border-color: rgba(148, 163, 184, 0.25) !important;
}
html.dark input:focus,
html.dark select:focus,
html.dark textarea:focus {
  border-color: rgba(96, 165, 250, 0.6) !important;
  box-shadow: 0 0 0 1px rgba(96, 165, 250, 0.35);
} 
html.dark .filter-ui {
  background: #ffffff !important;
  color: #111827 !important;
  border-color: #d1d5db !important;
}
html.dark .filter-ui:focus {
  border-color: #93c5fd !important;
  box-shadow: 0 0 0 2px rgba(147,197,253,0.35) !important;
}
html.dark input[type="date"] {
  color-scheme: dark;
}

/* Orders card surface: slightly lighter than the panel */
html.dark .order-card {
  background: rgba(51, 65, 85, 0.55) !important; /* slate-ish glass */
  border-color: rgba(148, 163, 184, 0.14) !important;
}

/* optional: hover glow */
html.dark .order-card:hover {
  background: rgba(51, 65, 85, 0.65) !important;
}

/* Chat bubble fix in dark mode */
html.dark .chat-other {
  background: rgba(51, 65, 85, 0.65) !important;  /* slate-ish */
  color: #e5e7eb !important;
}

html.dark .chat-other small {
  color: rgba(226, 232, 240, 0.65) !important;
}

/* Chat panel surface: slightly card-like */
html.dark #chat-panel {
  background: #0b1220 !important; /* deeper than main */
}

/* Header + form match your dark UI */
html.dark #chat-panel .dark\:bg-gray-800 {
  background: rgba(31, 41, 55, 0.85) !important;
}

/* Bubbles */
.chat-store {
  background: #2563eb; /* blue-600 */
  color: #fff;
}

html.dark .chat-customer {
  background: rgba(51, 65, 85, 0.65) !important; /* slate glass */
  color: #e5e7eb !important;
}

/* Light mode customer bubble stays light */
.chat-customer {
  background: #e5e7eb; /* gray-200 */
  color: #111827;      /* gray-900 */
}

/* Timestamps */
.chat-time {
  color: rgba(255,255,255,0.65);
}
.chat-customer .chat-time {
  color: rgba(17,24,39,0.55);
}
html.dark .chat-customer .chat-time {
  color: rgba(226,232,240,0.60) !important;
}

/* Header row stays white -> force it dark */
html.dark thead.bg-gray-100 {
  background: #374151 !important;
}
html.dark thead.bg-gray-100 th {
  color: #e5e7eb !important;
}

/* Body stays white -> force it dark */
html.dark tbody.bg-white {
  background: #1f2937 !important;
}

/* Row hover */
html.dark tr.hover\:bg-gray-50:hover {
  background: #334155 !important;
}

/* Divider lines */
html.dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]) {
  border-color: rgba(148, 163, 184, 0.15) !important;
}
  </style>
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100">
  <div class="flex min-h-screen overflow-hidden">

    {{-- Sidebar --}}
    <div id="mobileOverlay"
         class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden"
         onclick="toggleSidebar()"></div>

    <aside id="sidebar"
           class="fixed md:relative inset-y-0 left-0 z-40 w-64 bg-white dark:bg-gray-800 shadow-md transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out">
      <div class="p-4 md:hidden flex justify-between items-center border-b dark:border-gray-700">
        <span class="font-bold text-lg">{{ __('dashboard.store_panel') }}</span>
        <button onclick="toggleSidebar()" class="text-2xl">&times;</button>
      </div>
      @include('store.components.sidebar')
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
      {{-- Mobile Top Bar --}}
      <div class="md:hidden flex items-center justify-between p-4 bg-white shadow dark:bg-gray-800">
        <button onclick="toggleSidebar()" class="text-2xl text-gray-700 dark:text-gray-200">☰</button>
        <h1 class="text-lg font-semibold">{{ __('dashboard.store_panel') }}</h1>
      </div>

      <main class="flex-1 p-4 md:p-6 overflow-auto bg-gray-50 dark:bg-gray-800">
        @yield('content')
      </main>
    </div>

  </div>

  @stack('scripts')

  {{-- JS for dynamic section switching --}}
  <script>
    function showSection(idToShow) {
      const sections = ['dashboard', 'products-section', 'orders-section', 'categories-section', 'settings-section', 'messages-section'];
      sections.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
      });

      const target = document.getElementById(idToShow);
      if (target) target.classList.remove('hidden');

      document.querySelectorAll('aside a').forEach(a => a.classList.remove('bg-blue-100', 'text-blue-700', 'dark:bg-blue-900'));
      const active = document.querySelector(`aside a[onclick*="${idToShow}"]`);
      if (active) active.classList.add('bg-blue-100', 'text-blue-700', 'dark:bg-blue-900');
    }
  </script>

  {{-- JS for theme auto-switching --}}
  <script>
  (function () {
    const theme = @json(session('store_theme', $store->theme ?? 'auto'));

    function setDark(isDark) {
      document.documentElement.classList.toggle('dark', isDark);
    }

    if (theme === 'dark') setDark(true);
    else if (theme === 'light') setDark(false);
    else {
      // auto
      const mq = window.matchMedia('(prefers-color-scheme: dark)');
      setDark(mq.matches);

      // live update if OS theme changes
      mq.addEventListener('change', (e) => setDark(e.matches));
    }
  })();
</script>

</body>

</html>
