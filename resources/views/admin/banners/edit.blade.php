@extends('admin.layouts.base')

@section('title', 'Edit Banner')

@section('content')
<div class="max-w-3xl mx-auto mt-12 bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-md space-y-8">

  <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">✏️ Edit Banner</h2>

  @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded shadow">
      <ul class="list-disc pl-5 text-sm">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Banner Title</label>
      <input type="text" name="title" value="{{ old('title', $banner->title) }}"
             class="mt-1 w-full rounded-xl shadow-sm dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-700">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Current Image</label>
      <img src="{{ asset('storage/' . $banner->image) }}" class="mt-2 w-full max-h-60 object-cover rounded shadow" />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Replace Image</label>
      <input type="file" name="image" accept="image/*"
             class="mt-1 block w-full file:px-4 file:py-2 file:bg-indigo-50 dark:file:bg-gray-800 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:file:text-white">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Target Type</label>
        <select name="target_type"
                class="mt-1 w-full rounded-xl shadow-sm dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-700">
          @foreach(['product', 'store', 'category', 'url'] as $type)
            <option value="{{ $type }}" @selected($banner->target_type === $type)>
              {{ ucfirst($type) }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Target Value</label>
        <input type="text" name="target_value" value="{{ old('target_value', $banner->target_value) }}"
               class="mt-1 w-full rounded-xl shadow-sm dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-700">
      </div>
    </div>

    <div class="flex items-center">
      <input type="hidden" name="is_active" value="0">
      <input type="checkbox" name="is_active" value="1" @checked($banner->is_active)
             class="rounded text-indigo-600 dark:bg-gray-800 dark:border-gray-600">
      <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</label>
    </div>

    <div class="flex items-center">
      <input type="hidden" name="is_campaign" value="0"> <!-- ✅ Ensure always sent -->
      <input type="checkbox" name="is_campaign" id="is_campaign_checkbox" value="1"
             @checked($banner->is_campaign)
             class="rounded text-indigo-600 dark:bg-gray-800 dark:border-gray-600"
             onchange="toggleCampaignFields()">
      <label for="is_campaign_checkbox" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Show in Campaigns Page</label>
    </div>

    <div id="campaign-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 {{ $banner->is_campaign ? '' : 'hidden' }}">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Date</label>
        <input type="datetime-local" name="start_date"
               value="{{ old('start_date', $banner->start_date ? \Carbon\Carbon::parse($banner->start_date)->format('Y-m-d\TH:i') : '') }}"
               class="mt-1 w-full rounded-xl shadow-sm dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-700">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
        <input type="datetime-local" name="end_date"
               value="{{ old('end_date', $banner->end_date ? \Carbon\Carbon::parse($banner->end_date)->format('Y-m-d\TH:i') : '') }}"
               class="mt-1 w-full rounded-xl shadow-sm dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-700">
      </div>
    </div>

    <div class="pt-4">
      <button type="submit"
              class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 shadow">
        💾 Update Banner
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function toggleCampaignFields() {
  const isCampaign = document.getElementById('is_campaign_checkbox').checked;
  const campaignFields = document.getElementById('campaign-fields');
  if (isCampaign) {
    campaignFields.classList.remove('hidden');
  } else {
    campaignFields.classList.add('hidden');
  }
}

document.addEventListener('DOMContentLoaded', toggleCampaignFields);
</script>
@endpush
