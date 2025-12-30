<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Super Admin Panel')</title>
    <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @stack('styles')
</head>
@push('scripts')
<script>
    const notifButton = document.getElementById('notifButton');
    const notifDropdown = document.getElementById('notifDropdown');

    notifButton?.addEventListener('click', () => {
        notifDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!notifButton.contains(event.target) && !notifDropdown.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    });
</script>
@endpush

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen antialiased font-sans">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('admin.components.sidebar')

        {{-- Page content --}}
        <div class="flex-1 flex flex-col overflow-hidden ml-64">
            {{-- Top Navbar --}}
            <header class="w-full bg-white dark:bg-gray-800 shadow px-6 py-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white tracking-tight">
                    @yield('title', setting('site_name', 'Super Admin Panel'))
                </h1>

                <div class="flex items-center gap-6">
                    {{-- Notifications Dropdown --}}
                    <div class="relative">
                        <button id="notifButton" class="relative focus:outline-none">
                            <span class="text-2xl">🔔</span>
                            @php
                                $newOrders = \App\Models\Order::latest()->take(3)->get();
                                $newUsers = \App\Models\User::latest()->take(3)->get();
                                $newProducts = \App\Models\Product::latest()->take(3)->get();
                                $newChats = \App\Models\liveChat::where('is_read', false)->count();
                                $hasNew = $newOrders->count() + $newUsers->count() + $newProducts->count() > 0;
                            @endphp
                            @if($hasNew)
                                <span class="absolute -top-1 -right-1 h-2 w-2 bg-red-500 rounded-full animate-ping"></span>
                            @endif
                        </button>

                        <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50">
                            <div class="p-4 border-b text-sm font-semibold text-gray-700 dark:text-gray-200">🔔 Notifications</div>

                            <ul class="max-h-64 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                                @foreach($newOrders as $order)
                                    <li class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        🛒 New order from {{ optional($order->user)->name ?? 'Guest' }}
                                    </li>
                                @endforeach
                                @foreach($newUsers as $user)
                                    <li class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        👤 New user: {{ $user->name }}
                                    </li>
                                @endforeach
                                @foreach($newProducts as $product)
                                    <li class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        📦 New product: {{ $product->name }}
                                    </li>
                                @endforeach
                            </ul>

                            @if(!$hasNew)
                                <div class="p-4 text-center text-gray-400 text-sm">No new notifications</div>
                            @endif
                        </div>
                    </div>

                    {{-- Live Chat Icon Button --}}
                    <a href="{{ route('admin.livechat.index') }}" class="relative inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-md hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        @if($newChats > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                {{ $newChats }}
                            </span>
                        @endif
                    </a>

                    {{-- Logo on the far right --}}
                    @if(setting('site_logo'))
                        <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="Logo" class="h-8 w-auto object-contain max-w-[120px]">
                    @endif
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
