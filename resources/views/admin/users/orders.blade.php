<div class="space-y-8">
  <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white flex items-center gap-3">
    🧾 Orders for {{ $user->name }}
  </h2>

  @if ($orders->isEmpty())
    <div class="text-center py-20 text-gray-400 italic text-lg">
      🚫 This user has not placed any orders yet.
    </div>
  @else
    @foreach ($orders as $order)
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 space-y-6 border border-gray-100 dark:border-gray-700 transition hover:shadow-2xl">
        <div class="flex justify-between flex-wrap items-center gap-4">
          <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
              #{{ $order->id }} • {{ ucfirst($order->status) }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Placed on {{ $order->created_at->format('d M Y • H:i') }}
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-2">
            <span class="px-3 py-1 rounded-full text-sm font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white">
              💰 {{ number_format($order->total_price, 2) }} ₺
            </span>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
              @if($order->status === 'pending') bg-yellow-100 text-yellow-800
              @elseif($order->status === 'approved') bg-blue-100 text-blue-800
              @elseif($order->status === 'dispatched') bg-indigo-100 text-indigo-800
              @elseif($order->status === 'delivered') bg-green-100 text-green-800
              @else bg-gray-200 text-gray-700 @endif">
              {{ ucfirst($order->status) }}
            </span>
          </div>
        </div>

        <div class="text-sm leading-relaxed text-gray-600 dark:text-gray-300 space-y-1">
          <p><strong class="text-gray-800 dark:text-white">📍 Store:</strong> {{ $order->store->store_name ?? '-' }}</p>
          <p><strong class="text-gray-800 dark:text-white">👤 Recipient:</strong> {{ $order->recipient_name }} — {{ $order->recipient_phone }}</p>
          <p><strong class="text-gray-800 dark:text-white">📦 Address:</strong> {{ $order->recipient_address }}</p>

          @if($order->gift_message)
            <p><strong class="text-gray-800 dark:text-white">💌 Gift Message:</strong></p>
            <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-md italic">{{ $order->gift_message }}</div>
          @endif
        </div>

        @if($order->items && count($order->items))
          <div class="pt-4 border-t border-dashed border-gray-200 dark:border-gray-600">
            <h4 class="text-base font-semibold text-gray-800 dark:text-white mb-3">🛍️ Ordered Products</h4>
            <ul class="space-y-3">
              @foreach ($order->items as $item)
                <li class="flex items-center gap-4">
                  <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded-lg shadow">
                  <div>
                    <div class="text-base font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Qty: {{ $item['quantity'] }} — {{ number_format($item['price'], 2) }} ₺</div>
                  </div>
                </li>
                
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    @endforeach
  @endif
</div>
