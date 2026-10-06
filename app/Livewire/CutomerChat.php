<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CutomerChat extends Component
{
    public $messageInput = '';
    public $messages = [];
    public $modalOpen = false; // Track whether the modal is open or closed

    // Initialize the component and load messages
    public function mount()
    {
        $this->loadMessages();
    }

    // Load all messages between the logged-in customer and the admin
    public function loadMessages()
    {
        $adminId = 1; // Assuming admin's ID is 1

        // Fetch messages between the current user and the admin
        $this->messages = Message::where(function ($query) use ($adminId) {
            $query->where('sender_id', Auth::id())
                  ->where('recipient_id', $adminId);
        })
        ->orWhere(function ($query) use ($adminId) {
            $query->where('sender_id', $adminId)
                  ->where('recipient_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get()
        ->toArray(); // Convert collection to array
    }

    // Send a message to the admin
    public function sendMessage()
    {
        $adminId = 1; // Assuming admin's ID is 1

        // Validate the input
        $this->validate([
            'messageInput' => 'required|string|max:255',
        ]);

        // Create the message in the database
        Message::create([
            'sender_id' => Auth::id(), // Customer ID
            'recipient_id' => $adminId,
            'content' => $this->messageInput,
        ]);

        // Clear the input field and reload the messages
        $this->messageInput = '';
        $this->loadMessages();
    }

    // Toggle modal visibility
    public function toggleModal()
    {
        $this->modalOpen = !$this->modalOpen;
    }


    // Render the Livewire view
    public function render()
    {
        return view('livewire.cutomer-chat');
    }
}
