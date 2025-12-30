<div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-xl max-w-4xl mx-auto">

    {{-- 🧭 Chat Header --}}
    <div class="flex items-center justify-between border-b pb-4 mb-5">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            🛍️ Chat with Customer — Order #{{ $order->id }}
        </h2>
    </div>

    {{-- 💬 Chat Messages --}}
    <div id="chat-messages"
         class="space-y-3 max-h-[450px] overflow-y-auto pr-2 scroll-smooth custom-scrollbar">
        @foreach ($messages as $msg)
            <div class="flex {{ $msg->sender === 'store' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] px-4 py-2 rounded-2xl shadow-sm
                            {{ $msg->sender === 'store' ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-200 text-gray-900 rounded-bl-none' }}">

                    @if ($msg->message)
                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                    @endif

                    @if ($msg->image)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $msg->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $msg->image) }}"
                                     class="w-40 rounded-md border border-gray-300 shadow-sm" />
                            </a>
                        </div>
                    @endif

                    <small class="block mt-1 text-[10px] text-right text-gray-300">
                        {{ $msg->created_at->format('d M, H:i') }}
                    </small>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 📤 Chat Input --}}
    <form action="{{ route('store.orders.chat.send', $order->id) }}"
          method="POST" enctype="multipart/form-data"
          class="mt-6 border-t pt-4">
        @csrf
        <div class="flex items-center gap-3">
            <input type="text" name="message"
                   placeholder="Type your message..."
                   class="flex-1 px-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-blue-500" />

            <label for="image" class="cursor-pointer hover:opacity-75 transition">
                <input type="file" name="image" id="image" accept="image/*" class="hidden">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none"
                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15.172 7l-6.586 6.586a2 2 0 01-2.828 0L2 10.828M10 12l6-6m2 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </label>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full text-sm font-medium transition">
                Send
            </button>
        </div>
    </form>
</div>

{{-- Optional scrollbar styling --}}
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(100, 116, 139, 0.4);
        border-radius: 4px;
    }
</style>
@push('scripts')
<script>
    const fetchUrl = "{{ route('store.orders.messages', $order->id) }}";

    function fetchMessages() {
        fetch(fetchUrl)
            .then(res => res.json())
            .then(messages => {
                let html = '';
                messages.forEach(msg => {
                    const isStore = msg.sender === 'store';
                    html += `
                        <div class="flex ${isStore ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[75%] px-4 py-2 rounded-2xl shadow-sm
                                ${isStore ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-200 text-gray-900 rounded-bl-none'}">
                                
                                ${msg.message ? `<p class="text-sm">${msg.message}</p>` : ''}
                                ${msg.image ? `<div class="mt-2"><a href="/storage/${msg.image}" target="_blank">
                                    <img src="/storage/${msg.image}" class="w-40 rounded-md border border-gray-300 shadow-sm" />
                                </a></div>` : ''}
                                <small class="block mt-1 text-[10px] text-right text-gray-300">
                                    ${new Date(msg.created_at).toLocaleString()}
                                </small>
                            </div>
                        </div>`;
                });

                const container = document.getElementById('chat-messages');
                container.innerHTML = html;
                container.scrollTop = container.scrollHeight;
            });
    }

    setInterval(fetchMessages, 3000);

    window.onload = () => {
        const container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    };
</script>
@endpush
