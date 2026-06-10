@include('client.layout.partials.chatbotcss')

<button id="chatToggle" class="btn btn-info rounded-circle">
   <i class="bx bxs-message-dots"></i>
</button>

<div id="chatWidget">
    <div class="chat-header">
        <span><i class="bx bx-bot"></i> Trợ lý tư vấn</span>
        <div class="chat-actions d-flex gap-2">
            <button onclick="clearHistory()" title="Xóa lịch sử">🗑</button>
            <button onclick="toggleChat()" title="Đóng">✕</button>
        </div>
    </div>

    <div id="chatbox"></div>

    <div class="chat-input-area">
        <input type="text" id="chatInput" class="form-control form-control-sm" placeholder="Nhập tin nhắn...">
        <button onclick="sendMessage()" class="btn btn-info btn-send">Gửi</button>
    </div>
</div>

<script>
    const STORAGE_KEY = 'chatHistory';

    // Load lịch sử khi trang load
    document.addEventListener('DOMContentLoaded', function() {
        loadHistory();
    });

    function loadHistory() {
        const history = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        history.forEach(item => appendMessage(item.role, item.message));
    }

    function saveHistory(role, message) {
        const history = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        history.push({
            role,
            message
        });
        localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
    }

    function clearHistory() {
        if (confirm('Bạn có muốn xóa lịch sử chat?')) {
            localStorage.removeItem(STORAGE_KEY);
            document.getElementById('chatbox').innerHTML = '';
        }
    }

    function appendMessage(role, message) {
        const chatbox = document.getElementById('chatbox');
        const wrapper = document.createElement('div');
        wrapper.className = role === 'user' ? 'chat-row chat-user' : 'chat-row chat-bot';

        const label = document.createElement('div');
        label.className = 'chat-label';
        label.textContent = role === 'user' ? 'Bạn' : 'Bot';

        const messageBubble = document.createElement('div');
        messageBubble.className = 'chat-message';
        messageBubble.textContent = message.replace(/\n/g, '\n');

        wrapper.appendChild(label);
        wrapper.appendChild(messageBubble);
        chatbox.appendChild(wrapper);
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    function toggleChat() {
        const widget = document.getElementById('chatWidget');
        widget.style.display = widget.style.display === 'none' ? 'block' : 'none';
    }

    document.getElementById('chatToggle').addEventListener('click', toggleChat);

    document.getElementById('chatInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendMessage();
    });

    async function sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        if (!message) return;

        appendMessage('user', message);
        saveHistory('user', message);
        input.value = '';

        const chatbox = document.getElementById('chatbox');
        chatbox.innerHTML += `<div id="typing" class="mb-2"><i>Bot đang trả lời...</i></div>`;
        chatbox.scrollTop = chatbox.scrollHeight;

        const res = await fetch('{{ route("chatbot.ask") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message
            })
        });

        const data = await res.json();
        document.getElementById('typing')?.remove();
        appendMessage('bot', data.reply);
        saveHistory('bot', data.reply);
    }
</script>
