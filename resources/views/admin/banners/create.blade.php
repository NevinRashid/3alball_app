@extends('admin.layouts.base')

@section('title', 'Add New Banner')

@section('content')
<div class="max-w-3xl mx-auto mt-12 bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-md space-y-8">
  <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">📢 Create New Banner</h2>

  @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded shadow">
      <ul class="list-disc pl-5 text-sm">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Banner Title -->
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Banner Title</label>
      <input type="text" name="title" value="{{ old('title') }}"
             class="mt-1 w-full border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
    </div>

    <!-- Image Upload -->
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Banner Image <span class="text-red-500">*</span></label>
      <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
             class="mt-2 block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-800 dark:file:text-white">

      <div id="preview-container" class="mt-4 hidden">
        <p class="text-xs text-gray-400 mb-1">Image Preview:</p>
        <img id="image-preview" class="w-full max-h-60 rounded-lg shadow" />
      </div>
    </div>

    <!-- Target Settings -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Target Type</label>
        <select name="target_type"
                class="mt-1 w-full border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
          <option value="product" {{ old('target_type') === 'product' ? 'selected' : '' }}>Product</option>
          <option value="store" {{ old('target_type') === 'store' ? 'selected' : '' }}>Store</option>
          <option value="category" {{ old('target_type') === 'category' ? 'selected' : '' }}>Category</option>
          <option value="url" {{ old('target_type') === 'url' ? 'selected' : '' }}>External URL</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Target Value</label>
        <input type="text" name="target_value" value="{{ old('target_value') }}" placeholder="Product ID, Store ID, or URL"
               class="mt-1 w-full border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
      </div>
    </div>

    <!-- is_active -->
    <div class="flex items-center">
      <input type="checkbox" name="is_active" value="1"
             class="rounded text-indigo-600 dark:bg-gray-800 dark:border-gray-600"
             {{ old('is_active') ? 'checked' : '' }}>
      <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Activate this banner</label>
    </div>

    <!-- is_campaign -->
    <div class="flex items-center">
      <input type="checkbox" name="is_campaign" value="1" id="is_campaign_checkbox"
             class="rounded text-indigo-600 dark:bg-gray-800 dark:border-gray-600"
             onchange="toggleCampaignFields()" {{ old('is_campaign') ? 'checked' : '' }}>
      <label for="is_campaign_checkbox" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Show in Campaigns Page</label>
    </div>

    <!-- Campaign Dates -->
    <div id="campaign-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 {{ old('is_campaign') ? '' : 'hidden' }}">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Date</label>
        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
               class="mt-1 w-full border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
               class="mt-1 w-full border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
      </div>
    </div>

    <!-- Submit -->
    <div class="pt-4">
      <button type="submit"
              class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 shadow">
        🚀 Create Banner
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  function previewImage(event) {
    const previewContainer = document.getElementById('preview-container');
    const preview = document.getElementById('image-preview');

    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        previewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  }

  function toggleCampaignFields() {
    const isCampaign = document.getElementById('is_campaign_checkbox').checked;
    const campaignFields = document.getElementById('campaign-fields');
    if (isCampaign) {
      campaignFields.classList.remove('hidden');
    } else {
      campaignFields.classList.add('hidden');
    }
  }

  // ✅ Auto-show campaign fields on page load if checked
  document.addEventListener('DOMContentLoaded', () => {
    toggleCampaignFields();
  });
</script>
@endpush
