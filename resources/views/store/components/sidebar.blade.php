<!-- sidebar.blade.php -->
<aside class="h-screen w-64 bg-gray-900 text-white flex flex-col justify-between shadow-lg">

  <!-- 🔷 Top: Logo -->
  <div>
    <div class="flex items-center justify-center px-6 py-4 border-b border-gray-700">
    <img src="{{ asset('images/3albal-removebg-preview.png') }}" alt="3albal Logo" class="h-10 md:h-10 animate-logo-spin">

    </div>

    @php $currentSection = request('section', 'dashboard'); @endphp

    <!-- 🔷 Navigation Links -->
    <nav class="px-4 py-6 space-y-2 text-sm font-medium">
      <a href="{{ route('store.dashboard', ['section' => 'dashboard']) }}"
         class="flex items-center gap-3 px-4 py-2 rounded {{ $currentSection == 'dashboard' ? 'bg-gray-800' : '' }} hover:bg-gray-800 transition">
        🏠 <span>Dashboard</span>
      </a>
      <a href="{{ route('store.dashboard', ['section' => 'products']) }}"
         class="flex items-center gap-3 px-4 py-2 rounded {{ $currentSection == 'products' ? 'bg-gray-800' : '' }} hover:bg-gray-800 transition">
        🛍️ <span>Products</span>
      </a>
      <a href="{{ route('store.dashboard', ['section' => 'orders']) }}"
         class="flex items-center gap-3 px-4 py-2 rounded {{ $currentSection == 'orders' ? 'bg-gray-800' : '' }} hover:bg-gray-800 transition">
        📦 <span>Orders</span>
      </a>
      <a href="{{ route('store.dashboard', ['section' => 'messages']) }}"
         class="flex items-center gap-3 px-4 py-2 rounded {{ $currentSection == 'messages' ? 'bg-gray-800' : '' }} hover:bg-gray-800 transition">
        💬 <span>Messages</span>
      </a>
      <a href="{{ route('store.dashboard', ['section' => 'categories']) }}"
         class="flex items-center gap-3 px-4 py-2 rounded {{ $currentSection == 'categories' ? 'bg-gray-800' : '' }} hover:bg-gray-800 transition">
        🗂 <span>Categories</span>
      </a>
      <a href="{{ route('store.dashboard', ['section' => 'settings']) }}"
         class="flex items-center gap-3 px-4 py-2 rounded {{ $currentSection == 'settings' ? 'bg-gray-800' : '' }} hover:bg-gray-800 transition">
        ⚙️ <span>Settings</span>
      </a>
    </nav>
  </div>

  <!-- 🔻 Bottom: Logout + Language -->
  <div class="px-4 pb-6 space-y-4">

    <!-- 🔴 Logout -->
    <form method="POST" action="{{ route('store.logout') }}">
      @csrf
      <button type="submit"
              class="w-full flex items-center gap-3 px-4 py-2 rounded text-red-400 hover:bg-red-800 hover:text-white transition">
        🚪 <span>Logout</span>
      </button>
    </form>

    <!-- 🌐 Language Switcher -->
    <div class="border-t border-gray-700 pt-4 text-xs">
      <div class="text-gray-400 mb-1">Language</div>
      <div class="flex gap-3">
        <a href="{{ route('change.language', 'en') }}" class="hover:underline {{ app()->getLocale() == 'en' ? 'font-bold text-white' : 'text-gray-400' }}">EN</a>
        <a href="{{ route('change.language', 'ar') }}" class="hover:underline {{ app()->getLocale() == 'ar' ? 'font-bold text-white' : 'text-gray-400' }}">AR</a>
      </div>
    </div>
  </div>
</aside>
