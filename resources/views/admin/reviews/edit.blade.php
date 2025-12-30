@extends('admin.layouts.base')

@section('title', 'Edit Review')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
  <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">✏️ Edit Review</h2>

  <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}">
    @csrf @method('PUT')
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300 text-sm mb-1">Comment</label>
      <textarea name="comment" class="w-full rounded p-2 border">{{ $review->comment }}</textarea>
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300 text-sm mb-1">Rating</label>
      <input type="number" name="rating" value="{{ $review->rating }}" min="1" max="5" class="w-full rounded p-2 border" />
    </div>
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
  </form>
</div>
@endsection
