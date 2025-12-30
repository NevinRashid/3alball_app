@php
  $sub = request()->get('sub', 'index');
@endphp

@if ($sub === 'create')
  <!-- 🔧 Add New Store Form (Styled Like Modal) -->
  <div class="max-w-2xl mx-auto mt-12 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">➕ Add New Store</h2>
      <a href="{{ route('admin.dashboard', ['section' => 'stores']) }}"
         class="text-sm text-gray-500 dark:text-gray-300 hover:underline">
        ← Back to Store List
      </a>
    </div>

    <form method="POST" action="{{ route('admin.stores.store') }}">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Store Name</label>
          <input type="text" name="store_name" required class="mt-1 w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" name="email" required class="mt-1 w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
          <input type="text" name="phone" class="mt-1 w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
          <input type="password" name="password" required class="mt-1 w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
          <input type="text" name="address" class="mt-1 w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
        </div>
      </div>

      <div class="mt-6 flex justify-end gap-2">
        <a href="{{ route('admin.dashboard', ['section' => 'stores']) }}"
           class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Store</button>
      </div>
    </form>
  </div>
@else
  <!-- 🏪 Store Management Section -->
  <div class="mt-12">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">🏪 Store Management</h2>
      <a href="{{ route('admin.dashboard', ['section' => 'stores', 'sub' => 'create']) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded shadow transition">
        ➕ Add New Store
      </a>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300 uppercase text-xs">
          <tr>
            <th class="px-6 py-3">Store Name</th>
            <th class="px-6 py-3">Phone</th>
            <th class="px-6 py-3">City</th>
            <th class="px-6 py-3">Orders</th>
            <th class="px-6 py-3">Products</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-200">
          @forelse($stores as $store)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
              <td class="px-6 py-4 font-medium">{{ $store->store_name }}</td>
              <td class="px-6 py-4">{{ $store->phone ?? '-' }}</td>
              <td class="px-6 py-4">{{ $store->address ?? '-' }}</td>
              <td class="px-6 py-4">{{ $store->orders_count }}</td>
              <td class="px-6 py-4">{{ $store->products_count }}</td>
              <td class="px-6 py-4">
                @if($store->status === 'active')
                  <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-600 rounded-full">Active</span>
                @else
                  <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-600 rounded-full">Suspended</span>
                @endif
              </td>
              <td class="px-6 py-4 space-x-2">
                <a href="{{ route('admin.stores.show', $store->id) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">View</a>

                <form action="{{ route('admin.stores.toggle', $store->id) }}" method="POST" class="inline">
                  @csrf @method('PUT')
                  <button type="submit" class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">
                    {{ $store->status === 'active' ? 'Suspend' : 'Activate' }}
                  </button>
                </form>

                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center px-6 py-4 text-gray-500">No stores found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endif
