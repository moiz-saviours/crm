<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MessageController;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\MessageAttachment;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer-contact', function () {
        return response()->json([
            "id" => 1,
            "name" => "Smith John",
            "email" => "smith.john@customer-portal.com",
            "phone" => "1234567890",
            "ip_address" => null,
            "status" => 1,
            "deleted_at" => null,
            "updated_at" => "2025-02-06T17:42:05.000000Z",
            "created_at" => "2025-02-04T18:50:32.000000Z"
        ]);
    });
    Route::get('/projects', function (Request $request) {
        // Static dummy data
        $projectsWithChat = [
            [
                'id' => 1001,
                'name' => 'Website Redesign',
                'type' => 'creative',
                'value' => 'premium',
                'status' => 'is_progress',
                'progress' => 75,
                'deadline' => '2025-12-15',
                'conversation_id' => 1,
            ],
            [
                'id' => 1002,
                'name' => 'Mobile App UI',
                'type' => 'ui',
                'value' => 'standard',
                'status' => 'finished',
                'progress' => 100,
                'deadline' => '2025-08-20',
                'conversation_id' => 2,
            ],
            [
                'id' => 1003,
                'name' => 'Marketing Campaign',
                'type' => 'digital',
                'value' => 'regular',
                'status' => 'on_hold',
                'progress' => 20,
                'deadline' => '2026-01-10',
                'conversation_id' => null,
            ],
            [
                'id' => 1004,
                'name' => 'E-commerce Platform',
                'type' => 'development',
                'value' => 'premium',
                'status' => 'is_progress',
                'progress' => 60,
                'deadline' => '2025-11-30',
                'conversation_id' => 3,
            ],
            [
                'id' => 1005,
                'name' => 'Brand Identity',
                'type' => 'creative',
                'value' => 'standard',
                'status' => 'finished',
                'progress' => 100,
                'deadline' => '2025-07-15',
                'conversation_id' => 4,
            ]
        ];
        // Get query parameters with defaults
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'asc');
        $status = $request->get('status');
        $type = $request->get('type');
        $value = $request->get('value');
        // Filter data
        $filteredData = $projectsWithChat;
        // Filter by status
        if ($status) {
            $filteredData = array_filter($filteredData, function ($project) use ($status) {
                return $project['status'] === $status;
            });
        }
        // Filter by type
        if ($type) {
            $filteredData = array_filter($filteredData, function ($project) use ($type) {
                return $project['type'] === $type;
            });
        }
        // Filter by value
        if ($value) {
            $filteredData = array_filter($filteredData, function ($project) use ($value) {
                return $project['value'] === $value;
            });
        }
        // Reset array keys after filtering
        $filteredData = array_values($filteredData);
        // Sort data
        usort($filteredData, function ($a, $b) use ($sort, $order) {
            $aValue = $a[$sort] ?? null;
            $bValue = $b[$sort] ?? null;
            // Handle different data types for sorting
            if (is_numeric($aValue) && is_numeric($bValue)) {
                $comparison = $aValue - $bValue;
            } else {
                $comparison = strcmp($aValue ?? '', $bValue ?? '');
            }
            return $order === 'desc' ? -$comparison : $comparison;
        });
        // Apply pagination (limit and offset)
        $totalItems = count($filteredData);
        $paginatedData = array_slice($filteredData, $offset, $limit);
        // Prepare response
        $response = [
            'success' => true,
            'data' => $paginatedData,
            'pagination' => [
                'total' => $totalItems,
                'count' => count($paginatedData),
                'limit' => (int)$limit,
                'offset' => (int)$offset,
                'has_more' => ($offset + $limit) < $totalItems,
                'total_pages' => ceil($totalItems / $limit),
                'current_page' => floor($offset / $limit) + 1
            ],
            'sort' => [
                'by' => $sort,
                'order' => $order
            ],
            'filters' => [
                'status' => $status,
                'type' => $type,
                'value' => $value
            ]
        ];
        return response()->json($response);
    })->middleware('auth:sanctum,customer', 'abilities:project:read');
    Route::get('/projects/{id}', function (Request $request, $id) {
        $projectsWithChat = [
            [
                'id' => 1001,
                'name' => 'Website Redesign',
                'type' => 'creative',
                'value' => 'premium',
                'status' => 'is_progress',
                'progress' => 75,
                'deadline' => '2025-12-15',
                'conversation_id' => 1,
            ],
            [
                'id' => 1002,
                'name' => 'Mobile App UI',
                'type' => 'ui',
                'value' => 'standard',
                'status' => 'finished',
                'progress' => 100,
                'deadline' => '2025-08-20',
                'conversation_id' => 2,
            ],
            [
                'id' => 1003,
                'name' => 'Marketing Campaign',
                'type' => 'digital',
                'value' => 'regular',
                'status' => 'on_hold',
                'progress' => 20,
                'deadline' => '2026-01-10',
                'conversation_id' => null,
            ],
            [
                'id' => 1004,
                'name' => 'E-commerce Platform',
                'type' => 'development',
                'value' => 'premium',
                'status' => 'is_progress',
                'progress' => 60,
                'deadline' => '2025-11-30',
                'conversation_id' => 3,
            ],
            [
                'id' => 1005,
                'name' => 'Brand Identity',
                'type' => 'creative',
                'value' => 'standard',
                'status' => 'finished',
                'progress' => 100,
                'deadline' => '2025-07-15',
                'conversation_id' => 4,
            ]
        ];
        // Find the project by ID
        $project = null;
        foreach ($projectsWithChat as $proj) {
            if ($proj['id'] == $id) {
                $project = $proj;
                break;
            }
        }
        // If project not found, return error
        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }
        // Return the single project with same response structure
        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    })->middleware('auth:sanctum,customer', 'abilities:project:read');
    Route::get('/conversations/{conversationId}/messages', function (Request $request, $conversationId) {
        $messages = [
            [
                'id' => 1,
                'conversation_id' => 1,
                'sender_type' => 'user',
                'sender_id' => 1,
                'content' => 'Hello, how is the website redesign coming along?',
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => '2024-01-15 10:30:00',
                'updated_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 2,
                'conversation_id' => 1,
                'sender_type' => 'admin',
                'sender_id' => 2,
                'content' => 'Great! We\'ve completed 75% of the work so far.',
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => '2024-01-15 11:15:00',
                'updated_at' => '2024-01-15 11:15:00'
            ],
            [
                'id' => 3,
                'conversation_id' => 1,
                'sender_type' => 'user',
                'sender_id' => 1,
                'content' => 'design-mockup.png',
                'message_type' => 'image',
                'message_status' => 'delivered',
                'created_at' => '2024-01-15 14:20:00',
                'updated_at' => '2024-01-15 14:20:00'
            ],
            [
                'id' => 4,
                'conversation_id' => 2,
                'sender_type' => 'user',
                'sender_id' => 3,
                'content' => 'When will the mobile app UI be ready?',
                'message_type' => 'text',
                'message_status' => 'sent',
                'created_at' => '2024-01-16 09:45:00',
                'updated_at' => '2024-01-16 09:45:00'
            ],
            [
                'id' => 5,
                'conversation_id' => 3,
                'sender_type' => 'admin',
                'sender_id' => 2,
                'content' => 'The e-commerce platform development is on track.',
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => '2024-01-16 16:25:00',
                'updated_at' => '2024-01-16 16:30:00'
            ]
        ];
        for ($i = 6; $i <= 20; $i++) {
            $messages[] = [
                'id' => $i,
                'conversation_id' => 3,
                'sender_type' => $i % 2 == 0 ? 'admin' : 'user',
                'sender_id' => $i % 2 == 0 ? 2 : 1,
                'content' => "Sample text message number $i for conversation 3.",
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => date('Y-m-d H:i:s', strtotime("2024-01-11 +$i hours")),
                'updated_at' => date('Y-m-d H:i:s', strtotime("2024-01-11 +$i hours"))
            ];
        }
        $limit = $request->get('limit', 50);
        $offset = $request->get('offset', 0);
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $message_type = $request->get('message_type');
        $message_status = $request->get('message_status');
        $sender_type = $request->get('sender_type');
        $filteredData = array_filter($messages, function ($message) use ($conversationId) {
            return $message['conversation_id'] == $conversationId;
        });
        if ($message_type) {
            $filteredData = array_filter($filteredData, function ($message) use ($message_type) {
                return $message['message_type'] === $message_type;
            });
        }
        if ($message_status) {
            $filteredData = array_filter($filteredData, function ($message) use ($message_status) {
                return $message['message_status'] === $message_status;
            });
        }
        if ($sender_type) {
            $filteredData = array_filter($filteredData, function ($message) use ($sender_type) {
                return $message['sender_type'] === $sender_type;
            });
        }
        $filteredData = array_values($filteredData);
        usort($filteredData, function ($a, $b) use ($sort, $order) {
            $aValue = $a[$sort] ?? null;
            $bValue = $b[$sort] ?? null;
            if (is_numeric($aValue) && is_numeric($bValue)) {
                $comparison = $aValue - $bValue;
            } elseif (is_string($aValue) && is_string($bValue)) {
                $comparison = strcmp($aValue, $bValue);
            } else {
                $comparison = strcmp($aValue ?? '', $bValue ?? '');
            }
            return $order === 'desc' ? -$comparison : $comparison;
        });
        $totalItems = count($filteredData);
        $paginatedData = array_slice($filteredData, $offset, $limit);
        // Prepare response
        $response = [
            'success' => true,
            'data' => $paginatedData,
            'pagination' => [
                'total' => $totalItems,
                'count' => count($paginatedData),
                'limit' => (int)$limit,
                'offset' => (int)$offset,
                'has_more' => ($offset + $limit) < $totalItems,
                'total_pages' => ceil($totalItems / $limit),
                'current_page' => floor($offset / $limit) + 1
            ],
            'sort' => [
                'by' => $sort,
                'order' => $order
            ],
            'filters' => [
                'conversation_id' => (int)$conversationId,
                'message_type' => $message_type,
                'message_status' => $message_status,
                'sender_type' => $sender_type
            ]
        ];
        return response()->json($response);
    })->middleware('auth:sanctum,customer', 'abilities:message:read');
    Route::get('/messages/{id}', function (Request $request, $id) {
        $messages = [
            [
                'id' => 1,
                'conversation_id' => 1,
                'sender_type' => 'user',
                'sender_id' => 1,
                'content' => 'Hello, how is the website redesign coming along?',
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => '2024-01-15 10:30:00',
                'updated_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 2,
                'conversation_id' => 1,
                'sender_type' => 'admin',
                'sender_id' => 2,
                'content' => 'Great! We\'ve completed 75% of the work so far.',
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => '2024-01-15 11:15:00',
                'updated_at' => '2024-01-15 11:15:00'
            ],
            [
                'id' => 3,
                'conversation_id' => 1,
                'sender_type' => 'user',
                'sender_id' => 1,
                'content' => 'design-mockup.png',
                'message_type' => 'image',
                'message_status' => 'delivered',
                'created_at' => '2024-01-15 14:20:00',
                'updated_at' => '2024-01-15 14:20:00'
            ],
            [
                'id' => 4,
                'conversation_id' => 2,
                'sender_type' => 'user',
                'sender_id' => 3,
                'content' => 'When will the mobile app UI be ready?',
                'message_type' => 'text',
                'message_status' => 'sent',
                'created_at' => '2024-01-16 09:45:00',
                'updated_at' => '2024-01-16 09:45:00'
            ],
            [
                'id' => 5,
                'conversation_id' => 3,
                'sender_type' => 'admin',
                'sender_id' => 2,
                'content' => 'The e-commerce platform development is on track.',
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => '2024-01-16 16:25:00',
                'updated_at' => '2024-01-16 16:30:00'
            ],
        ];
        for ($i = 3; $i <= 20; $i++) {
            $messages[] = [
                'id' => $i,
                'conversation_id' => 1,
                'sender_type' => $i % 2 == 0 ? 'admin' : 'user',
                'sender_id' => $i % 2 == 0 ? 2 : 1,
                'content' => "Sample text message number $i for conversation 1.",
                'message_type' => 'text',
                'message_status' => 'seen',
                'created_at' => date('Y-m-d H:i:s', strtotime("2024-01-11 +$i hours")),
                'updated_at' => date('Y-m-d H:i:s', strtotime("2024-01-11 +$i hours"))
            ];
        }
        $message = null;
        foreach ($messages as $msg) {
            if ($msg['id'] == $id) {
                $message = $msg;
                break;
            }
        }
        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    })->middleware('auth:sanctum,customer', 'abilities:message:read');
    Route::post('/message', function (Request $request) {

        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string|max:5000',
            'conversation_id' => 'required|exists:conversations,id',
            'message_type' => 'required|in:text,image,video,audio,file,system,attachment',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'nullable|file|max:3072|mimes:jpg,jpeg,png,gif,mp4,mp3,wav,ogg,pdf,doc,docx,zip,rar',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        if (empty($request->get('content')) && !$request->hasFile('attachments')) {
            return response()->json([
                'success' => false,
                'message' => 'Message content or attachment is required.',
            ], 422);
        }
        $message = Message::create([
            'conversation_id' => (int)$request->conversation_id,
            'sender_type' => 'App\Models\CustomerContact',
            'sender_id' => auth()->user()->id,
            'content' => $request->get('content'),
            'message_type' => $request->message_type,
            'message_status' => 'delivered',
        ]);
        $attachmentsData = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments', 'public');
                $attachment = MessageAttachment::create([
                    'message_id' => $message->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
                $attachmentsData[] = [
                    'id' => $attachment->id,
                    'file_name' => $attachment->file_name,
                    'file_url' => asset('storage/' . $attachment->file_path),
                    'file_type' => $attachment->file_type,
                    'file_size' => $attachment->file_size,
                ];
            }
        }
        $messageData = [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'sender_type' => 'customer',
            'sender_id' => $message->sender_id,
            'content' => $message->content,
            'message_type' => $message->message_type,
            'message_status' => $message->message_status,
            'created_at' => $message->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $message->updated_at->format('Y-m-d H:i:s'),
            'attachments' => $attachmentsData,
        ];
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $messageData,
        ], 201);
    })->middleware('auth:sanctum,customer', 'abilities:message:read');
});
