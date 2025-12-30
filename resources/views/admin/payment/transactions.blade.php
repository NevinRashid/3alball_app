@extends('admin.layouts.base')

@section('title', 'Payment Transactions')

@section('content')
<div class="mt-12 space-y-6">
  <div class="flex items-center justify-between">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">💳 Payment Transactions</h2>
  </div>

  <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6 overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300 text-xs uppercase">
        <tr>
          <th class="px-4 py-3">Order ID</th>
          <th class="px-4 py-3">Customer</th>
          <th class="px-4 py-3">Store</th>
          <th class="px-4 py-3">Method</th>
          <th class="px-4 py-3">Total</th>
          <th class="px-4 py-3">Commission</th>
          <th class="px-4 py-3">Earnings</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Proof</th>
          <th class="px-4 py-3">Date</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 dark:text-gray-200">
        @forelse($payments as $payment)
        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
          <td class="px-4 py-3 font-semibold text-indigo-600">#{{ $payment->id }}</td>
          <td class="px-4 py-3">{{ $payment->user->name ?? 'Guest' }}</td>
          <td class="px-4 py-3">{{ $payment->store->store_name ?? '-' }}</td>
          <td class="px-4 py-3">{{ ucfirst($payment->payment_method) }}</td>
          <td class="px-4 py-3 font-medium text-green-600">${{ number_format($payment->total_price, 2) }}</td>
          <td class="px-4 py-3 text-red-500">-${{ number_format($payment->admin_commission, 2) }}</td>
          <td class="px-4 py-3 text-green-500">${{ number_format($payment->store_earnings, 2) }}</td>
          <td class="px-4 py-3">
            <span class="inline-block text-xs px-2 py-1 rounded-full font-semibold {{
              $payment->payment_status === 'approved' ? 'bg-green-100 text-green-700' :
              ($payment->payment_status === 'rejected' ? 'bg-red-100 text-red-600' :
              'bg-yellow-100 text-yellow-700')
            }}">
              {{ ucfirst($payment->payment_status) }}
            </span>
          </td>
          <td class="px-4 py-3">
            @if($payment->payment_proof)
              <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-blue-600 underline text-xs">View</a>
            @else
              <span class="text-gray-400 text-xs">N/A</span>
            @endif
          </td>
          <td class="px-4 py-3 text-xs">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="10" class="px-4 py-4 text-center text-gray-400">No payment transactions found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $payments->links() }}
  </div>
</div>
@endsection
