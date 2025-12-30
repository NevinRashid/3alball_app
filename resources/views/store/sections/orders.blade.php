<!-- 🧾 Orders Section -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
  <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">📦 Orders</h2>

  @if ($orders->isEmpty())
    <div class="text-center text-red-500">❌ No orders in the database</div>
  @else
    <!-- Filters -->
    <div class="mb-4 flex flex-wrap gap-4">
      <select onchange="filterOrders()" id="statusFilter" class="px-4 py-2 border rounded text-sm">
        <option value="">All Statuses</option>
        <option value="order_placed">Order Placed</option>
        <option value="order_packed">Order Packed</option>
        <option value="on_the_way">On The Way</option>
        <option value="delivered">Delivered</option>
        <option value="rejected">Rejected</option>
      </select>
      <input type="date" id="dateFilter" onchange="filterOrders()" class="px-4 py-2 border rounded text-sm">
    </div>

    <!-- Order Cards -->
    @foreach ($orders as $order)
      <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-5 mb-5 shadow-sm">
        <div class="flex justify-between items-start mb-2">
          <div>
            <div class="text-sm text-gray-500 dark:text-gray-400">Order #{{ $order->id }}</div>
            <div class="text-lg font-semibold text-gray-800 dark:text-white">{{ $order->recipient_name }} — {{ $order->recipient_phone }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->recipient_address }}</div>
          </div>
          <div class="text-right">
            @if (in_array($order->status, ['order_placed', 'order_packed', 'on_the_way']))
              <form method="POST" action="{{ route('store.orders.status', $order->id) }}">
                @csrf
                <select name="status" onchange="this.form.submit()" class="px-2 py-1 text-sm rounded border bg-white dark:bg-gray-700 text-gray-800 dark:text-white">
                  @foreach(['order_placed', 'order_packed', 'on_the_way', 'delivered'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>
                      {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                  @endforeach
                </select>
              </form>
            @else
              <span class="text-xs text-gray-500 italic">Not editable</span>
            @endif

            @php
              $badgeColors = [
                'pending' => 'bg-yellow-500',
                'approved' => 'bg-green-500',
                'order_placed' => 'bg-blue-500',
                'order_packed' => 'bg-indigo-600',
                'on_the_way' => 'bg-purple-600',
                'delivered' => 'bg-green-700',
                'rejected' => 'bg-red-600',
              ];
            @endphp

            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full text-white {{ $badgeColors[$order->status] ?? 'bg-gray-400' }}">
              {{ ucwords(str_replace('_', ' ', $order->status)) }}
            </span>
          </div>
        </div>

        <button onclick="toggleDetails('{{ $order->id }}')" class="text-sm text-blue-600 hover:underline mt-2">View Details</button>

        <div id="order-details-{{ $order->id }}" class="mt-4 hidden">
          <!-- Extra Info -->
          <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
            <strong>Gift Message:</strong> {{ $order->gift_message ?? '—' }}<br>
            <strong>Delivery:</strong> {{ $order->delivery_date ?? '—' }} @ {{ $order->delivery_time ?? '—' }}
          </div>

          <!-- Items Table -->
          <div class="mt-2">
            <table class="min-w-full text-sm">
              <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <tr>
                  <th class="p-2">Product</th>
                  <th class="p-2">Qty</th>
                  <th class="p-2">Price</th>
                </tr>
              </thead>
              <tbody>
                @if (!empty($order->items) && is_iterable($order->items))
                  @foreach ($order->items as $item)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                      <td class="p-2 flex items-center gap-3">
                        @if (!empty($item['image']))
                          <img src="{{ asset('storage/' . $item['image']) }}" alt="Product" class="h-10 w-10 rounded object-cover border">
                        @endif
                        {{ $item['name'] ?? '—' }}
                      </td>
                      <td class="p-2">{{ $item['quantity'] ?? 1 }}</td>
                      <td class="p-2 text-green-600 font-bold">${{ number_format($item['price'], 2) }}</td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="3" class="text-center py-3 text-gray-500">No item details found.</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>

          <!-- Export Buttons -->
          <div class="mt-4 flex justify-end gap-2">
            <a href="{{ route('store.order.export.pdf', $order->id) }}"
              class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700">📄 Export PDF</a>

            <a href="{{ route('store.order.export.csv', $order->id) }}"
              class="bg-yellow-500 text-white text-sm px-4 py-2 rounded hover:bg-yellow-600">📊 Export CSV</a>

            <button onclick="window.print()" class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">🖨️ Print</button>
          </div>

          <!-- Total & Chat -->
          <div class="mt-4 text-right text-lg font-bold text-green-600">
            Total: ${{ number_format($order->total_price, 2) }}
          </div>
          <div class="mt-3 text-right">
            <a href="{{ route('store.orders.chat', $order->id) }}" class="inline-block text-sm text-blue-600 hover:underline">💬 Chat</a>
          </div>
        </div>
      </div>
    @endforeach
  @endif
</div>

<script>
  function toggleDetails(id) {
    const section = document.getElementById('order-details-' + id);
    if (section) section.classList.toggle('hidden');
  }

  function filterOrders() {
    const status = document.getElementById('statusFilter').value.toLowerCase();
    const date = document.getElementById('dateFilter').value;

    document.querySelectorAll('[id^="order-details-"]').forEach(section => {
      section.parentElement.style.display = '';
    });

    document.querySelectorAll('[id^="order-details-"]').forEach(section => {
      const orderBlock = section.parentElement;
      const statusSelect = orderBlock.querySelector('select[name="status"]');
      const orderDate = orderBlock.querySelector('form + span')?.closest('div')?.nextElementSibling?.textContent.trim();

      const matchStatus = !status || statusSelect?.value.toLowerCase() === status;
      const matchDate = !date || orderDate?.includes(date);

      orderBlock.style.display = (matchStatus && matchDate) ? '' : 'none';
    });
  }
</script>
