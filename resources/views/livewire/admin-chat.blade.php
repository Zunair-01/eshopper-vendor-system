<div class="chat-container">
    <!-- Left side: List of chat users -->
    <div id="chat-users" class="chat-users">
        <div class="search-box">
            <input type="text" placeholder="Search users..." wire:model="searchTerm">
        </div>
        <ul>
            @foreach($users as $user)
                <li wire:click="selectUser({{ $user->id }})" class="{{ $selectedUser == $user->id ? 'active' : '' }}">
                    <img src="https://via.placeholder.com/40" alt="User Avatar">
                    <div>
                        <span>{{ $user->name }}</span>
                        <p>{{ $user->email }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Right side: Chat window for selected user -->
    <div id="chat-window" class="chat-window">
        @if($selectedUser)
            <div class="chat-header">
                <!-- Show selected user's name in the chat header -->
                <img class="imgheader" src="https://via.placeholder.com/40" alt="User Profile Picture">
                <div>
                    <h2>{{ optional(App\Models\User::find($selectedUser))->name }}</h2> <!-- Show selected user's name -->
                    <span class="status online">Online</span>
                </div>
                <div class="options">
                    <i class="fas fa-ellipsis-v"></i> <!-- Font Awesome vertical dots icon -->
                </div>
            </div>

            <div id="chat-messages" class="chat-messages" wire:poll.3s="loadMessages">
                @if(empty($messages))
                    <p class="start-conversation">Start a conversation with <strong>{{ optional(App\Models\User::find($selectedUser))->name }}</strong></p>
                @else
                    @foreach($messages as $message)
                        <div class="message {{ $message['sender_id'] == auth()->id() ? 'sent' : 'received' }}">
                            <p>{{ $message['content'] }}</p>
                            <small>{{ \Carbon\Carbon::parse($message['created_at'])->format('g:i A') }}</small>
                        </div>
                    @endforeach
                @endif
            </div>


            <i class="fas fa-arrow-down scroll-to-start"></i>

            <!-- Message input -->
            <form wire:submit.prevent="sendMessage" id="message-form">
                <input id="message-input" name="message" type="text" wire:model="newMessage" placeholder="Type your message..." required>
                <button id="send-button" type="submit">Send</button>
            </form>
        @else
            <!-- Show this message when no user is selected -->
            <p class="messageStart">Select a user to start chatting.</p>
        @endif
    </div>
</div>
