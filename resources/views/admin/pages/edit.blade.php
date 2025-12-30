@extends('admin.layouts.base')

@section('title', 'Edit Page')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

  {{-- ✏️ Edit Form --}}
  <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6 space-y-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
      📝 Edit Page: {{ $page->title }}
    </h2>

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Title</label>
          <input type="text" name="title" id="titleInput"
            value="{{ old('title', $page->title) }}"
            class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Content</label>
          <textarea name="content" id="contentInput" rows="10"
            class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">{{ old('content', $page->content) }}</textarea>
        </div>
      </div>

      <div class="flex justify-end mt-4">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-semibold">
          💾 Save Changes
        </button>
      </div>
    </form>
  </div>

  {{-- 👁️ Live Preview --}}
  <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white flex items-center gap-2">
      👁️ Live Preview
    </h2>

    <div class="border border-gray-200 dark:border-gray-700 rounded p-6 bg-gray-50 dark:bg-gray-800 space-y-4 text-[15px] leading-relaxed max-h-[80vh] overflow-y-auto" id="previewPanel">
      <h1 id="previewTitle" class="text-xl font-bold text-indigo-700 dark:text-indigo-300"></h1>
      <div id="previewContent" class="text-gray-700 dark:text-gray-300 whitespace-pre-line"></div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  const titleInput = document.getElementById('titleInput');
  const contentInput = document.getElementById('contentInput');
  const previewTitle = document.getElementById('previewTitle');
  const previewContent = document.getElementById('previewContent');

  function updatePreview() {
    previewTitle.textContent = titleInput.value || 'Page Title';
    previewContent.textContent = contentInput.value || 'Start writing your content...';
  }

  titleInput.addEventListener('input', updatePreview);
  contentInput.addEventListener('input', updatePreview);

  // Initial load
  updatePreview();
</script>
@endpush
