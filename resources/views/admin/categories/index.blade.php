@extends('admin.layouts.base')

@section('title', 'Category Management')

@section('content')
<div class="mt-12 space-y-6">
  <div class="flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">📂 Categories</h2>
    <button onclick="toggleCategoryModal(true)" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">+ Add Category</button>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow mb-4">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300 uppercase text-xs">
        <tr>
          <th class="px-6 py-3">Image</th>
          <th class="px-6 py-3">Category Name</th>
          <th class="px-6 py-3">Created At</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 dark:text-gray-200">
        @forelse($categories as $category)
          <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
            <td class="px-6 py-4">
              @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" class="w-10 h-10 rounded object-cover">
              @else
                <span class="text-xs text-gray-400">No image</span>
              @endif
            </td>
            <td class="px-6 py-4 font-medium">{{ $category->name }}</td>
            <td class="px-6 py-4">{{ $category->created_at->format('Y-m-d') }}</td>
            <td class="px-6 py-4 space-x-2">
              <button onclick='openEditModal(@json($category))' class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">Edit</button>
              <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center px-6 py-4 text-gray-500">No categories found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $categories->links() }}
  </div>
</div>

<!-- Add Category Modal -->
<div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md shadow-lg p-6 relative">
    <button onclick="toggleCategoryModal(false)" class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 dark:hover:text-white">✖</button>
    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">➕ Add Category</h2>

    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label class="text-sm text-gray-700 dark:text-gray-300">Category Name</label>
        <input type="text" name="name" required class="w-full mt-1 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
      </div>
      <div class="mb-4">
        <label class="text-sm text-gray-700 dark:text-gray-300">Image</label>
        <input type="file" name="image" accept="image/*" class="w-full mt-1 text-sm text-gray-700 dark:text-gray-300">
      </div>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="toggleCategoryModal(false)" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md shadow-lg p-6 relative">
    <button onclick="toggleEditModal(false)" class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 dark:hover:text-white">✖</button>
    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">✏️ Edit Category</h2>
    <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      <input type="hidden" id="edit_category_id" name="id">
      <div class="mb-4">
        <label class="text-sm text-gray-700 dark:text-gray-300">Category Name</label>
        <input type="text" id="edit_category_name" name="name" required class="w-full mt-1 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
      </div>
      <div class="mb-4">
        <label class="text-sm text-gray-700 dark:text-gray-300">Image</label>
        <input type="file" name="image" accept="image/*" class="w-full mt-1 text-sm text-gray-700 dark:text-gray-300">
        <div id="currentCategoryImage" class="mt-2"></div>
      </div>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="toggleEditModal(false)" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleCategoryModal(show) {
  document.getElementById('categoryModal').classList.toggle('hidden', !show);
}

function toggleEditModal(show) {
  document.getElementById('editCategoryModal').classList.toggle('hidden', !show);
}

function openEditModal(category) {
  const form = document.getElementById('editCategoryForm');
  const nameInput = document.getElementById('edit_category_name');
  const imageContainer = document.getElementById('currentCategoryImage');

  form.action = `/admin/categories/${category.id}`;
  nameInput.value = category.name;

  if (category.image) {
    imageContainer.innerHTML = `<img src="/storage/${category.image}" class="w-16 h-16 rounded mt-2" alt="Current Image">`;
  } else {
    imageContainer.innerHTML = '<span class="text-xs text-gray-400">No current image</span>';
  }

  toggleEditModal(true);
}
</script>
@endpush
