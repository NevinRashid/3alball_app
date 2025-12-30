@extends('admin.layouts.base')

@section('title', 'Finance Panel')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
  <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">💸 Store Finance Overview</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
      <thead>
        <tr class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-300">
          <th class="px-4 py-3">Store</th>
          <th class="px-4 py-3">Total Sales</th>
          <th class="px-4 py-3 text-green-600">Paid</th>
          <th class="px-4 py-3 text-yellow-600">Remaining</th>
          <th class="px-4 py-3 text-red-600">Commission (10%)</th>
          <th class="px-4 py-3">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $item)
          <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
            <td class="px-4 py-3 font-medium">{{ $item['store']->store_name }}</td>
            <td class="px-4 py-3">{{ number_format($item['total_sales'], 2) }} </td>
            <td class="px-4 py-3 text-green-500">{{ number_format($item['paid_amount'], 2) }} </td>
            <td class="px-4 py-3 text-yellow-500">{{ number_format($item['remaining'], 2) }} </td>
            <td class="px-4 py-3 text-red-500">{{ number_format($item['commission'], 2) }} </td>
            <td class="px-4 py-3">
              @if ($item['remaining'] > 0)
                <form action="{{ route('admin.finance.pay', $item['store']->id) }}" method="POST">
                  @csrf
                  <input type="hidden" name="amount" value="{{ $item['remaining'] }}">
                  <input type="hidden" name="commission" value="{{ $item['commission'] }}">
                  <button class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs">
                    Pay Remaining
                  </button>
                </form>
              @else
                <span class="text-xs text-gray-400">Fully Paid</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
