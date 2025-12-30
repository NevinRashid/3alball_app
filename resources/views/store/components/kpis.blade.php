  {{-- ✅ Products Live --}}
  <div class="w-full bg-white dark:bg-gray-800 shadow p-6 rounded-2xl border-t-4 border-blue-500 text-center hover:scale-[1.01] transition-transform duration-200">
    <div class="flex flex-col items-center space-y-2">
      <div class="text-blue-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
        </svg>
      </div>
      <div class="text-sm text-gray-500 dark:text-gray-300">@lang('dashboard.products_live')</div>
      <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $products->count() }}</div>
    </div>
  </div>

  {{-- ✅ Total Orders --}}
  <div class="w-full bg-white dark:bg-gray-800 shadow p-6 rounded-2xl border-t-4 border-indigo-500 text-center hover:scale-[1.01] transition-transform duration-200">
    <div class="flex flex-col items-center space-y-2">
      <div class="text-indigo-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6" />
        </svg>
      </div>
      <div class="text-sm text-gray-500 dark:text-gray-300">@lang('dashboard.total_orders')</div>
      <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $orders->count() }}</div>
    </div>
  </div>

  {{-- ✅ Total Revenue --}}
  <div class="w-full bg-white dark:bg-gray-800 shadow p-6 rounded-2xl border-t-4 border-green-500 text-center hover:scale-[1.01] transition-transform duration-200">
    <div class="flex flex-col items-center space-y-2">
      <div class="text-green-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
        </svg>
      </div>
      <div class="text-sm text-gray-500 dark:text-gray-300">@lang('dashboard.total_revenue')</div>
      <div class="text-3xl font-bold text-green-600 dark:text-green-400 break-words">
        {{ number_format($orders->sum('total_price'), 2) }} JOD
      </div>
    </div>
  </div>

  {{-- ✅ Membership Status --}}
  @php $expired = $store->created_at->addYear()->isPast(); @endphp
  <div class="w-full bg-white dark:bg-gray-800 shadow p-6 rounded-2xl border-t-4 {{ $expired ? 'border-red-500' : 'border-green-500' }} text-center hover:scale-[1.01] transition-transform duration-200">
    <div class="flex flex-col items-center space-y-2">
      <div class="{{ $expired ? 'text-red-500' : 'text-green-600' }}">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <div class="text-sm text-gray-500 dark:text-gray-300">@lang('dashboard.membership_status')</div>
      <div class="text-2xl font-bold {{ $expired ? 'text-red-500' : 'text-green-600' }}">
        {{ $expired ? __('dashboard.expired') : __('dashboard.active') }}
      </div>
    </div>
  </div>

</div>
