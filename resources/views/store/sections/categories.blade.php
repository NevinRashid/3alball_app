<div class="p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">🗂 Categories</h2>
  </div>

  {{-- ✅ Success Message --}}
  @if (session('success'))
    <div class="mb-4 text-green-600 dark:text-green-400">
      {{ session('success') }}
    </div>
  @endif

  {{-- ✅ Category Table --}}
  <div class="overflow-x-auto mb-6">
    <table class="min-w-full text-sm text-left text-gray-800 dark:text-white">
      <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
        <tr>
          <th class="p-3">#</th>
          <th class="p-3">Name</th>
          <th class="p-3">Created</th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
        @foreach ($categories as $category)
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="p-3">{{ $category->id }}</td>
            <td class="p-3">{{ $category->name }}</td>
            <td class="p-3">{{ $category->created_at->format('Y-m-d') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    @if ($categories->isEmpty())
      <p class="text-sm text-gray-500 mt-4">No categories available. Categories are managed by the system admin.</p>
    @endif
  </div>

  {{-- 🚫 Add New Category Section Hidden from Stores --}}
  @if (auth()->user() && auth()->user()->is_admin)
    <div class="border-t pt-4 mt-4">
      <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">+ Add Category</h3>

      <form method="POST" action="{{ route('store.categories.store') }}" class="flex flex-col md:flex-row gap-4">
        @csrf
        <input type="text" name="name" class="flex-1 px-4 py-2 border rounded dark:bg-gray-900 dark:text-white"
               placeholder="Category name..." required>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
          Add
        </button>
      </form>
    </div>
  @endif
</div>