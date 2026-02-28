@extends('store.layouts.base')

@section('content')
@php
  $section = request('section', 'dashboard');
@endphp

<style>
  @keyframes wave-hand {
    0% { transform: rotate(0deg); }
    15% { transform: rotate(14deg); }
    30% { transform: rotate(-8deg); }
    45% { transform: rotate(14deg); }
    60% { transform: rotate(-4deg); }
    75% { transform: rotate(10deg); }
    100% { transform: rotate(0deg); }
  }
  .wave {
    display: inline-block;
    animation: wave-hand 1.8s infinite;
    transform-origin: 70% 70%;
  }
</style>

{{-- ✅ Welcome Header --}}
<div class="flex items-center justify-between bg-white dark:bg-gray-800 p-5 rounded-xl shadow mb-6">
  <div>
<div class="text-xl font-semibold text-gray-800 dark:text-white mb-1">
      <span class="wave">👋</span> {{ __('dashboard.welcome') }} {{ $store->store_name ?? 'Store' }}
    </div>
<div class="flex flex-wrap text-sm text-gray-600 dark:text-gray-200 gap-4">
      <div>
        📅 <span>Membership started:</span>
        {{ \Carbon\Carbon::parse($store->created_at)->format('Y-m-d') }}
      </div>
      <div>
        ⏳ <span>Expires:</span>
        {{ \Carbon\Carbon::parse($store->created_at)->addYear()->format('Y-m-d') }}
      </div>
    </div>
  </div>

  @if($store->logo)
    <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo"
         class="h-14 w-14 object-cover rounded-full border border-gray-300 shadow" />
  @else
    <div class="h-14 w-14 bg-gray-200 text-gray-500 flex items-center justify-center rounded-full border text-sm shadow">
      No Logo
    </div>
  @endif
</div>

{{-- ✅ Dashboard Section --}}
<div id="dashboard" class="{{ $section !== 'dashboard' ? 'hidden' : '' }}">
  {{-- KPI Grid --}}
  <div class="w-full px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      @include('store.components.kpis')
    </div>

    {{-- Sales Chart --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
      @include('store.components.charts')
    </div>
  </div>




  

{{-- ✅ Products Section --}}
<div id="products-section" class="{{ $section !== 'products' ? 'hidden' : '' }}">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
    <h2 class="text-xl font-bold mb-4"></h2>
    @include('store.sections.products')
  </div>
</div>

{{-- ✅ Orders Section --}}
<div id="orders-section" class="{{ $section !== 'orders' ? 'hidden' : '' }}">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
    <h2 class="text-xl font-bold mb-4"></h2>
    @include('store.sections.orders')
  </div>
</div>

{{-- ✅ Messages Section --}}
<div id="messages-section" class="{{ $section !== 'messages' ? 'hidden' : '' }}">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
    <h2 class="text-xl font-bold mb-4"></h2>
    @include('store.sections.messages')
  </div>
</div>

{{-- ✅ Categories Section --}}
<div id="categories-section" class="{{ $section !== 'categories' ? 'hidden' : '' }}">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
    <h2 class="text-xl font-bold mb-4"></h2>
    @include('store.sections.categories')
  </div>
</div>

{{-- ✅ Settings Section --}}
<div id="settings-section" class="{{ $section !== 'settings' ? 'hidden' : '' }}">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
    <h2 class="text-xl font-bold mb-4">⚙️ Settings</h2>
    @include('store.sections.settings')
  </div>
</div>

{{-- ⚠️ Store Check --}}
@if (!isset($store))
  <div class="text-red-600 font-bold text-xl">❌ \$store is NOT passed to the view</div>
@endif

@endsection
