@extends('admin.layouts.base')

@section('title', 'Coupon Codes')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">🎟️ All Coupons</h2>
    <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">+ New Coupon</a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
      <thead>
        <tr class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-300">
          <th class="px-4 py-3">Code</th>
          <th class="px-4 py-3">Type</th>
          <th class="px-4 py-3">Discount</th>
          <th class="px-4 py-3">Min Order</th>
          <th class="px-4 py-3">Expires</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($coupons as $coupon)
        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
          <td class="px-4 py-3 font-medium">{{ $coupon->code }}</td>
          <td class="px-4 py-3 capitalize">{{ $coupon->type }}</td>
          <td class="px-4 py-3">{{ $coupon->type === 'percent' ? $coupon->discount.'%' : $coupon->discount.'$' }}</td>
          <td class="px-4 py-3">{{ $coupon->min_order_amount ?? '—' }}</td>
          <td class="px-4 py-3">{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d M Y') : '—' }}</td>
          <td class="px-4 py-3">
            <span class="px-2 py-1 text-xs font-semibold rounded {{ $coupon->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
              {{ $coupon->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td class="px-4 py-3">
            <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" onsubmit="return confirm('Are you sure?')">
              @csrf @method('DELETE')
              <button class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-gray-500 py-4">No coupons available.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $coupons->links() }}
  </div>
</div>
@endsection
