<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\UserPseudoRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class EmailController extends Controller
{
  public function fetch(Request $request)
{
    try {
        $customerEmail = $request->query('customer_email');
        $folder = $request->query('folder', 'inbox');
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 5);
        $offset = ($page - 1) * $limit;

        // Log the request parameters for debugging
        Log::info('Fetching emails from database', [
            'customer_email' => $customerEmail,
            'folder' => $folder,
            'page' => $page,
            'limit' => $limit,
        ]);

        if (!$customerEmail) {
            return response()->json(['error' => 'Customer email is required'], 400);
        }

        // Find accounts associated with the customer email
        $accountIds = UserPseudoRecord::where('pseudo_email', $customerEmail)
            ->orWhere('pseudo_email', 'like', "%{$customerEmail}%")
            ->pluck('id')
            ->toArray();

        // Fetch emails from the database
        $query = Email::whereIn('pseudo_record_id', $accountIds)
            ->where(function ($q) use ($customerEmail) {
                $q->where('from_email', $customerEmail)
                  ->orWhereJsonContains('to', [['email' => $customerEmail]])
                  ->orWhereJsonContains('cc', [['email' => $customerEmail]])
                  ->orWhereJsonContains('bcc', [['email' => $customerEmail]]);
            });

        // Filter by folder if specified
        if ($folder !== 'all') {
            $query->where('folder', $folder);
        }

        // Apply pagination
        $total = $query->count();
        $emails = $query->orderBy('message_date', 'desc')
            ->skip($offset)
            ->take($limit)
            ->with(['attachments' => function ($q) {
                $q->select('id', 'email_id', 'original_name as filename', 'size', 'mime_type as type', 'storage_path');
            }])
            ->get()
            ->map(function ($email) {
                // Format email data to match the expected structure for the view
                return [
                    'uuid' => 'email-' . $email->id, // Use email.id as uuid
                    'from' => [
                        [
                            'name' => $email->from_name,
                            'email' => $email->from_email,
                        ],
                    ],
                    'to' => $email->to ?? [],
                    'subject' => $email->subject,
                    'date' => $email->message_date,
                    'body' => [
                        'html' => $email->body_html,
                        'text' => $email->body_text,
                    ],
                    'attachments' => $email->attachments->map(function ($attachment) {
                        return [
                            'filename' => $attachment->filename,
                            'type' => $attachment->type,
                            'size' => $attachment->size,
                            'download_url' => $attachment->storage_path ? Storage::url($attachment->storage_path) : null,
                        ];
                    })->toArray(),
                ];
            });
        // Get available folders from the database
        $folders = Email::whereIn('pseudo_record_id', $accountIds)
            ->distinct()
            ->pluck('folder')
            ->filter()
            ->values()
            ->toArray();
        return response()->json([
            'emails' => $emails,
            'folders' => $folders,
            'folder' => $folder,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
        ]);
    } catch (\Exception $e) {
        Log::error('Something went wrong please try again', [
            'error' => $e->getMessage(),
            'customer_email' => $customerEmail,
            'folder' => $folder,
        ]);
        return response()->json(['error' => 'Failed to fetch emails. Please try again later.'], 500);
    }
}
}