<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('store_theme', 'light') }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ __('dashboard.store_panel') }}</title>
  <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">


  {{-- Chart.js & Tailwind --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  {{-- Optional: Add custom master design style --}}
  <style>
    html.dark body {
      background-color: #0f172a;
      color: #f1f5f9;
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
    if (document.documentElement.classList.contains('auto')) {
      if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('mobileOverlay');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }
  </script>
</body>

</html>
