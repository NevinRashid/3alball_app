@extends('admin.layouts.base')

@section('title', ucfirst($section ?? 'Dashboard'))

@section('content')
<div class="space-y-6">
  @php $section = request()->get('section', 'overview'); $sub = request()->get('sub', 'index'); @endphp

  @if ($section === 'overview')
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Welcome to Super Admin Dashboard</h1>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Here's what's happening with your platform today.</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <a href="{{ route('admin.dashboard', ['section' => 'stores', 'sub' => 'create']) }}" class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition">
        <div>
          <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Add New Store</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400">Create a new vendor/store</p>
        </div>
        <span class="text-2xl">➕</span>
      </a>

      <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition">
        <div>
          <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">View Product</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400">manage all the orders product</p>
        </div>
        <span class="text-2xl">📦</span>
      </a>

      <a href="{{ route('admin.dashboard', ['section' => 'orders']) }}" class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition">
        <div>
          <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">View Orders</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400">Manage recent orders</p>
        </div>
        <span class="text-2xl">🛒</span>
      </a>
    </div>

    @include('admin.components.kpis')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white flex items-center gap-2">
          <span class="text-lg">📈</span> Sales
        </h2>
        <canvas id="salesChart"></canvas>
      </div>
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white flex items-center gap-2">
          <span class="text-lg">🏢</span> New Stores
        </h2>
        <canvas id="storesChart"></canvas>
      </div>
    </div>

  @elseif ($section === 'stores')
    @include('admin.sections.stores')
  @elseif ($section === 'products')
    @include('admin.products.index')
  @elseif ($section === 'orders')
    @include('admin.orders.index')
    @elseif ($section === 'categories')
    @include('admin.categories.index')
    @elseif($section === 'finance')
    @include('admin.finance.index')
    @elseif ($section === 'banners')
  @include('admin.banners.index')
  @elseif ($section === 'users')
  @include('admin.users.index')
  @elseif ($section === 'pages')
  @include('admin.pages.index')
  @elseif ($section === 'payment')
  @include('admin.payment.index')
 @elseif($section === 'payment')
    @include('admin.payment.transactions') 
@elseif($section === 'payment-settings')
    @include('admin.payment.index') 
    @elseif($section === 'reviews')
    @include('admin.reviews.index')
    @elseif ($section === 'coupons')
  @include('admin.coupons.index')
  @elseif ($section === 'chats')
  @include('admin.livechat.index')
  @elseif ($section === 'notifications')
  @include('admin.notifications.create')

  @elseif ($section === 'settings')
  @include('admin.settings.index')


  @else
    <p class="text-sm text-gray-500">Section not found.</p>
  @endif
</div>
@endsection

@push('scripts')


@if ($section === 'overview')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const salesCtx = document.getElementById('salesChart').getContext('2d');
  new Chart(salesCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($weeklyLabels) !!},
      datasets: [{
        label: 'Sales',
        data: {!! json_encode($weeklySales) !!},
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 7,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return '$' + value.toFixed(2);
            },
            color: '#6B7280' // gray-500
          }
        },
        x: {
          ticks: {
            color: '#6B7280'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          labels: {
            color: '#374151', 
            font: {
              weight: 'bold'
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `Sales: $${context.parsed.y.toFixed(2)}`;
            }
          }
        }
      }
    }
  });

  const storesCtx = document.getElementById('storesChart').getContext('2d');
  new Chart(storesCtx, {
    type: 'bar',
    data: {
      labels: @json($monthlyStoreLabels),
      datasets: [{
        label: 'New Stores',
        data: @json($monthlyStoreCounts),
        backgroundColor: '#34D399', // emerald-400
        borderRadius: 5,
        barPercentage: 0.5,
        categoryPercentage: 0.6
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: '#6B7280'
          }
        },
        x: {
          ticks: {
            color: '#6B7280'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          labels: {
            color: '#374151',
            font: {
              weight: 'bold'
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `Stores: ${context.parsed.y}`;
            }
          }
        }
      }
    }
  });
</script>

@endif
@endpush

