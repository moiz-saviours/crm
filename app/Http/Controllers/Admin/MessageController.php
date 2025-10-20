<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use Illuminate\Support\Facades\Storage;
use App\Events\NewMessageEvent;

class MessageController extends Controller
{
    public function getConversationMessages($conversationId)
    {
        // Check if conversation exists
        $conversation = Conversation::find($conversationId);
        
        if (!$conversation) {
            return response()->json([
                'html' => '<div class="text-center py-4 text-muted">Conversation not found</div>',
                'messages' => []
            ], 404);
        }

        $messages = Message::with(['senderable', 'attachments'])
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        $html = '';
        foreach ($messages as $message) {
            $html .= view('admin.customers.contacts.timeline.partials.card-box.messages', ['message' => $message])->render();
        }

        return response()->json([
            'html' => $html,
            'messages' => $messages
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'conversation_id' => 'required|exists:conversations,id',
            'message_type' => 'required|in:text,image,video,audio,file,system'
        ]);

        // Create message
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'senderable_type' => get_class(auth()->user()),
            'senderable_id' => auth()->id(),
            'content' => $request->content,
            'message_type' => $request->message_type,
            'message_status' => 'sent'
        ]);

        // Load relationships for response
        $message->load('attachments', 'senderable');

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    // Add this method to create new conversation
    public function storeConversation(Request $request)
    {
        //todo need to handle agent can only send meesage to assign customer
        $request->validate([
            'receiverable_type' => 'required|string',
            'receiverable_id' => 'required|integer'
        ]);

        // Check if conversation already exists
        $existingConversation = Conversation::where([
            'senderable_type' => get_class(auth()->user()),
            'senderable_id' => auth()->id(),
            'receiverable_type' => $request->receiverable_type,
            'receiverable_id' => $request->receiverable_id,
        ])->first();

        if ($existingConversation) {
            return response()->json([
                'success' => true,
                'conversation' => $existingConversation,
                'message' => 'Conversation already exists'
            ]);
        }

        // Create new conversation
        $conversation = Conversation::create([
            'senderable_type' => get_class(auth()->user()),
            'senderable_id' => auth()->id(),
            'receiverable_type' => $request->receiverable_type,
            'receiverable_id' => $request->receiverable_id,
            'conversation_status' => 'approved'
        ]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
            'message' => 'Conversation started successfully'
        ]);
    }
}