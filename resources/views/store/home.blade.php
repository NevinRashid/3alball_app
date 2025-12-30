@extends('store.layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Welcome, {{ $store->store_name }}</h1>

  <p class="text-sm text-gray-500 mb-6">
    Member since: {{ $store->created_at->format('Y-m-d') }} |
    Expires: {{ $store->created_at->addYear()->format('Y-m-d') }}
  </p>

  {{-- KPI Cards --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white shadow p-6 rounded-lg text-center">
      <p class="text-sm">Products Live</p>
      <p class="text-2xl font-bold">{{ $products->count() }}</p>
    </div>
    <div class="bg-white shadow p-6 rounded-lg text-center">
      <p class="text-sm">Total Sales</p>
      <p class="text-2xl font-bold">$2,567</p>
    </div>
    <div class="bg-white shadow p-6 rounded-lg text-center">
      <p class="text-sm">Earnings</p>
      <p class="text-2xl font-bold">$13,202</p>
    </div>
    <div class="bg-white shadow p-6 rounded-lg text-center">
      <p class="text-sm">Membership</p>
      <p class="text-2xl font-bold {{ $store->created_at->addYear()->isPast() ? 'text-red-500' : 'text-green-600' }}">
        {{ $store->created_at->addYear()->isPast() ? 'Expired' : 'Active' }}
      </p>
    </div>
  </div>

  {{-- Product and Order sections can be added here --}}
@endsection
