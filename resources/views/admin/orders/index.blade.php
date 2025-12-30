@extends('admin.layouts.base')

@section('title', 'Order Management')

@section('content')
<div class="mt-12 space-y-6">
  <div class="flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">🍎 Orders</h2>
    <div class="flex gap-2">
      <a href="{{ route('admin.orders.export', ['type' => 'csv']) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Export CSV</a>
      <a href="{{ route('admin.orders.export', ['type' => 'pdf']) }}" class="px-3 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700">Export PDF</a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow mb-4">
      {{ session('success') }}
    </div>
  @endif

  <!-- Search Form -->
  <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6">
    <div class="flex items-center gap-2">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Search by order ID, customer, or store..."
             class="w-full px-4 py-2 border rounded-lg shadow-sm text-sm bg-white dark:bg-gray-800 dark:text-white">
      <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
        Search
      </button>
    </div>
  </form>

  <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300 uppercase text-xs">
        <tr>
          <th class="px-6 py-3">Order ID</th>
          <th class="px-6 py-3">Customer</th>
          <th class="px-6 py-3">Recipient</th>
          <th class="px-6 py-3">Store</th>
          <th class="px-6 py-3">Total</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Payment</th>
          <th class="px-6 py-3">Date</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 dark:text-gray-200">
        @forelse($orders as $order)
        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
          <td class="px-6 py-4 font-semibold">#{{ $order->id }}</td>
          <td class="px-6 py-4">{{ $order->user?->name ?? 'Guest' }}<br><small class="text-gray-500">{{ $order->user?->email ?? '-' }}</small></td>
          <td class="px-6 py-4">{{ $order->recipient_name ?? '-' }}<br><small class="text-gray-500">{{ $order->recipient_phone ?? '-' }}</small></td>
          <td class="px-6 py-4">{{ $order->store->store_name ?? '-' }}</td>
          <td class="px-6 py-4">${{ number_format($order->total_price, 2) }}</td>
          <td class="px-6 py-4">
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
              @csrf
              @method('PUT')
              <select name="status" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded border bg-gray-50 dark:bg-gray-700 dark:text-white">
              @foreach(['pending', 'approved', 'order_packed', 'on_the_way', 'delivered', 'rejected'] as $status)
    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
        {{ ucwords(str_replace('_', ' ', $status)) }}
    </option>
@endforeach

              </select>
            </form>
          </td>
          <td class="px-6 py-4">
            @if($order->payment_method === 'cliq' && $order->payment_proof)
              <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-blue-600 underline text-xs">View Receipt</a><br>
              <small>Status: {{ ucfirst($order->payment_status) }}</small>
              <div class="mt-2 flex gap-1">
                <form method="POST" action="{{ route('admin.orders.approve', $order->id) }}">
                  @csrf
                  <button type="submit" class="px-2 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.orders.reject', $order->id) }}">
                  @csrf
                  <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Reject</button>
                </form>
              </div>
            @else
              <small>{{ ucfirst($order->payment_method ?? '-') }}</small><br>
              <small>Status: {{ ucfirst($order->payment_status ?? '-') }}</small>
            @endif
          </td>
          <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d') }}</td>
          <td class="px-6 py-4 space-x-2">
            <button onclick="viewOrder(@json($order->id))" class="px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">View</button>
            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-6">
    {{ $orders->links() }}
  </div>
</div>

<!-- Order Detail Modal -->
<div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-2xl relative">
    <button onclick="toggleOrderModal(false)" class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 dark:hover:text-white">&times;</button>
    <div id="orderModalContent" class="space-y-4 text-sm text-gray-800 dark:text-gray-200"></div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function viewOrder(id) {
  const modal = document.getElementById('orderModal');
  const content = document.getElementById('orderModalContent');

  content.innerHTML = `
    <div class="flex items-center justify-center h-40">
      <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
      </svg>
    </div>`;
  toggleOrderModal(true);

  fetch(`/admin/orders/${id}`)
    .then(res => res.json())
    .then(order => {
      content.innerHTML = `
        <h2 class="text-lg font-bold">📋 Order #${order.id}</h2>

        <div><strong>Customer:</strong> ${order.user?.name ?? 'Guest'}<br>
        <small class="text-gray-500">${order.user?.email ?? '-'}</small></div>

        <div><strong>Recipient:</strong> ${order.recipient_name}<br>
        <small class="text-gray-500">${order.recipient_phone}</small></div>

        <div><strong>Address:</strong><br>${order.recipient_address}</div>

        <div><strong>Gift Message:</strong><br>
        <span class="block bg-gray-100 dark:bg-gray-700 p-2 rounded">${order.gift_message ?? '-'}</span></div>

        <div><strong>Delivery:</strong> ${order.delivery_date} at ${order.delivery_time}</div>

        <div><strong>Total:</strong> $${order.total_price} <br>
        <strong>Status:</strong> ${order.status}</div>

        <div><strong>Store:</strong> ${order.store?.store_name ?? '-'}</div>

        ${order.items?.length ? `
          <div><strong>Items:</strong><ul class="list-disc list-inside space-y-1 mt-2">
            ${order.items.map(item => `
              <li>${item.name} — $${item.price} x ${item.quantity}</li>
            `).join('')}
          </ul></div>` : ''}
      `;
    })
    .catch(err => {
      content.innerHTML = `<div class="text-red-600 p-4 text-center">🚫 Failed to load order data.</div>`;
    });
}

function toggleOrderModal(show) {
  const modal = document.getElementById('orderModal');
  if (show) {
    modal.classList.remove('hidden');
  } else {
    modal.classList.add('hidden');
  }
}
</script>
@endpush
