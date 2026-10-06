<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;

class AdminChat extends Component
{
    public $newMessage = ''; // Input field for new message
    public $messages = []; // Stores the messages between the admin and selected user
    public $selectedUser = null; // ID of the selected user

    public function selectUser($userId)
    {
        // Set the selected user
        $this->selectedUser = $userId;

        // Load messages after selecting the user
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->selectedUser) {
            // Fetch messages between the admin and the selected user
            $this->messages = Message::where(function ($query) {
                $query->where('sender_id', auth()->id())
                      ->where('recipient_id', $this->selectedUser);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedUser)
                      ->where('recipient_id', auth()->id());
            })->orderBy('created_at')->get()->toArray(); // Convert to array
        }
    }


    public function sendMessage()
    {
        // Validate the new message field
        $this->validate([
            'newMessage' => 'required|string|max:255',
        ]);

        // Create a new message in the database
        Message::create([
            'sender_id' => auth()->id(),       // Admin ID
            'recipient_id' => $this->selectedUser, // Customer ID
            'content' => $this->newMessage,
        ]);

        // Clear the input field
        $this->newMessage = '';

        // Reload the messages after sending
        $this->loadMessages();
    }

    public function render()
    {

        $users = User::where('role', 'customer')->get();

        return view('livewire.admin-chat', [
            'users' => $users,
        ]);
    }
}
