<div id="chat-panel" class="fixed top-0 right-0 w-full max-w-md h-screen bg-white dark:bg-gray-900 shadow-lg z-50 transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden">
    {{-- Header --}}
    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Chat with Customer</h3>
        <button onclick="closeChatPanel()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
    </div>

    {{-- Messages --}}
    <div id="chat-messages" class="flex flex-col space-y-4 p-4 overflow-y-auto h-[75vh]">
        {{-- Messages will be loaded via AJAX --}}
    </div>

    {{-- Form --}}
    <form id="chat-form" enctype="multipart/form-data" class="p-4 border-t dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
        @csrf
        <div class="flex items-center gap-2">
            <input type="text" name="message" id="chat-message-input" placeholder="Write a message..."
                   class="flex-1 px-4 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />

            <label for="chat-image-upload" class="cursor-pointer">
                <input type="file" name="image" id="chat-image-upload" accept="image/*" class="hidden">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15.172 7l-6.586 6.586a2 2 0 01-2.828 0L2 10.828M10 12l6-6m2 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </label>

            <button type="submit" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700">Send</button>
        </div>
    </form>
</div>
@push('scripts')
<script>
    let currentOrderId = null;

    function openChatPanel(orderId) {
        currentOrderId = orderId;
        document.getElementById('chat-panel').classList.remove('translate-x-full');

        fetchMessages(orderId); // load messages

        setInterval(() => {
            if (currentOrderId) fetchMessages(currentOrderId);
        }, 3000);
    }

    function closeChatPanel() {
        document.getElementById('chat-panel').classList.add('translate-x-full');
        currentOrderId = null;
    }

    function fetchMessages(orderId) {
        fetch(`/store/orders/${orderId}/messages`)
            .then(res => res.json())
            .then(messages => {
                let html = '';
                messages.forEach(msg => {
                    const isStore = msg.sender === 'store';
                    html += `
                    <div class="flex ${isStore ? 'justify-end' : 'justify-start'}">
                        <div class="max-w-xs px-4 py-2 rounded-2xl shadow-md ${isStore ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'}">
                            ${msg.message ? `<p class="text-sm mb-1">${msg.message}</p>` : ''}
                            ${msg.image ? `<a href="/storage/${msg.image}" target="_blank"><img src="/storage/${msg.image}" class="w-32 h-auto rounded-lg border mt-1"></a>` : ''}
                            <small class="block text-[10px] text-gray-300 mt-1 text-right">${new Date(msg.created_at).toLocaleString()}</small>
                        </div>
                    </div>`;
                });

                const container = document.getElementById('chat-messages');
                container.innerHTML = html;
                container.scrollTop = container.scrollHeight;
            });
    }

    document.getElementById('chat-form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const data = new FormData(form);
        fetch(`/store/orders/${currentOrderId}/chat`, {
            method: 'POST',
            body: data,
        }).then(() => {
            form.reset();
            fetchMessages(currentOrderId);
        });
    });
</script>
@endpush
