@extends('admin.layouts.base')

@section('title', 'User Management')

@section('content')
<div class="mt-12 space-y-6">
  <h2 class="text-xl font-bold text-gray-800 dark:text-white">👥 Users</h2>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow">{{ session('success') }}</div>
  @endif

  <!-- Search Form -->
  <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
    <div class="flex items-center gap-2">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
             class="w-full px-4 py-2 border rounded-lg shadow-sm text-sm bg-white dark:bg-gray-800 dark:text-white">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">Search</button>
    </div>
  </form>

  <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-xs">
        <tr>
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Email</th>
          <th class="px-4 py-3">Phone</th>
          <th class="px-4 py-3">Role</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 dark:text-gray-200">
        @foreach($users as $user)
        <tr class="border-b border-gray-200 dark:border-gray-700">
          <td class="px-4 py-3">{{ $user->name }}</td>
          <td class="px-4 py-3">{{ $user->email }}</td>
          <td class="px-4 py-3">{{ $user->phone ?? '-' }}</td>
          <td class="px-4 py-3">
            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
              @csrf @method('PUT')
              <select name="role" onchange="this.form.submit()" class="bg-transparent dark:bg-gray-800 border rounded p-1 text-xs">
                @foreach(['admin', 'shop_owner', 'support', 'customer'] as $role)
                  <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
              </select>
            </form>
          </td>
          <td class="px-4 py-3">
            @if($user->is_active)
              <span class="bg-green-100 text-green-700 px-2 py-1 text-xs rounded">Active</span>
            @else
              <span class="bg-red-100 text-red-700 px-2 py-1 text-xs rounded">Suspended</span>
            @endif
          </td>
          <td class="px-4 py-3 space-x-2">
          <button onclick="viewUserOrders({{ $user->id }})" class="inline-block px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
             View Orders</button>

            <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="inline">
              @csrf @method('PUT')
              <button type="submit"
                      class="inline-block px-2 py-1 text-xs rounded transition
                      {{ $user->is_active ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                {{ $user->is_active ? 'Suspend' : 'Activate' }}
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $users->appends(request()->query())->links() }}
  </div>
</div>

<!-- Modal -->
<div id="orderModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
    <button onclick="toggleOrderModal(false)" class="absolute top-2 right-4 text-xl text-gray-600 hover:text-gray-800">&times;</button>
    <div id="orderModalContent" class="space-y-6 text-sm text-gray-800 dark:text-gray-200">
      <!-- Order Modal Content will be dynamically injected -->
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function viewUserOrders(userId) {
  const content = document.getElementById('orderModalContent');
  content.innerHTML = '<div class="text-center text-sm py-10 text-gray-500">Loading...</div>';

  fetch(`/admin/users/${userId}/orders`)
    .then(res => res.text())
    .then(html => {
      content.innerHTML = html;
      content.scrollTop = 0;
      toggleOrderModal(true);
    })
    .catch(err => {
      content.innerHTML = '<div class="text-center text-red-500">Failed to load orders.</div>';
    });
}

function toggleOrderModal(show) {
  document.getElementById('orderModal').classList.toggle('hidden', !show);
}
</script>
@endpush
