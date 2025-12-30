@extends('admin.layouts.base')

@section('title', 'Create Coupon')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow max-w-2xl mx-auto">
  <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">➕ New Coupon</h2>

  <form method="POST" action="{{ route('admin.coupons.store') }}">
    @csrf

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Coupon Code</label>
      <input name="code" type="text" class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-700" required />
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Discount Type</label>
      <select name="type" class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-700">
        <option value="percent">Percentage (%)</option>
        <option value="fixed">Fixed Amount </option>
      </select>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Discount Value</label>
      <input name="discount" type="number" step="0.01" class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-700" required />
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Minimum Order Amount (Optional)</label>
      <input name="min_order_amount" type="number" step="0.01" class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-700" />
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Expiry Date (Optional)</label>
      <input name="expires_at" type="datetime-local" class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-700" />
    </div>

    <div class="mb-4">
      <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 dark:bg-gray-800" />
        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
      </label>
    </div>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Coupon</button>
  </form>
</div>
@endsection
