@extends('store.layouts.dashboard')

@section('title', 'Orders')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">📦 Orders</h2>
  </div>

  @forelse ($orders as $order)
  <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-5 mb-5 shadow-sm">
    <div class="flex justify-between items-start mb-2">
      <div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Order #{{ $order->id }}</div>
        <div class="text-lg font-semibold text-gray-800 dark:text-white">{{ $order->recipient_name }} — {{ $order->recipient_phone }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->recipient_address }}</div>
      </div>
      <div class="text-right">
        <form method="POST" action="{{ route('store.orders.status', $order->id) }}">
          @csrf
          <select name="status" onchange="this.form.submit()" class="px-2 py-1 text-sm rounded border bg-white dark:bg-gray-700 text-gray-800 dark:text-white">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="dispatched" {{ $order->status == 'order packed' ? 'selected' : '' }}>order packed</option>
            <option value="delivered" {{ $order->status == 'on the way' ? 'selected' : '' }}>on the way</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>delivered</option>
            <option value="delivered" {{ $order->status == 'rejected' ? 'selected' : '' }}>rejected</option>
          </select>
        </form>
        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full text-white 
          @if ($order->status === 'pending') bg-yellow-500
          @elseif ($order->status === 'approved') bg-green-500
          @elseif ($order->status === 'order packed') bg-blue-500
          @elseif ($order->status === 'delivered') bg-blue-500
          @elseif ($order->status === 'on the way') bg-indigo-600
          @elseif ($order->status === 'rejected') bg-indigo-600
          @else bg-gray-400 @endif">
          {{ ucfirst($order->status) }}
        </span>
      </div>
    </div>

    <button onclick="toggleDetails('{{ $order->id }}')" class="text-sm text-blue-600 hover:underline mt-2">
      View Details
    </button>

    <div id="order-details-{{ $order->id }}" class="mt-4 hidden">
      <div class="text-sm text-gray-600 dark:text-gray-300">
        <strong>Gift Message:</strong> {{ $order->gift_message ?? '—' }}<br>
        <strong>Delivery:</strong> {{ $order->delivery_date ?? '—' }} @ {{ $order->delivery_time ?? '—' }}
      </div>

      <div class="mt-4">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
            <tr>
              <th class="p-2">Product</th>
              <th class="p-2">Qty</th>
              <th class="p-2">Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->items as $item)
            <tr class="border-t border-gray-200 dark:border-gray-600">
              <td class="p-2">{{ $item['name'] ?? '—' }}</td>
              <td class="p-2">{{ $item['quantity'] ?? 1 }}</td>
              <td class="p-2 text-green-600 font-bold">${{ number_format($item['price'], 2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4 text-right text-lg font-bold text-green-600">
        Total: ${{ number_format($order->total_price, 2) }}
      </div>

      <div class="mt-3 text-right">
        <button onclick="openChatPanel('{{ $order->id }}')" class="text-sm text-blue-600 hover:underline">💬 Chat</button>
      </div>
    </div>
  </div>
  @empty
    <div class="text-center text-gray-500 dark:text-gray-400">No orders found.</div>
  @endforelse
</div>

@include('store.components.chat-panel')

<script>
  function toggleDetails(id) {
    const section = document.getElementById('order-details-' + id);
    if (section) {
      section.classList.toggle('hidden');
    }
  }
</script>
@endsection
