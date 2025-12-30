<div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 mb-10">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-white">
      📈 {{ __('dashboard.sales_chart') }}
    </div>
    <div class="text-sm text-gray-500 dark:text-gray-400">
      <select id="rangeFilter" class="border rounded-md px-2 py-1 text-sm dark:bg-gray-700 dark:text-white">
        <option selected>Last 30 Days</option>
        <option>Last 7 Days</option>
        <option>This Month</option>
        <option>All Time</option>
      </select>
    </div>
  </div>
  <div class="relative h-72">
    <canvas id="salesChart"></canvas>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');
    fetch("{{ route('store.sales.data') }}")
      .then(res => res.json())
      .then(data => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

        const chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.map(item => item.date),
            datasets: [{
              label: '💰 Total Sales',
              data: data.map(item => item.total),
              borderColor: '#3B82F6',
              backgroundColor: gradient,
              tension: 0.5,
              fill: true,
              borderWidth: 3,
              pointRadius: 4,
              pointHoverRadius: 6,
              pointBackgroundColor: '#3B82F6',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              tooltip: {
                backgroundColor: '#1f2937',
                titleColor: '#fff',
                bodyColor: '#fff',
                cornerRadius: 6,
                padding: 12,
                callbacks: {
                  label: ctx => ` $${ctx.parsed.y.toLocaleString()}`
                }
              },
              legend: {
                display: false
              },
              title: {
                display: false
              }
            },
            scales: {
              x: {
                ticks: {
                  color: '#6b7280',
                  font: { size: 12, family: 'Inter' }
                },
                grid: { display: false }
              },
              y: {
                beginAtZero: true,
                ticks: {
                  callback: val => `$${val}`,
                  color: '#6b7280',
                  font: { size: 12, family: 'Inter' }
                },
                grid: { color: 'rgba(203, 213, 225, 0.2)' }
              }
            },
            animation: {
              tension: {
                duration: 1000,
                easing: 'easeOutQuart',
                from: 0.3,
                to: 0.5,
                loop: false
              }
            }
          }
        });
      });
  });
</script>
