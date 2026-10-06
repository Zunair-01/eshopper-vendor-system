<div>
    <!-- Chat Icon for toggling the modal -->
    <div class="chat-icon" wire:click="toggleModal">
        <i class="fas fa-comments"></i>
    </div>

    <!-- Chat Modal -->
    @if ($modalOpen) <!-- Only render the modal if its open -->
        <div class="chat-modal open" id="chatModal">
            <div class="chat-header">
                <h3>Customer Support</h3>
                <button class="close-btn" wire:click="toggleModal">×</button>
            </div>

            <!-- Chat Body: Display Messages -->
            <div class="chat-body" id="chatBody" wire:poll.3s="loadMessages">
                <!-- Add wire:poll to check for new messages every 3 seconds -->
                @foreach ($messages as $message)
                    <div class="message {{ $message['sender_id'] == Auth::id() ? 'sent' : 'received' }}">
                        <p>{{ $message['content'] }}</p>
                        <small>{{ \Carbon\Carbon::parse($message['created_at'])->format('g:i A') }}</small>
                        <!-- Time below the message -->
                    </div>
                @endforeach
            </div>

            <!-- Chat Input for Sending Message -->
            <div class="chat-input">
                <input type="text" id="messageInput" wire:model="messageInput" placeholder="Type your message...">
                <button id="sendBtn" wire:click="sendMessage"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    @endif
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                var chatBody = document.getElementById('chatBody');
                chatBody.scrollTop = chatBody.scrollHeight;
            });
        });

        function toggleChatModal() {
            const chatModal = document.getElementById('chatModal');
            chatModal.classList.toggle('open');
        }
    </script>
</div>
