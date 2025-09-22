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
    
public function edit(Request $request, CustomerContact $customer_contact)
{
    if (!$customer_contact->id) {
        return response()->json(['error' => 'Oops! Customer contact not found!'], 404);
    }

    $customer_contact->load('creator', 'company', 'invoices', 'payments', 'notes');

    $teams = Team::where('status', 1)->orderBy('name')->get();
    $countries = config('countries');
    $brands = Brand::pluck('name', 'url');

    $resolveCompany = function ($email) use ($brands) {
        $domain = substr(strrchr($email, "@"), 1);
        $brand = $brands->first(fn($name, $url) => str_contains($url, $domain));
        return $brand ?? $domain;
    };

    // pseudo emails
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

    // Emails
    $emailsResponse = app(\App\Http\Controllers\Admin\EmailController::class)
        ->getEmails($customer_contact->email);

    $emails = $emailsResponse['emails'] ?? [];
    $folders = $emailsResponse['folders'] ?? [];
    $folder = $emailsResponse['folder'] ?? request()->get('folder', 'inbox');
    $page = (int) request()->get('page', 1);
    $limit = 5;
    $imapError = null;

    // Build timeline dataset (emails + notes)
    $timeline = [];

    foreach ($emails as $email) {
        $timeline[] = [
            'type' => 'email',
            'date' => $email['date'],
            'data' => $email,
        ];
    }

    foreach ($customer_contact->notes as $note) {
        $timeline[] = [
            'type' => 'note',
            'date' => $note->created_at,
            'data' => $note,
        ];
    }

    // Sort newest first
    usort($timeline, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    return view('admin.customers.contacts.edit', compact(
        'customer_contact',
        'brands',
        'teams',
        'pseudo_emails',
        'countries',
        'emails',
        'folders',
        'folder',
        'page',
        'limit',
        'imapError',
        'timeline' // 👈 pass to view
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
