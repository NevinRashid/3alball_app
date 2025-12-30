<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Sales</h3>
        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
  ${{ number_format($totalSales, 2) }}
</p>

    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Orders</h3>
        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalOrders }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Registered Stores</h3>
        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $storeCount }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Active Users</h3>
        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $userCount }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Pending Products</h3>
        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $pendingProducts }}</p>
    </div>
</div>
