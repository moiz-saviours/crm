<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\User;
use App\Models\UserPseudoRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\ImapService;
use Illuminate\Support\Facades\Auth;
use App\Models\Email;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;


class ContactController extends Controller
{
    private ImapService $imapService;

    public function __construct(ImapService $imapService)
    {
        $this->imapService = $imapService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $brands = Brand::all();
        $teams = Team::all();
        $countries = config('countries');
        $customer_contacts = CustomerContact::all();
        return view('admin.customers.contacts.index', compact('customer_contacts', 'brands', 'teams', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $countries = Cache::rememberForever('countries_list', fn() => config('countries'));
        return view('admin.customers.contacts.create', compact('brands', 'teams', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customer_contacts,email',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 0) {
                        if (empty($value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field is required when type is Fresh.");
                        }
                        if (!preg_match('/^(\+?\d{1,3}[-.\s]?)?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/', $value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field format is invalid.");
                        }
                        if (strlen($value) < 8) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must be at least 8 characters.");
                        }
                        if (strlen($value) > 20) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must not be greater than 20 characters.");
                        }
                    }
                },
            ],
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'Please select a valid brand.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'Please select a valid team.',
        ]);
        $customer_contact = new CustomerContact($request->only([
            'brand_key',
            'team_key',
            'name',
            'email',
            'phone',
            'address',
            'city',
            'state',
            'country',
            'zipcode',
            'ip_address',
            'creator_type',
            'creator_id',
            'status',
        ]) + ['special_key' => CustomerContact::generateSpecialKey()]);
        $customer_contact->save();
        $customer_contact->loadMissing('team', 'brand', 'company');
        return response()->json(['data' => $customer_contact, 'success' => 'Contact Created Successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerContact $customer_contact)
    {
        return response()->json(['customer_contact' => $customer_contact]);
    }

    /**
     * Show the form for editing the specified resource.
     */


    protected function getTimeline($customerEmail, $folder = "all", $page = 1, $limit = 10, $tab = 'activities')
    {
        $customerContact = CustomerContact::where('email', $customerEmail)->first();
        if (!$customerContact) {
            return ['timeline' => [], 'page' => $page, 'limit' => $limit, 'count' => 0];
        }

        $customerContact->load('notes', 'lead.activities');
        $user = Auth::guard('admin')->user();
        $auth_pseudo_emails = UserPseudoRecord::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->where('imap_type', 'imap')
            ->pluck('pseudo_email')
            ->toArray();

        $query = Email::with('events');
        if ($folder == 'inbox') {
            $query->where('from_email', $customerEmail)
                ->where(function ($q) use ($auth_pseudo_emails) {
                    foreach ($auth_pseudo_emails as $email) {
                        $q->orWhereJsonContains('to', ['email' => $email])
                            ->orWhereJsonContains('cc', ['email' => $email])
                            ->orWhereJsonContains('bcc', ['email' => $email]);
                    }
                });
        } elseif ($folder == 'sent') {
            $query->whereIn('from_email', $auth_pseudo_emails);
        } elseif ($folder == 'drafts') {
            $query->where('folder', 'drafts')
                ->whereIn('from_email', $auth_pseudo_emails);
        } elseif ($folder == 'spam') {
            $query->where('folder', 'spam')
                ->where(function ($q) use ($customerEmail, $auth_pseudo_emails) {
                    $q->where('from_email', $customerEmail)
                        ->orWhereIn('from_email', $auth_pseudo_emails);
                });
        } elseif ($folder == 'trash') {
            $query->where('folder', 'trash');
        } elseif ($folder == 'archive') {
            $query->where('folder', 'archive');
        } else {
            $query->where(function ($q) use ($customerEmail, $auth_pseudo_emails) {
                $q->where('from_email', $customerEmail)
                    ->orWhereJsonContains('to', ['email' => $customerEmail])
                    ->orWhereJsonContains('cc', ['email' => $customerEmail])
                    ->orWhereJsonContains('bcc', ['email' => $customerEmail]);

                if (!empty($auth_pseudo_emails)) {
                    $q->orWhere(function ($sub) use ($customerEmail, $auth_pseudo_emails) {
                        $sub->where('from_email', $customerEmail)
                            ->where(function ($nested) use ($auth_pseudo_emails) {
                                foreach ($auth_pseudo_emails as $addr) {
                                    $nested->orWhereJsonContains('to', ['email' => $addr])
                                        ->orWhereJsonContains('cc', ['email' => $addr])
                                        ->orWhereJsonContains('bcc', ['email' => $addr]);
                                }
                            });
                        $sub->orWhere(function ($nested) use ($customerEmail, $auth_pseudo_emails) {
                            $nested->whereIn('from_email', $auth_pseudo_emails)
                                ->where(function ($nn) use ($customerEmail) {
                                    $nn->orWhereJsonContains('to', ['email' => $customerEmail])
                                        ->orWhereJsonContains('cc', ['email' => $customerEmail])
                                        ->orWhereJsonContains('bcc', ['email' => $customerEmail]);
                                });
                        });
                    });
                }
            });
        }

        if ($folder !== 'all') {
            $query->where('folder', $folder);
        }

        $offset = ($page - 1) * $limit;
        $emails = $query->orderBy('message_date', 'desc')
            ->with(['attachments' => function ($q) {
                $q->select('id', 'email_id', 'original_name', 'size', 'mime_type', 'base64_content');
            }])
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($email) use ($query) {
                $threadEmails = $query->where('thread_id', $email->thread_id)
                    ->where('id', '!=', $email->id)
                    ->with(['attachments' => function ($q) {
                        $q->select('id', 'email_id', 'original_name', 'size', 'mime_type', 'base64_content');
                    }])
                    ->get()
                    ->map(function ($threadEmail) {
                        return [
                            'uuid' => 'email-' . $threadEmail->id,
                            'thread_id' => $threadEmail->thread_id ?? [],
                            'message_id' => $threadEmail->message_id ?? '',
                            'references' => $threadEmail->references ?? [],
                            'from' => [
                                'name' => $threadEmail->from_name,
                                'email' => $threadEmail->from_email,
                            ],
                            'to' => $threadEmail->to ?? [],
                            'cc' => $threadEmail->cc ?? [],
                            'bcc' => $threadEmail->bcc ?? [],
                            'subject' => $threadEmail->subject,
                            'folder' => $threadEmail->folder,
                            'type' => $threadEmail->type,
                            'date' => $threadEmail->message_date,
                            'body' => [
                                'html' => $threadEmail->body_html,
                                'text' => $threadEmail->body_text,
                            ],
                            'attachments' => $threadEmail->attachments->map(function ($attachment) {
                                return [
                                    'filename' => $attachment->original_name,
                                    'type' => $attachment->mime_type,
                                    'size' => $attachment->size,
                                    'download_url' => $attachment->storage_path ? Storage::url($attachment->storage_path) : null,
                                ];
                            })->toArray(),
                            'open_count' => $threadEmail->events->where('event_type', 'open')->count(),
                            'click_count' => $threadEmail->events->where('event_type', 'click')->count(),
                            'bounce_count' => $threadEmail->events->where('event_type', 'bounce')->count(),
                            'spam_count' => $threadEmail->events->where('event_type', 'spam')->count(),
                            'events' => $threadEmail->events->map(function ($event) {
                                $icons = [
                                    'open' => 'fa-envelope-open',
                                    'click' => 'fa-mouse-pointer',
                                    'bounce' => 'fa-exclamation-triangle',
                                    'spam' => 'fa-ban',
                                ];
                                return [
                                    'id' => $event->id,
                                    'event_type' => $event->event_type,
                                    'created_at' => $event->created_at,
                                    'icon' => $icons[$event->event_type] ?? 'fa-info-circle',
                                ];
                            })->values()->toArray(),
                        ];
                    })->toArray();
                return [
                    'uuid' => 'email-' . $email->id,
                    'thread_id' => $email->thread_id ?? [],
                    'message_id' => $email->message_id ?? '',
                    'references' => $email->references ?? [],
                    'from' => [
                        'name' => $email->from_name,
                        'email' => $email->from_email,
                    ],
                    'to' => $email->to ?? [],
                    'cc' => $email->cc ?? [],
                    'bcc' => $email->bcc ?? [],
                    'subject' => $email->subject,
                    'folder' => $email->folder,
                    'type' => $email->type,
                    'date' => $email->message_date,
                    'body' => [
                        'html' => $email->body_html,
                        'text' => $email->body_text,
                    ],
                    'attachments' => $email->attachments->map(function ($attachment) {
                        return [
                            'id' => $attachment->id,
                            'filename' => $attachment->original_name,
                            'type' => $attachment->mime_type,
                            'size' => $attachment->size,
                            'data' => $attachment->base64_content
                                ? 'data:' . $attachment->mime_type . ';base64,' . $attachment->base64_content
                                : null,
                        ];
                    })->toArray(),
                    'thread_emails' => $threadEmails,
                    'thread_email_count' => count($threadEmails) ?? 0,
                    'open_count' => $email->events->where('event_type', 'open')->count(),
                    'click_count' => $email->events->where('event_type', 'click')->count(),
                    'bounce_count' => $email->events->where('event_type', 'bounce')->count(),
                    'spam_count' => $email->events->where('event_type', 'spam')->count(),
                    'events' => $email->events->map(function ($event) {
                        $icons = [
                            'open' => 'fa-envelope-open',
                            'click' => 'fa-mouse-pointer',
                            'bounce' => 'fa-exclamation-triangle',
                            'spam' => 'fa-ban',
                        ];
                        return [
                            'id' => $event->id,
                            'event_type' => $event->event_type,
                            'created_at' => $event->created_at,
                            'icon' => $icons[$event->event_type] ?? 'fa-info-circle',
                        ];
                    })->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();

        $timeline = [];
        if ($tab === 'activities' || $tab === 'emails') {
            foreach ($emails as $email) {
                $timeline[] = [
                    'type' => 'email',
                    'date' => $email['date'],
                    'data' => $email,
                ];
            }
        }
        if ($tab === 'activities' || $tab === 'notes') {
            foreach ($customerContact->notes as $note) {
                $timeline[] = [
                    'type' => 'note',
                    'date' => $note->created_at,
                    'data' => $note,
                ];
            }
        }
        if ($tab === 'activities') {
            if ($customerContact->lead && $customerContact->lead->activities) {
                foreach ($customerContact->lead->activities as $activity) {
                    $decoded = json_decode($activity->event_data);
                    $activity->data = $decoded;
                    if ($activity->event_type === 'conversion') {
                        $timeline[] = [
                            'type' => 'conversion',
                            'date' => $activity->created_at,
                            'data' => $activity,
                        ];
                    } else {
                        $timeline[] = [
                            'type' => 'activity',
                            'date' => $activity->created_at,
                            'data' => $activity,
                        ];
                    }
                }
            }
        }

        usort($timeline, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        $offset = ($page - 1) * $limit;
        $paginatedTimeline = array_slice($timeline, $offset, $limit);

        return [
            'customer_contact' => $customerContact,
            'timeline' => $paginatedTimeline,
            'page' => $page,
            'limit' => $limit,
            'count' => count($paginatedTimeline),
        ];
    }

    public function refresh(Request $request)
    {
        try {
            $customerEmail = urldecode(trim($request->query('customer_email')));
            $folder = $request->query('folder', 'all');
            $tab = $request->query('tab', 'activities');
            $page = (int) $request->query('page', 1);
            $limit = (int) $request->query('limit', 10);

            if (empty($customerEmail)) {
                return response()->json(['error' => 'Customer email is required'], 400);
            }

            $data = $this->getTimeline($customerEmail, $folder, $page, $limit, $tab);

            $customerContact = $data['customer_contact']; // set separately

            $htmlTimeline = collect($data['timeline'])->map(function ($item) use ($customerContact) {
                if ($item['type'] === 'note') {
                    return view('admin.customers.contacts.timeline.partials.card-box.note', ['item' => $item])->render();
                } elseif ($item['type'] === 'email') {
                    return view('admin.customers.contacts.timeline.partials.card-box.email', ['item' => $item])->render();
                } elseif ($item['type'] === 'activity') {
                    return view(
                        'admin.customers.contacts.timeline.partials.card-box.activity',
                        [
                            'item' => $item,
                            'customer_contact' => $customerContact
                        ]
                    )->render();
                } elseif ($item['type'] === 'conversion') {
                    return view('admin.customers.contacts.timeline.partials.card-box.conversion', ['item' => $item])->render();
                }
                return '';
            })->implode('');

            return response()->json([
                'timeline' => $htmlTimeline,
                'page' => $data['page'],
                'limit' => $data['limit'],
                'count' => $data['count'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Processing complete.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchRemote(Request $request)
    {
        try {
            $customerEmail = $request->query('customer_email');
            $tab = $request->query('tab', 'activities');
            if (!$customerEmail) {
                Log::warning('Customer email missing for fetchRemote');
                return response()->json([
                    'status' => 'warning',
                    'message' => 'No customer email provided. Please try again.'
                ], 200);
            }

            $user = Auth::guard('admin')->user();
            $pseudoEmails = UserPseudoRecord::where('morph_id', $user->id)
                ->where('morph_type', get_class($user))
                ->where('imap_type', 'imap')
                ->pluck('pseudo_email')
                ->toArray();

            if (empty($pseudoEmails)) {
                Log::warning('No pseudo emails found for user', ['user_id' => $user->id]);
                return response()->json([
                    'status' => 'warning',
                    'message' => 'No accounts found for this user. Please check settings.'
                ], 200);
            }

            // Only fetch new emails, as notes/activities/conversions are typically updated locally
            if ($tab === 'activities' || $tab === 'emails') {
                $command = ['emails:fetch', '--address=' . $customerEmail];
                foreach ($pseudoEmails as $email) {
                    $command[] = '--account=' . $email;
                }

                $exitCode = Artisan::call(implode(' ', $command));

                if ($exitCode !== 0) {
                    Log::error('Failed to run emails:fetch command for timeline', [
                        'customer_email' => $customerEmail,
                        'pseudo_emails' => $pseudoEmails,
                        'exit_code' => $exitCode,
                    ]);
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Unable to fetch new timeline items at the moment. Please try again later.'
                    ], 200);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'New timeline items fetched successfully.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching new timeline', [
                'customer_email' => $request->query('customer_email'),
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'status' => 'warning',
                'message' => 'Something went wrong while fetching timeline items. Please try again later.'
            ], 200);
        }
    }

    public function edit(Request $request, CustomerContact $customer_contact)
    {
        if (!$customer_contact->id) {
            return response()->json(['error' => 'Oops! Customer contact not found!'], 404);
        }
        $customer_contact->load('creator', 'company', 'invoices', 'payments', 'notes', 'lead.activities');
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $countries = config('countries');
        $brands = Brand::pluck('name', 'url');
        $resolveCompany = function ($email) use ($brands) {
            $domain = substr(strrchr($email, "@"), 1);
            $brand = $brands->first(fn($name, $url) => str_contains($url, $domain));
            return $brand ?? $domain;
        };
        $auth_pseudo_emails = [];
        if (auth()->user()->pseudo_email) {
            $auth_pseudo_emails[] = [
                'name' => auth()->user()->pseudo_name ?? 'Unknown Sender',
                'email' => auth()->user()->pseudo_email,
                'company' => $resolveCompany(auth()->user()->pseudo_email),
            ];
        }
        $userPseudoEmails = User::whereNotNull('pseudo_email')
            ->get(['id', 'pseudo_name', 'pseudo_email'])
            ->map(fn($user) => [
                'name' => $user->pseudo_name ?? 'Unknown Sender',
                'email' => $user->pseudo_email,
                'company' => $resolveCompany($user->pseudo_email),
            ]);
        $extraPseudoEmails = UserPseudoRecord::all(['pseudo_name', 'pseudo_email'])
            ->map(fn($pseudo) => [
                'name' => $pseudo->pseudo_name ?? 'Unknown Sender',
                'email' => $pseudo->pseudo_email,
                'company' => $resolveCompany($pseudo->pseudo_email),
            ]);
        $pseudo_emails = collect($auth_pseudo_emails)
            ->merge($userPseudoEmails)
            ->merge($extraPseudoEmails)
            ->unique('email')
            ->values();
        $emailsResponse = $this->getTimeline($customer_contact->email, 'all', 1, 10, 'activities');
        $timeline = $emailsResponse['timeline'] ?? [];
        $page = (int)request()->get('page', 1);
        $limit = 10;
        $imapError = null;
        return view('admin.customers.contacts.edit', compact(
            'customer_contact',
            'brands',
            'teams',
            'pseudo_emails',
            'countries',
            'page',
            'limit',
            'imapError',
            'timeline'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerContact $customer_contact)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customer_contacts,email,' . $customer_contact->id,
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 0) {
                        if (empty($value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field is required when type is Fresh.");
                        }
                        if (!preg_match('/^(\+?\d{1,3}[-.\s]?)?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/', $value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field format is invalid.");
                        }
                        if (strlen($value) < 8) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must be at least 8 characters.");
                        }
                        if (strlen($value) > 20) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must not be greater than 20 characters.");
                        }
                    }
                },
            ],
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'Please select a valid brand.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'Please select a valid team.',
        ]);
        $customer_contact->fill($request->only([
            'special_key',
            'brand_key',
            'team_key',
            'name',
            'email',
            'phone',
            'address',
            'city',
            'state',
            'country',
            'zipcode',
            'ip_address',
            'status',
        ]));
        $customer_contact->save();
        $customer_contact->loadMissing('team', 'brand', 'company');
        return response()->json(['data' => $customer_contact, 'success' => 'Contact Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CustomerContact $customer_contact)
    {
        try {
            if ($customer_contact->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, CustomerContact $customer_contact)
    {
        try {
            $customer_contact->status = $request->query('status');
            $customer_contact->save();
            return response()->json(['success' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Send an email with professional handling
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function sendEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'email_content' => 'required|string',
            'to' => 'required|string',
            'from' => 'required|email',
            'cc' => 'sometimes|string|nullable',
            'bcc' => 'sometimes|string|nullable'
        ]);
        try {
            $sender = $this->findSender($request->from);
            if (!$sender) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sender not authorized or not found'
                ], 403);
            }
            $toEmails = $this->parseEmailList($request->to);
            $ccEmails = $this->parseEmailList($request->cc);
            $bccEmails = $this->parseEmailList($request->bcc);
            if (empty($toEmails)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid recipients specified'
                ], 400);
            }
            $fromUnformattedEmail = $request->from;
            $fromFormattedEmail = $this->formatFromEmail($fromUnformattedEmail);
            $fromName = $this->getSenderName($sender, $fromUnformattedEmail);
            $this->sendMail($validated, $toEmails, $fromUnformattedEmail, $fromFormattedEmail, $fromName, $ccEmails, $bccEmails);
            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully'
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'error' => $e->getMessage(),
                'from' => $request->from,
                'to' => $request->to
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again.'
            ], 500);
        }
    }

    /**
     * Find sender across multiple data sources
     */
    private function findSender(string $email): ?object
    {
        return Admin::where('email', $email)
            ->orWhere('pseudo_email', $email)
            ->first()
            ?? User::where('email', $email)
            ->orWhere('pseudo_email', $email)
            ->first()
            ?? UserPseudoRecord::where('pseudo_email', $email)->first();
    }

    /**
     * Parse JSON email list with validation
     */
    private function parseEmailList(?string $emails): array
    {
        if (empty($emails)) {
            return [];
        }
        $parsed = json_decode($emails, true);
        return is_array($parsed) ? array_filter($parsed) : [];
    }

    /**
     * Format from email address
     */
    private function formatFromEmail(string $email): string
    {
        [$localPart, $domain] = explode('@', $email);
        $configDomain = explode('@', config('mail.from.address'))[1];
        return "{$localPart}={$domain}@{$configDomain}";
    }

    /**
     * Get sender display name with brand information
     */
    private function getSenderName(object $sender, string $email): string
    {
        $senderName = $sender->pseudo_name ?? explode('@', $email)[0];
        $domain = explode('@', $email)[1];
        $brand = Brand::where('url', 'like', "%{$domain}%")->first();
        $brandName = $brand->name ?? $domain;
        return "{$senderName} from {$brandName}";
    }

    /**
     * Send the email message
     */
    private function sendMail(
        array  $validated,
        array  $toEmails,
        string $fromUnformattedEmail,
        string $fromFormattedEmail,
        string $fromName,
        array  $ccEmails,
        array  $bccEmails
    ): void {
        Mail::send([], [], function (Message $message) use (
            $validated,
            $toEmails,
            $fromUnformattedEmail,
            $fromFormattedEmail,
            $fromName,
            $ccEmails,
            $bccEmails
        ) {
            $message->to($toEmails)
                ->from($fromUnformattedEmail, $fromName)
                ->replyTo($fromUnformattedEmail, $fromName)
                ->returnPath($fromFormattedEmail)
                ->subject($validated['subject'])
                ->html($validated['email_content']);
            if (!empty($ccEmails)) {
                $message->cc($ccEmails);
            }
            if (!empty($bccEmails)) {
                $message->bcc($bccEmails);
            }
        });
    }
}
