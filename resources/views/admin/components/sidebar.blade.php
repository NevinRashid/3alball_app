<div class="w-64 h-screen fixed top-0 left-0 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 shadow-sm flex flex-col z-50">
  <!-- Branding -->
  <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700 px-6">
   
      <h1 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">
        <span class="text-blue-600">{{ substr(setting('site_name', 'Codeela'), 0, 1)  }}</span>{{ substr(setting('site_name', 'Codeela'), 1) }}
      </h1>
    
  </div>

  <!-- Navigation -->
  <nav class="flex-1 overflow-y-auto px-4 py-6">
    @php
      $currentSection = request()->get('section', 'overview');
      $nav = [
        ['section' => 'overview', 'label' => 'Dashboard', 'icon' => '📊'],
        ['section' => 'stores', 'label' => 'Stores', 'icon' => '🏪'],
        ['section' => 'products', 'label' => 'Products', 'icon' => '📦'],
        ['section' => 'orders', 'label' => 'Orders', 'icon' => '🛒'],
        ['section' => 'categories', 'label' => 'Categories', 'icon' => '🗂'],
        ['section' => 'finance', 'label' => 'Finance', 'icon' => '💰'],
        ['section' => 'banners', 'label' => 'Banners', 'icon' => '📢'],
        ['section' => 'notifications', 'label' => 'Notifications', 'icon' => '🔔'],
        ['section' => 'users', 'label' => 'Users', 'icon' => '👥'],
        ['section' => 'pages', 'label' => 'Pages', 'icon' => '📄'],
        ['section' => 'payment', 'label' => 'Payment', 'icon' => '💳 '],
        ['section' => 'reviews', 'label' => 'Reviews', 'icon' => '📝'],
        ['section' => 'coupons', 'label' => 'Coupons', 'icon' => '🎟️'],
        ['section' => 'settings', 'label' => 'Settings', 'icon' => '⚙️'],
      ];
    @endphp

    <ul class="space-y-2 text-sm list-none p-0 m-0">
      @foreach($nav as $item)
        @php $isActive = $currentSection === $item['section']; @endphp
        <li>
          <a href="{{ route('admin.dashboard', ['section' => $item['section']]) }}"
             class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
             {{ $isActive ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-blue-800 dark:hover:text-white' }}">
            <span class="text-base">{{ $item['icon'] }}</span>
            <span>{{ $item['label'] }}</span>
          </a>
        </li>
      @endforeach
    </ul>
  </nav>

  <!-- Footer -->
  <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
    <div class="text-xs text-gray-400 dark:text-gray-500">
      {{ setting('footer_text', 'Super Admin Panel') }} • {{ date('Y') }}
    </div>
  </div>
</div>
