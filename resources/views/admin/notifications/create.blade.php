@extends('admin.layouts.base')

@section('title', 'Send Notification')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">📢 Send New Notification</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.send') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Title</label>
            <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Body</label>
            <textarea name="body" rows="4" class="w-full p-2 border rounded" required></textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            🚀 Send Notification
        </button>
    </form>
</div>
@endsection
