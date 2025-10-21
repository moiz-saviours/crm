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

        $messages = Message::with(['sender', 'attachments'])
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

        // Validate text + attachments
        $request->validate([
            'content' => 'nullable|string|max:5000',
            'conversation_id' => 'required|exists:conversations,id',
            'message_type' => 'required|in:text,image,video,audio,file,system,attachment',
            'attachments.*' => 'nullable|file|max:51200|mimes:jpg,jpeg,png,gif,mp4,mp3,wav,ogg,pdf,doc,docx,zip,rar'
        ]);
        dd($request);
        // Ensure at least content or attachment is provided
        if (empty($request->content) && !$request->hasFile('attachments')) {
            return response()->json([
                'success' => false,
                'message' => 'Message content or attachment is required.'
            ], 422);
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
            'content' => $request->content,
            'message_type' => $request->message_type,
            'message_status' => 'sent',
        ]);

        // Handle file attachments (if any)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments', 'public');

                MessageAttachment::create([
                    'message_id' => $message->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Load relationships for frontend
        $message->load('attachments', 'sender');

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
            'receiver_id' => 'required|integer'
        ]);

        // Check if conversation already exists
        $existingConversation = Conversation::where([
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
            'receiver_type' => 'App\Models\CustomerContact',
            'receiver_id' => $request->receiver_id,
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
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
            'receiver_type' => 'App\Models\CustomerContact',
            'receiver_id' => $request->receiver_id,
            'conversation_status' => 'approved'
        ]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
            'message' => 'Conversation started successfully'
        ]);
    }
}