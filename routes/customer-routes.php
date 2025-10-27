<?php

//customer view for chatting
use App\Models\Conversation;
use App\Models\Message;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Customer chat route - using customer special_key
Route::get('/customer/chat/{customer_contact:special_key}', function (CustomerContact $customer_contact) {
    // Find ALL conversations for this customer (including context-based)
    $conversations = Conversation::with(['sender', 'receiver', 'lastMessage', 'context'])
        ->where(function($query) use ($customer_contact) {
            $query->where('sender_type', 'App\Models\CustomerContact')
                  ->where('sender_id', $customer_contact->id);
        })
        ->orWhere(function($query) use ($customer_contact) {
            $query->where('receiver_type', 'App\Models\CustomerContact')
                  ->where('receiver_id', $customer_contact->id);
        })
        ->orderBy('updated_at', 'desc')
        ->get();

    // Get the main conversation (general one or first one)
    $mainConversation = $conversations->firstWhere('context_type', CustomerContact::class) 
                     ?? $conversations->first();

    if (!$mainConversation) {
        return view('customer-chat', [
            'conversation' => null,
            'customer' => $customer_contact,
            'conversations' => [],
            'error' => 'No conversation found'
        ]);
    }

    return view('customer-chat', [
        'conversation' => $mainConversation,
        'customer' => $customer_contact,
        'conversations' => $conversations,
        'error' => null
    ]);
})->name('customer.chat');

// Handle customer messages
Route::post('/customer/chat/{customer_contact:special_key}/message', function (Request $request, CustomerContact $customer_contact) {
    $request->validate([
        'content' => 'required|string|max:5000',
        'message_type' => 'sometimes|in:text,image,video,audio,file,system',
        'conversation_id' => 'required|exists:conversations,id'
    ]);

    // Verify the conversation belongs to this customer
    $conversation = Conversation::where('id', $request->conversation_id)
        ->where(function($query) use ($customer_contact) {
            $query->where('sender_type', 'App\Models\CustomerContact')
                  ->where('sender_id', $customer_contact->id)
                  ->orWhere('receiver_type', 'App\Models\CustomerContact')
                  ->where('receiver_id', $customer_contact->id);
        })->first();

    if (!$conversation) {
        return response()->json(['error' => 'Conversation not found or access denied'], 404);
    }

    // Create message from customer
    $message = Message::create([
        'conversation_id' => $conversation->id,
        'sender_type' => 'App\Models\CustomerContact',
        'sender_id' => $customer_contact->id,
        'content' => $request->content,
        'message_type' => $request->message_type ?? 'text',
        'message_status' => 'sent'
    ]);

    // Update conversation last message
    $conversation->update([
        'last_message_id' => $message->id,
        'updated_at' => now()
    ]);

    return response()->json([
        'success' => true,
        'message' => $message->load('sender', 'attachments')
    ]);
});

// Get messages for specific conversation
Route::get('/customer/chat/{customer_contact:special_key}/conversations/{conversation}/messages', function (CustomerContact $customer_contact, Conversation $conversation) {
    // Verify conversation belongs to customer
    if (!($conversation->sender_type === 'App\Models\CustomerContact' && $conversation->sender_id === $customer_contact->id) &&
        !($conversation->receiver_type === 'App\Models\CustomerContact' && $conversation->receiver_id === $customer_contact->id)) {
        return response()->json(['error' => 'Access denied'], 403);
    }

    $messages = Message::with(['sender', 'attachments'])
        ->where('conversation_id', $conversation->id)
        ->orderBy('created_at', 'asc')
        ->get();

    // Format response with useful attachment info
    $messages->transform(function ($message) {
        $message->attachments->transform(function ($attachment) {
            return [
                'id' => $attachment->id,
                'original_name' => $attachment->file_name,
                'file_url' => asset('storage/' . $attachment->file_path),
                'file_type' => $attachment->file_type,
                'file_size' => $attachment->file_size,
            ];
        });
        return $message;
    });

    return response()->json($messages);
});

// Get all conversations for customer
Route::get('/customer/chat/{customer_contact:special_key}/conversations', function (CustomerContact $customer_contact) {
    $conversations = Conversation::with(['sender', 'receiver', 'lastMessage', 'context'])
        ->where(function($query) use ($customer_contact) {
            $query->where('sender_type', 'App\Models\CustomerContact')
                  ->where('sender_id', $customer_contact->id);
        })
        ->orWhere(function($query) use ($customer_contact) {
            $query->where('receiver_type', 'App\Models\CustomerContact')
                  ->where('receiver_id', $customer_contact->id);
        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return response()->json([
        'conversations' => $conversations
    ]);
});
