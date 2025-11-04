<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use Illuminate\Support\Facades\Storage;
use App\Events\NewMessageEvent;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerContact;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
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

        $messages = Message::with(['sender:id,name', 'attachments'])
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get(['id','sender_id','sender_type','content','message_type','created_at']);

        $html = '';
        foreach ($messages as $message) {
            $html .= view('admin.customers.contacts.timeline.partials.chat.partials.messages', ['message' => $message])->render();
        }

        return response()->json([
            'html' => $html,
            'messages' => $messages
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string|max:5000',
            'conversation_id' => 'required|exists:conversations,id',
            'message_type' => 'required|in:text,image,video,audio,file,system,attachment',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'nullable|file|max:3072|mimes:jpg,jpeg,png,gif,mp4,mp3,wav,ogg,pdf,doc,docx,zip,rar', // ✅ each <= 3MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Ensure at least content or attachment is provided
        if (empty($request->get('content')) && !$request->hasFile('attachments')) {
            return response()->json([
                'success' => false,
                'message' => 'Message content or attachment is required.'
            ], 422);
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->user()->id,
            'content' => $request->get('content'),
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
        $message->load('attachments', 'sender:id,name');

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }


    // Add this method to create new conversation
    public function storeConversation(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'receiver_id' => 'required|integer|exists:customer_contacts,id'
            ]);

            $receiverId = $validated['receiver_id'];
            $currentUser = auth()->user();

            // Check if conversation already exists
            $existingConversation = Conversation::where([
                'sender_type' => get_class($currentUser),
                'sender_id' => $currentUser->id,
                'receiver_type' => 'App\Models\CustomerContact',
                'receiver_id' => $receiverId,
            ])->orWhere([
                'sender_type' => 'App\Models\CustomerContact',
                'sender_id' => $receiverId,
                'receiver_type' => get_class($currentUser),
                'receiver_id' => $currentUser->id,
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
                'sender_type' => get_class($currentUser),
                'sender_id' => $currentUser->id,
                'receiver_type' => 'App\Models\CustomerContact',
                'receiver_id' => $receiverId,
                'conversation_status' => 'approved',
                'context_type' => 'App\Models\CustomerContact', // Add this
                'context_id' => $receiverId, // Add this - same as receiver_id for one-to-one
            ]);

            return response()->json([
                'success' => true,
                'conversation' => $conversation,
                'message' => 'Conversation started successfully'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (QueryException $e) {
            Log::error('Database error creating conversation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while creating conversation'
            ], 500);

        } catch (Exception $e) {
            Log::error('Unexpected error creating conversation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred'
            ], 500);
        }
    }

    // ADD THIS METHOD to your CustomerContactController:
    public function getConversations(CustomerContact $customer_contact)
    {
        $conversations = Conversation::with(['sender:id,name', 'receiver:id,name', 'lastMessage:content,conversation_id'])
            ->where(function($query) use ($customer_contact) {
                $query->where('sender_type', get_class(auth()->user()))
                    ->where('sender_id', auth()->user()->id)
                    ->where('receiver_type', get_class($customer_contact))
                    ->where('receiver_id', $customer_contact->id);
            })
            ->orWhere(function($query) use ($customer_contact) {
                $query->where('sender_type', get_class($customer_contact))
                    ->where('sender_id', $customer_contact->id)
                    ->where('receiver_type', get_class(auth()->user()))
                    ->where('receiver_id', auth()->user()->id);
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'conversations' => $conversations
        ]);
    }

public function getContextConversations(Request $request)
{
    $customerContactId = $request->customer_contact_id;
    
    $conversations = Conversation::with(['sender:id,name', 'receiver:id,name', 'lastMessage:content,conversation_id'])
        ->where(function($query) use ($customerContactId) {
            $query->where('sender_type', CustomerContact::class)
                  ->where('sender_id', $customerContactId);
        })
        ->orWhere(function($query) use ($customerContactId) {
            $query->where('receiver_type', CustomerContact::class)
                  ->where('receiver_id', $customerContactId);
        })
        ->whereNotNull('context_type')
        ->orderBy('updated_at', 'desc')
        ->get(['id','sender_type','sender_id','receiver_type','receiver_id','context_type','context_id','updated_at']);

    return response()->json([
        'conversations' => $conversations
    ]);
}
}