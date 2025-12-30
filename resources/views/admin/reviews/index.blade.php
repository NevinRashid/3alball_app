@extends('admin.layouts.base')

@section('title', 'Review Moderation')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📝 Reviews Management</h2>
    <span class="text-sm text-gray-400">{{ $reviews->total() }} total reviews</span>
  </div>

  <div class="grid gap-4">
    @forelse ($reviews as $review)
      <div class="p-5 border rounded-xl bg-gray-50 dark:bg-gray-800 hover:shadow-md transition duration-200">
        <div class="flex justify-between items-start">
          <div class="space-y-2">
            <div class="text-sm text-gray-600 dark:text-gray-300">
              <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $review->user->name }}</span> 
              reviewed 
              <span class="font-semibold text-blue-700 dark:text-blue-400">{{ $review->product->name }}</span>
            </div>
            <div class="text-gray-700 dark:text-gray-200 text-base">
              “{{ $review->comment }}”
            </div>
            <div class="flex items-center gap-2 text-yellow-500">
              @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $review->rating)
                  ★
                @else
                  <span class="text-gray-300 dark:text-gray-600">★</span>
                @endif
              @endfor
              <span class="text-xs text-gray-500 dark:text-gray-400">({{ $review->rating }}/5)</span>
            </div>
            <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
          </div>

          <div class="flex gap-2 mt-1">
            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition">Edit</a>
            <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}">
              @csrf @method('DELETE')
              <button class="px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 transition">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center text-gray-500 dark:text-gray-400">No reviews yet.</div>
    @endforelse
  </div>

  <div class="mt-6">
  {{ $reviews->links() }}
</div>

</div>
@endsection
