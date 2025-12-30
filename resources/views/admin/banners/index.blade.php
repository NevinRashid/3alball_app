@extends('admin.layouts.base')

@section('title', 'Banners')

@section('content')
<div class="mt-12 space-y-6">
  <div class="flex items-center justify-between">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📢 Banner Management</h2>
    <a href="{{ route('admin.banners.create') }}"
       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 shadow transition">
       ➕ Add New Banner
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded shadow-md text-sm font-semibold">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow-lg rounded-xl">
    <table class="min-w-full text-sm text-left">
      <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-xs">
        <tr>
          <th class="px-6 py-3">Image</th>
          <th class="px-6 py-3">Title</th>
          <th class="px-6 py-3">Target</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Campaign</th>
          <th class="px-6 py-3">Start</th>
          <th class="px-6 py-3">End</th>
          <th class="px-6 py-3">Created</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody id="banner-table" class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($banners as $banner)
        <tr data-id="{{ $banner->id }}"
            data-end="{{ $banner->end_date }}"
            data-status="{{ $banner->is_active }}"
            class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
          <td class="px-6 py-3">
            <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner" class="w-28 h-20 object-cover rounded-lg shadow">
          </td>
          <td class="px-6 py-3 font-semibold text-gray-800 dark:text-white">
            {{ $banner->title ?? '—' }}
          </td>
          <td class="px-6 py-3">
            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
              🧭 {{ ucfirst($banner->target_type) }}
            </span>
            <div class="text-xs text-gray-500 mt-1 truncate w-36">{{ $banner->target_value }}</div>
          </td>
          <td class="px-6 py-3 status-cell">
            @if($banner->is_active)
              <span class="status-badge inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">
                ✅ Active
              </span>
            @else
              <span class="status-badge inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">
                ❌ Inactive
              </span>
            @endif
          </td>
          <td class="px-6 py-3">
            @if($banner->is_campaign)
              <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">
                📣 Campaign
              </span>
            @else
              <span class="inline-block text-xs text-gray-400">—</span>
            @endif
          </td>
          <td class="px-6 py-3 text-xs text-gray-600 dark:text-gray-400">
            {{ $banner->start_date ? \Carbon\Carbon::parse($banner->start_date)->format('Y-m-d H:i') : '—' }}
          </td>
          <td class="px-6 py-3 text-xs text-gray-600 dark:text-gray-400">
            {{ $banner->end_date ? \Carbon\Carbon::parse($banner->end_date)->format('Y-m-d H:i') : '—' }}
          </td>
          <td class="px-6 py-3 text-xs text-gray-600 dark:text-gray-400">
            {{ $banner->created_at->format('Y-m-d') }}
          </td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="{{ route('admin.banners.edit', $banner->id) }}"
               class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
              ✏️ Edit
            </a>
            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Are you sure you want to delete this banner?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                🗑️ Delete
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="px-6 py-6 text-center text-gray-400 text-sm">No banners added yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $banners->links() }}
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // 🔄 Make table sortable
    const el = document.getElementById('banner-table');
    if (el) {
      new Sortable(el, {
        animation: 150,
        handle: 'td',
        onEnd: () => {
          const positions = [...el.children].map(row => row.dataset.id);
          fetch('{{ route('admin.banners.reorder') }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ positions })
          }).then(() => {
            console.log('✅ Banner order updated.');
          });
        }
      });
    }

    // ⏳ Real-time expiry checker
    const now = new Date();
    document.querySelectorAll('tr[data-end]').forEach(row => {
      const end = row.dataset.end;
      const status = row.dataset.status;
      const statusCell = row.querySelector('.status-cell');

      if (!end || status !== '1') return;

      const endDate = new Date(end);
      if (endDate < now) {
        statusCell.innerHTML = `
          <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-700 rounded">
            ⏳ Expired
          </span>
        `;
        row.classList.add('opacity-60');
      }
    });
  });
</script>
@endpush
