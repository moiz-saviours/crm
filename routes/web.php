<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SmsServiceContoller;
use App\Http\Controllers\User\SettingController;
use App\Models\ClientContact;
use App\Models\Permission;
use App\Http\Controllers\User\{BrandController,
    Customer\CompanyController as UserCustomerCompanyController,
    Customer\ContactController as UserCustomerContactController,
    DashboardController,
    InvoiceController,
    LeadController,
    LeadStatusController,
    PaymentController,
    Client\ContactController as UserClientContactController,
    Client\CompanyController as UserClientCompanyController,
    Client\PaymentMerchantController as UserClientPaymentMerchantController,
    PaymentTransactionLogController,
    ProfileController,
    TeamController,
    TeamMemberController
};
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
//    return view('welcome');
});
//Route::get('/check-permissions', function () {
//    $user = auth()->user();
//    $contact = \App\Models\ClientContact::first();
//    return [
//        'can_view' => $user->can('view', 'dashboard'),
//        'policy_check' => app(\App\Policies\Client\ContactPolicy::class)
//            ->view($user, $contact),
//        'direct_check' => $user->hasPermission('client_contact', 'view'),
//        'model_types' => [
//            'database' => Permission::distinct()->pluck('model_type'),
//            'expected' => 'client_contact'
//        ]
//    ];
//});
//Route::get('assign-permission', function () {
//    $user = auth()->user();
//    $types = ['view', 'view_any', 'create', 'update', 'change_status'];
//    $permissionIds = [];
//    foreach ($types as $type) {
//        $permission = Permission::firstOrCreate([
//            'model_type' => ClientContact::class,
//            'action' => $type,
//        ]);
//        $permissionIds[] = $permission->id;
//    }
//    if (true) {
//        foreach ($permissionIds as $permissionId) {
//            $user->permissions()->syncWithoutDetaching([
//                $permissionId => [
//                    'granted' => true,
//                    'scope' => 'team'
//                ]
//            ]);
//        }
//    } else {
//        $user->permissions()->detach($permissionIds);
//    }
//    return response()->json([
//        'message' => 'Permissions assigned successfully',
//        'permissions' => $user->permissions->pluck('action')->toArray()
//    ]);
//})->middleware('auth');
require __DIR__ . '/auth.php';
Route::middleware(['auth', '2fa', 'verified:verification.notice', 'throttle:60,1', 'dynamic.access'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard')//->middleware('can:dashboard_view')
    ;
    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile');
    Route::post('/profile/image-update', [ProfileController::class, 'image_update'])->name('user.profile.image.update');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
    /** Customer Routes */
    Route::name('customer.')->group(function () {
        /** Contacts Routes */
        Route::name('contact.')->group(function () {
            Route::get('/customer/contacts', [UserCustomerContactController::class, 'index'])->name('index');
            Route::prefix('customer/contact')->group(function () {
                Route::post('/store', [UserCustomerContactController::class, 'store'])->name('store');
                Route::get('/edit/{customer_contact?}', [UserCustomerContactController::class, 'edit'])->name('edit');
                Route::post('/update/{customer_contact?}', [UserCustomerContactController::class, 'update'])->name('update');
            });
        });
        /** Companies Routes */
        Route::prefix('')->name('company.')->group(function () {
            Route::get('/customer/companies', [UserCustomerCompanyController::class, 'index'])->name('index');
        });
    });
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    /** Team Members Routes */
    Route::name('team-member.')->group(function () {
        Route::get('/team-members', [TeamMemberController::class, 'index'])->name('index');
        Route::prefix('team-members')->group(function () {

        });
    });
    /** Brand Routes */
    Route::prefix('brands')->name('brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
//        Route::get('/create', [BrandController::class, 'create'])->name('create');
//        Route::post('/store', [BrandController::class, 'store'])->name('store');
//        Route::get('/edit/{brand?}', [BrandController::class, 'edit'])->name('edit');
//        Route::post('/update/{brand?}', [BrandController::class, 'update'])->name('update');
    });
    /** Leads Routes */
    Route::name('lead.')->group(function () {
        Route::get('/leads', [LeadController::class, 'index'])->name('index');
        Route::prefix('leads')->group(function () {
            Route::post('/change-lead-status', [LeadController::class, 'change_lead_status'])->name('change.lead-status');
        });
    });
    Route::get('/lead-status', [LeadStatusController::class, 'index'])->name('lead-status.index');
    /** Invoices Routes */
    Route::name('invoice.')->group(function () {
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('index');
        Route::prefix('invoice')->group(function () {
            Route::post('/store', [InvoiceController::class, 'store'])->name('store');
            Route::get('/edit/{invoice?}', [InvoiceController::class, 'edit'])->name('edit');
            Route::post('/update/{invoice?}', [InvoiceController::class, 'update'])->name('update');
            Route::get('/payment-proofs', [InvoiceController::class, 'getPaymentProof'])->name('payment_proofs');
        });
    });
    /** Payment Routes */
    Route::name('user.payment.')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('index');
        Route::prefix('payment')->group(function () {
            Route::post('/store', [PaymentController::class, 'store'])->name('store');
        });
    });
    /** Payment Transaction Logs Route */
    Route::get('payment-transaction-logs', [PaymentTransactionLogController::class, 'getLogs'])->name('payment-transaction-logs');
    /** Client Contacts Routes */
    Route::name('user.client.')->group(function () {
        Route::name('contact.')->group(function () {
            Route::get('/client/contacts', [UserClientContactController::class, 'index'])->name('index')//                ->middleware('can:viewAny,App\Models\ClientContact')
            ;
            Route::prefix('client/contact')->group(function () {
                Route::get('/companies/{client_contact?}', [UserClientContactController::class, 'companies'])->name('companies')//                    ->middleware('can:view,client_contact')
                ;
                Route::get('/create', [UserClientContactController::class, 'create'])->name('create')//                    ->middleware('can:create,App\Models\ClientContact')
                ;
                Route::post('/store', [UserClientContactController::class, 'store'])->name('store')//                    ->middleware('can:create,App\Models\ClientContact')
                ;
                Route::get('/edit/{client_contact?}', [UserClientContactController::class, 'edit'])->name('edit')//                    ->middleware('can:update,client_contact')
                ;
                Route::post('/update/{client_contact?}', [UserClientContactController::class, 'update'])->name('update')//                    ->middleware('can:update,client_contact')
                ;
                Route::get('/change-status/{client_contact?}', [UserClientContactController::class, 'change_status'])->name('change.status')//                    ->middleware('can:update,client_contact')
                ;
            });
        });
        /** Client Companies Routes */
        Route::name('company.')->group(function () {
            Route::get('/client/companies', [UserClientCompanyController::class, 'index'])->name('index');
            Route::prefix('client/company')->group(function () {
                Route::get('/create', [UserClientCompanyController::class, 'create'])->name('create');
                Route::post('/store', [UserClientCompanyController::class, 'store'])->name('store');
                Route::get('/edit/{client_company?}', [UserClientCompanyController::class, 'edit'])->name('edit');
                Route::post('/update/{client_company?}', [UserClientCompanyController::class, 'update'])->name('update');
                Route::get('/change-status/{client_company?}', [UserClientCompanyController::class, 'change_status'])->name('change.status');
            });
        });
        /** Payment Merchant Routes */
        /** Payment Merchant Routes */
        Route::name('account.')->group(function () {
            Route::get('/client/accounts', [UserClientPaymentMerchantController::class, 'index'])->name('index');
            Route::prefix('client/account')->group(function () {
                Route::get('/create', [UserClientPaymentMerchantController::class, 'create'])->name('create');
                Route::post('/store', [UserClientPaymentMerchantController::class, 'store'])->name('store');
                Route::get('/edit/{client_account?}', [UserClientPaymentMerchantController::class, 'edit'])->name('edit');
                Route::post('/update/{client_account?}', [UserClientPaymentMerchantController::class, 'update'])->name('update');
                Route::get('/change-status/{client_account?}', [UserClientPaymentMerchantController::class, 'change_status'])->name('change.status');
                Route::get('/by-brand/{brand_key?}/{currency?}', [UserClientPaymentMerchantController::class, 'by_brand'])->name('by.brand');
            });
        });
    });
    /** Save Setting Route */
    Route::post('/save-settings', [SettingController::class, 'saveSettings'])->name('save.settings');
});
require __DIR__ . '/admin-old-routes.php';
require __DIR__ . '/admin-routes.php';
require __DIR__ . '/developer-routes.php';
Route::get('/csrf-token', function () {
    session()->invalidate();
    session()->regenerate();
    return response()->json(['token' => csrf_token()]);
})->name('csrf.token');
Route::middleware(['restrict.dev'])->group(function () {
    Route::get('/artisan/{code?}/{command?}', function ($code = null, $command = 'optimize:clear') {
        if ($code && $code === config('app.artisan_code') && Auth::guard('developer')->check() && app()->environment('local')) {
            Artisan::call($command);
            dd([
                'status' => 'success',
                'output' => trim(Artisan::output()),
                'message' => "The command '{$command}' was executed successfully!"
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'This route is disabled!'
        ], 403);
    })->middleware('restrict.dev')->name('artisan.command');
    Route::get('/model/{code?}', function (Request $request, $code = null) {
        if ($code && $code === config('app.artisan_code') && Auth::guard('developer')->check() && app()->environment('local')) {
            try {
                $command = $request->get('command');
                if (!$command) {
                    throw new Exception('No SQL command provided.');
                }
                $result = DB::select($command);
                return response()->json([
                    'status' => 'success',
                    'command' => $command,
                    'result' => $result,
                    'message' => "The SQL query was executed successfully!",
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'This route is disabled!',
        ], 403);
    })->middleware('restrict.dev')->name('model.command');
});
Route::fallback(function (Request $request) {
    $attempts = session('fallback_attempts', 0) + 1;
    session(['fallback_attempts' => $attempts]);
    if ($attempts < 2 && auth()->check()) {
        return back();
    }
    if ((!str_contains(url()->current(), 'checkout') && !$request->has('InvoiceID')) && (!str_contains(url()->current(), 'invoice') && !$request->has('InvoiceID'))) {
        return redirect('/login');
    }
    abort(404, 'Page not found');
});
Route::get('invoice', [CheckoutController::class, 'index'])->name('invoice');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('twilio-sms/status/{sid?}', [SmsServiceContoller::class, 'smsStatus'])->name('twilio.sms.status');



Route::get('/emails/open/{id}', [App\Http\Controllers\EmailTrackingController::class, 'trackOpen'])->name('emails.track.open');
Route::get('/emails/click/{id}', [App\Http\Controllers\EmailTrackingController::class, 'trackClick'])->name('emails.track.click');

Route::post('/emails/bounce', [App\Http\Controllers\EmailTrackingController::class, 'trackBounce'])->name('emails.track.bounce');
Route::post('/emails/delivery', [App\Http\Controllers\EmailTrackingController::class, 'trackDelivery'])->name('emails.track.delivery');
Route::post('/emails/spam-report', [App\Http\Controllers\EmailTrackingController::class, 'trackSpamReport'])->name('emails.track.spam_report');


// Route::get('/email-thread-check', function () {
//     $serverHost = 'mail.pivotbookwriting.com';
//     $serverPort = 993;
//     $encryption = 'ssl';
//     $username = 'hasnat.developer@pivotbookwriting.com';
//     $password = 'ATko513Wqyabs';

//     $mailbox = sprintf('{%s:%d/imap/%s}INBOX', $serverHost, $serverPort, $encryption);
//     $imapStream = @imap_open($mailbox, $username, $password);

//     if (!$imapStream) {
//         return response()->json([
//             'error' => 'Cannot connect to IMAP server',
//             'details' => imap_last_error(),
//         ], 500);
//     }

//     $uids = imap_search($imapStream, 'ALL', SE_UID);

//     if (!$uids) {
//         imap_close($imapStream);
//         return response()->json(['message' => 'No emails found.']);
//     }

//     $emails = [];

//     foreach ($uids as $uid) {
//         $msgno = imap_msgno($imapStream, $uid);
//         if (!$msgno) continue;

//         // Fetch full header as plain text
//         $rawHeader = imap_fetchheader($imapStream, $msgno);

//         // Decode structured header info too
//         $header = imap_headerinfo($imapStream, $msgno);

//         $emails[] = [
//             'uid' => $uid,
//             'subject' => $header->subject ?? '(No Subject)',
//             'from' => $header->fromaddress ?? '(unknown sender)',
//             'date' => $header->date ?? '(unknown date)',
//             'message_id' => $header->message_id ?? '(none)',
//             'in_reply_to' => $header->in_reply_to ?? '(none)',
//             'references' => $header->references ?? '(none)',
//             'decoded_header' => $header, // structured PHP object
//             'raw_header' => $rawHeader, // full plain text header
//         ];
//     }

//     imap_close($imapStream);

//     return response()->json([
//         'total_emails' => count($emails),
//         'emails' => $emails,
//     ], 200, [], JSON_PRETTY_PRINT);
// });




Route::get('/imap-email-dump', function () {
    $serverHost = 'mail.pivotbookwriting.com';
    $serverPort = 993;
    $encryption = 'ssl';
    $username = 'hasnat.developer@pivotbookwriting.com';
    $password = 'ATko513Wqyabs';

    try {
        $connection = imap_open(
            "{{$serverHost}:{$serverPort}/imap/{$encryption}}INBOX",
            $username,
            $password
        );

        if (!$connection) {
            throw new Exception('Failed to connect: ' . imap_last_error());
        }

        // Fetch recent few emails
        $uids = imap_search($connection, 'ALL', SE_UID) ?: [];
        $uids = array_slice(array_reverse($uids), 0, 5);

        $emails = [];

        foreach ($uids as $uid) {
            $overview = imap_fetch_overview($connection, $uid, FT_UID)[0] ?? null;
            $header = imap_headerinfo($connection, imap_msgno($connection, $uid));
            $structure = imap_fetchstructure($connection, $uid, FT_UID);

            $bodies = [];
            $attachments = [];

            // Recursive function to extract all parts
            $extractParts = function ($part, $uid, $partNum = null) use ($connection, &$extractParts, &$bodies, &$attachments) {
                $isAttachment = false;
                $filename = null;

                // Detect attachment filename
                if (isset($part->dparameters)) {
                    foreach ($part->dparameters as $param) {
                        if (strtolower($param->attribute) === 'filename') {
                            $filename = $param->value;
                        }
                    }
                }
                if (isset($part->parameters)) {
                    foreach ($part->parameters as $param) {
                        if (strtolower($param->attribute) === 'name') {
                            $filename = $param->value;
                        }
                    }
                }

                if ($filename) {
                    $isAttachment = true;
                }

                // Fetch body part
                $data = '';
                if ($partNum) {
                    $data = imap_fetchbody($connection, $uid, $partNum, FT_UID);
                } else {
                    $data = imap_body($connection, $uid, FT_UID);
                }

                // Decode according to encoding
                if (isset($part->encoding)) {
                    if ($part->encoding == 3) { // base64
                        $data = base64_decode($data);
                    } elseif ($part->encoding == 4) { // quoted-printable
                        $data = quoted_printable_decode($data);
                    }
                }

                if ($isAttachment && $filename) {
                    $attachments[] = [
                        'filename' => $filename,
                        'mime_type' => $part->subtype ?? '',
                        'encoding' => $part->encoding ?? null,
                        'size' => strlen($data),
                        'preview' => substr(base64_encode($data), 0, 100) . '...',
                    ];
                } else {
                    // Text/HTML bodies
                    $type = ($part->subtype ?? 'TEXT');
                    $bodies[] = [
                        'type' => $type,
                        'encoding' => $part->encoding ?? null,
                        'content' => mb_substr($data, 0, 500) . (strlen($data) > 500 ? '...' : ''), // limit
                    ];
                }

                // Recurse if multipart
                if (isset($part->parts) && count($part->parts)) {
                    foreach ($part->parts as $index => $subpart) {
                        $subPartNum = $partNum ? $partNum . '.' . ($index + 1) : ($index + 1);
                        $extractParts($subpart, $uid, $subPartNum);
                    }
                }
            };

            $extractParts($structure, $uid);

            $emails[] = [
                'uid' => $uid,
                'subject' => $overview->subject ?? '',
                'from' => $overview->from ?? '',
                'date' => $overview->date ?? '',
                'header' => $header,
                'bodies' => $bodies,
                'attachments' => $attachments,
            ];
        }

        imap_close($connection);

        echo "<pre>";
        print_r($emails);
        echo "</pre>";
        exit;

    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
});
