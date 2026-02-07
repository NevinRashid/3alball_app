@if ($orders->isEmpty())
  <p class="text-gray-600">No messages yet.</p>
@else
  <div class="space-y-4">
    @foreach ($orders as $order)
      <div class="message-card p-4 bg-white dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600/30 shadow rounded-xl flex justify-between items-center">
  <div class="text-gray-800 dark:text-gray-100">
    <div class="font-semibold">Order #{{ $order->id }}</div>
    <div class="text-sm text-gray-500 dark:text-gray-300">{{ $order->recipient_name }} — {{ $order->recipient_phone }}</div>
  </div>

  <div class="flex items-center gap-2">
    <span id="new-count-{{ $order->id }}" class="text-xs bg-red-500 text-white rounded-full px-2 hidden"></span>
    <a href="javascript:void(0)" onclick="openChatPanel('{{ $order->id }}')" class="text-blue-600 dark:text-blue-400 hover:underline">Open Chat</a>
  </div>
</div>
    @endforeach
  </div>
@endif

{{-- Hidden audio element for notifications --}}
<audio id="notif-sound" src="https://notificationsounds.com/storage/sounds/file-sounds-1153-pristine.mp3" preload="auto"></audio>

@include('store.components.chat-panel')

@push('scripts')
<script>
    let currentOrderId = null;
    let chatInterval;
    let messageCounts = {};
    let refreshInterval;
    let toastShown = {};

    function openChatPanel(orderId) {
        currentOrderId = orderId;
        document.getElementById('chat-panel').classList.remove('translate-x-full');
        fetchMessages(orderId);
        if (chatInterval) clearInterval(chatInterval);
        chatInterval = setInterval(() => {
            if (currentOrderId) fetchMessages(currentOrderId);
        }, 3000);
        const badge = document.getElementById(`new-count-${orderId}`);
        if (badge) badge.classList.add('hidden');
    }

    function closeChatPanel() {
        document.getElementById('chat-panel').classList.add('translate-x-full');
        currentOrderId = null;
        clearInterval(chatInterval);
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
                        <div class="chat-bubble max-w-xs md:max-w-sm lg:max-w-md px-4 py-2 rounded-2xl shadow-md relative ${isStore ? 'chat-store bg-blue-600 text-white rounded-br-none' : 'chat-other bg-gray-200 text-gray-800 rounded-bl-none'}">
                            ${msg.message ? `<p class="text-sm mb-1">${msg.message}</p>` : ''}
                            ${msg.image ? `<a href="/storage/${msg.image}" target="_blank"><img src="/storage/${msg.image}" class="w-32 h-auto rounded-lg border mt-1"></a>` : ''}
                            <small class="absolute bottom-1 right-2 text-[10px] text-gray-300">${new Date(msg.created_at).toLocaleString()}</small>
                        </div>
                    </div>`;
                });

                const container = document.getElementById('chat-messages');
                container.innerHTML = html;
                container.scrollTop = container.scrollHeight;
            });
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.className = "fixed bottom-4 right-4 bg-black text-white px-4 py-2 rounded shadow z-50 text-sm animate-fadeIn";
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function refreshMessageCounts() {
    ordersList.forEach(orderId => {
        fetch(`/store/orders/${orderId}/messages`)
            .then(res => res.json())
            .then(messages => {
                const lastCount = messageCounts[orderId] || 0;
                const newCount = messages.length;

                if (newCount > lastCount && currentOrderId != orderId) {
                    const badge = document.getElementById(`new-count-${orderId}`);
                    if (badge) {
                        badge.innerText = `${newCount - lastCount} new`;
                        badge.classList.remove('hidden');
                    }

                    if (!toastShown[orderId]) {
                        showToast(`New message in Order #${orderId}`);
                        document.getElementById('notif-sound').play();
                        toastShown[orderId] = true;
                    }
                }

                messageCounts[orderId] = newCount;
            });
            
    });
    
}

       
    

    setInterval(refreshMessageCounts, 10000); // auto refresh every 10 seconds

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
