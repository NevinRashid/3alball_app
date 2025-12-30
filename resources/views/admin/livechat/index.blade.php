@extends('admin.layouts.base')

@section('title', 'Live Chat')

@section('content')
@if(isset($selectedUser))
<input type="hidden" id="sendMessageUrl" value="{{ route('admin.livechat.reply', $selectedUser->id) }}">
<input type="hidden" id="loadMessagesUrl" value="{{ route('admin.livechat.messages', $selectedUser->id) }}">
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Active Users List -->
  <div class="col-span-1 bg-white dark:bg-gray-900 rounded-xl shadow p-4">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">💬 Active Users</h2>
    <div id="usersList" class="space-y-4 overflow-y-auto max-h-[calc(100vh-200px)]">
      @foreach($users as $user)
      <a href="{{ route('admin.livechat.index', ['user' => $user->id]) }}" 
         class="block p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
        <div class="flex justify-between items-center">
          <div>
            <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }} | {{ $user->phone }}</div>
          </div>
          <div id="badge-{{ $user->id }}" class="hidden ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-1"></div>
        </div>
        <div class="text-xs text-gray-400 mt-1">Last active: {{ optional($user->liveChats->last())->created_at->diffForHumans() ?? 'N/A' }}</div>
      </a>
      @endforeach
    </div>
  </div>

  <!-- Chat Window -->
  <div class="col-span-2 bg-white dark:bg-gray-900 rounded-xl shadow p-4 flex flex-col">
    @if(isset($selectedUser))
      <div class="flex justify-between items-center border-b pb-4 mb-4">
        <div>
          <h2 class="text-xl font-bold text-gray-800 dark:text-white">Chat with {{ $selectedUser->name }}</h2>
          <div class="text-sm text-gray-500 dark:text-gray-400">{{ $selectedUser->email }} | {{ $selectedUser->phone }}</div>
        </div>
        @if(!$chatEnded)
          <form action="{{ route('admin.livechat.end', $selectedUser->id) }}" method="POST">
            @csrf
            <button class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">End Chat</button>
          </form>
        @else
          <span class="px-3 py-1 text-sm bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">Chat Ended</span>
        @endif
      </div>

      <!-- Chat Messages -->
      <div id="chat-window" class="flex-1 overflow-y-auto mb-4 space-y-3">
        @foreach($messages as $msg)
          <div class="flex {{ $msg->from_admin ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-md px-4 py-3 rounded-lg {{ $msg->from_admin ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white' }}">
              @if($msg->file)
                <a href="{{ asset('storage/' . $msg->file) }}" target="_blank" class="underline">📎 View Attachment</a><br>
              @endif
              {{ $msg->message }}
              <div class="text-xs text-right mt-1 text-gray-300 dark:text-gray-400">{{ $msg->created_at->format('H:i') }}</div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Reply Input -->
      @if(!$chatEnded)
      <form id="replyForm" enctype="multipart/form-data" class="flex gap-2 border-t pt-4">
        @csrf
        <input type="text" name="message" id="messageInput" placeholder="Type a message..." class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring text-sm" required>
        <input type="file" name="file" id="fileInput" class="text-sm">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Send</button>
      </form>
      @endif
    @else
      <div class="text-center text-gray-500 dark:text-gray-400 italic mt-20">👈 Select a user to start chatting</div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
@if(isset($selectedUser))
<script>
const sendMessageUrl = document.getElementById('sendMessageUrl').value;
const loadMessagesUrl = document.getElementById('loadMessagesUrl').value;

document.getElementById('replyForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const messageInput = document.getElementById('messageInput');
    const fileInput = document.getElementById('fileInput');

    const response = await fetch(sendMessageUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    });

    if (response.ok) {
        messageInput.value = '';
        fileInput.value = '';
        await loadMessages();
        scrollChatBottom();
    }
});

// 🧹 Dynamic load latest messages
async function loadMessages() {
    const res = await fetch(loadMessagesUrl);
    const messages = await res.json();

    let chatHtml = '';
    messages.forEach(msg => {
        chatHtml += `<div class="flex ${msg.from_admin ? 'justify-end' : 'justify-start'}">
          <div class="max-w-md px-4 py-3 rounded-lg ${msg.from_admin ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white'}">
            ${msg.file ? `<a href="/storage/${msg.file}" target="_blank" class="underline">📎 View Attachment</a><br>` : ''}
            ${msg.message}
            <div class="text-xs text-right mt-1 text-gray-300">${msg.created_at.substring(11,16)}</div>
          </div>
        </div>`;
    });

    document.getElementById('chat-window').innerHTML = chatHtml;
    scrollChatBottom();
}

// 🔥 Scroll smoothly
function scrollChatBottom() {
    const chatWindow = document.getElementById('chat-window');
    chatWindow.scrollTop = chatWindow.scrollHeight;
}

// 📢 Real-time listening
window.Echo.private(`chat.user.{{ $selectedUser->id }}`)
    .listen('NewChatMessage', (e) => {
        console.log('📨 New real-time message received!');
        loadMessages();
    });
</script>
@endif

<script>
// 🛡 Refresh users list every 2 sec
setInterval(() => {
    fetch('/admin/livechat/fetch')
    .then(res => res.json())
    .then(users => {
        users.forEach(user => {
            const badge = document.getElementById('badge-' + user.id);
            if (badge) {
                if (user.unread_messages_count > 0) {
                    badge.classList.remove('hidden');
                    badge.innerText = user.unread_messages_count;
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
    });
}, 1000);
</script>
@endpush



