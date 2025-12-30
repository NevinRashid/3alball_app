@extends('admin.layouts.base')

@section('title', 'Pages')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
  <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
    📄 Manage Static Pages
  </h2>

  @if($pages->isEmpty())
    <div class="text-center text-gray-400 py-16 text-lg italic">
      🚫 No pages found.
    </div>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200 border rounded-lg overflow-hidden">
        <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-300">
          <tr>
            <th class="px-6 py-3">Title</th>
            <th class="px-6 py-3">Slug</th>
            <th class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pages as $page)
            <tr class="border-b dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
              <td class="px-6 py-4 font-medium">{{ $page->title }}</td>
              <td class="px-6 py-4 text-gray-500">{{ $page->slug }}</td>
              <td class="px-6 py-4 text-right">
                <a href="{{ route('admin.pages.edit', $page->id) }}"
                   class="text-indigo-600 hover:underline text-xs font-semibold">
                  ✏️ Edit
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
