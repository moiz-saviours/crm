<?php

use App\Http\Controllers\Admin\{DashboardController as AdminDashboardController,
    ChannelController as AdminChannelController,
    AccountController as AdminAccountController,
    ActivityLogController as AdminActivityLogController,
    BrandController as AdminBrandController,
    Client\CompanyController as AdminClientCompanyController,
    Client\ContactController as AdminClientContactController,
    Client\PaymentMerchantController as AdminPaymentMerchantController,
    Customer\CompanyController as AdminCustomerCompanyController,
    Customer\ContactController as AdminCustomerContactController,
    Customer\InboxController as AdminCustomerInboxController,
    Customer\NoteController as AdminCustomerNoteController,
    EmployeeController as AdminEmployeeController,
    InvoiceController as AdminInvoiceController,
    LeadController as AdminLeadController,
    LeadStatusController as AdminLeadStatusController,
    PaymentTransactionLogController as AdminPaymentTransactionLogController,
    PaymentController as AdminPaymentController,
    ProfileController as AdminProfileController,
    SettingController as AdminSettingController,
    TaskController as AdminTaskController,
    TeamController as AdminTeamController,
    TeamTargetController as AdminTeamTargetController,
    SalesKpiController as AdminSalesKpiController};
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

require __DIR__ . '/admin-auth.php';
Route::middleware(['auth:admin', '2fa:admin', 'throttle:60,1'])->prefix('admin')->name('admin.')->group(function () {
//Route::middleware(['auth:admin','2fa:admin', 'verified:admin.verification.notice', 'throttle:60,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/check-channels', function (Request $request) {
        $authUser = Auth::user();
        $tableToCheck = 'admins';
        $allChannels = \App\Models\Channel::where('status', 1)->get();
        $validChannels = [];
        $host = $request->getHost();
        $port = $request->getPort();
        $fullCurrentDomain = $port && $port != 80 && $port != 443 ? "$host:$port" : $host;
        $referer = $request->header('referer');
        $currentPath = $referer ? parse_url($referer, PHP_URL_PATH) : '/';
        $debugDetails = [];
        $isLocalEnvironment = app()->environment('local');
        foreach ($allChannels as $channel) {
            $channelUrl = $channel->url;
            $parsedUrl = parse_url($channelUrl);
            $baseDomain = $parsedUrl['host'] ?? '';
            $port = $parsedUrl['port'] ?? null;
            $displayDomain = $port ? "{$baseDomain}:{$port}" : $baseDomain;
            $channelName = $channel->name;
            $isLocal = str_contains($baseDomain, 'localhost');
            $ssl = $isLocal ? 'http' : 'https';
            // Skip current domain to avoid self-checking
            if ($baseDomain === $request->getHost() && $port == $request->getPort()) {
                $debugDetails[] = [
                    'domain' => $displayDomain,
                    'channelName' => $channelName,
                    'skipped' => 'Skipped because same as current domain',
                ];
                continue;
            }
            // Only allow local-to-local redirects in local environment
            if (!$isLocalEnvironment && $isLocal) {
                $debugDetails[] = [
                    'domain' => $displayDomain,
                    'channelName' => $channelName,
                    'skipped' => 'Skipped because local domain in non-local environment',
                ];
                continue;
            }
            // Build the proper URL with port if exists
            $portPart = $port ? ":{$port}" : '';
            $finalUrl = "{$ssl}://{$baseDomain}{$portPart}{$currentPath}";
            // Generate access token
            $payload = [
                'table' => $tableToCheck,
                'email' => $authUser->email,
                'ip_address' => $request->ip(),
                'expires_at' => now()->addSeconds(config('session.lifetime') * 60),
            ];
            $key = base64_decode("AxS9/+trvgrFBcvBwuYl0kjVocGf8t+eiol6LtErpck=");
            $encrypter = new Encrypter($key, 'AES-256-CBC');
            $accessToken = $encrypter->encrypt($payload);
            $validChannels[] = [
                'domain' => $displayDomain,
                'name' => $channelName,
                'access_token' => urlencode($accessToken),
                'url' => $finalUrl,
                'logo' => $channel->logo ? asset($channel->logo) : null,
                'favicon' => $channel->favicon ? asset($channel->favicon) : null,
                'is_local' => $isLocal,
            ];
            // For local environments, skip the API check
            if ($isLocalEnvironment) {
                $debugDetails[] = [
                    'domain' => $displayDomain,
                    'channelName' => $channelName,
                    'skipped' => 'Skipped API check in local environment',
                    'auto_approved' => true
                ];
                continue;
            }
            // For non-local environments, perform API check
            $prefix = app()->environment('development') ? '/crm-development' : '';
            $checkUrl = "{$ssl}://{$baseDomain}{$prefix}/api/check-user";
            $domainDebug = [
                'domain' => $displayDomain,
                'channelName' => $channelName,
                'attemptedUrl' => $checkUrl,
                'responseStatus' => null,
                'responseData' => null,
                'exception' => null,
            ];
            try {
                $response = Http::timeout(3)->post($checkUrl, [
                    'email' => $authUser->email,
                    'table' => $tableToCheck
                ]);
                $domainDebug['responseStatus'] = $response->status();
                $domainDebug['responseData'] = $response->json();
                if (!$response->ok() || !$response->json('exists')) {
                    array_pop($validChannels); // Remove the channel if check fails
                }
            } catch (\Exception $e) {
                Log::error("Channel check failed for {$displayDomain}: " . $e->getMessage());
                $domainDebug['exception'] = $e->getMessage();
                array_pop($validChannels); // Remove the channel if check fails
            }
            $debugDetails[] = $domainDebug;
        }
        return response()->json([
            'success' => true,
            'validChannels' => $validChannels,
            'currentChannel' => [
                'name' => config('app.name'),
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
                'favicon' => asset('assets/img/favicon.png'),
            ],
            'debug' => $debugDetails
        ]);
    })->name('check.channels');
    Route::get('/dashboard', [AdminDashboardController::class, 'index_1'])->name('dashboard');
    Route::get('/dashboard-2', [AdminDashboardController::class, 'index_2'])->name('dashboard.2');
    Route::get('/dashboard-2-update-stats', [AdminDashboardController::class, 'index_2_update_stats'])->name('dashboard.2.update.stats');
    /** Channel Routes */
    Route::resource('channels', AdminChannelController::class);
    Route::prefix('channels')->name('channels.')->group(function () {
        Route::get('/change-status/{channel?}', [AdminChannelController::class, 'change_status'])->name('change.status');
    });
    /** Profile Routes */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [AdminProfileController::class, 'update'])->name('update');
        Route::post('/image-update', [AdminProfileController::class, 'image_update'])->name('image.update');
    });
    /** Admin Accounts Routes */
    Route::name('account.')->group(function () {
        Route::get('/accounts', [AdminAccountController::class, 'index'])->name('index');
        Route::prefix('/account')->group(function () {
            Route::get('/create', [AdminAccountController::class, 'create'])->name('create');
            Route::post('/store', [AdminAccountController::class, 'store'])->name('store');
            Route::get('/edit/{admin?}', [AdminAccountController::class, 'edit'])->name('edit');
            Route::post('/update/{admin?}', [AdminAccountController::class, 'update'])->name('update');
            Route::post('/update-password/{admin?}', [AdminAccountController::class, 'update_password'])->name('update.password');
            Route::get('/change-status/{admin?}', [AdminAccountController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{admin?}', [AdminAccountController::class, 'delete'])->name('delete');
        });
    });
    /** Brand Routes */
    Route::prefix('brands')->name('brand.')->group(function () {
        Route::get('/', [AdminBrandController::class, 'index'])->name('index');
        Route::get('/create', [AdminBrandController::class, 'create'])->name('create');
        Route::post('/store', [AdminBrandController::class, 'store'])->name('store');
        Route::get('/edit/{brand?}', [AdminBrandController::class, 'edit'])->name('edit');
        Route::post('/update/{brand?}', [AdminBrandController::class, 'update'])->name('update');
        Route::get('/change-status/{brand?}', [AdminBrandController::class, 'change_status'])->name('change.status');
        Route::delete('/delete/{brand?}', [AdminBrandController::class, 'delete'])->name('delete');
    });
    /** Employee Routes */
    Route::name('employee.')->group(function () {
        Route::get('/employees', [AdminEmployeeController::class, 'index'])->name('index');
        Route::prefix('employee')->group(function () {
            Route::get('/create', [AdminEmployeeController::class, 'create'])->name('create');
            Route::post('/store', [AdminEmployeeController::class, 'store'])->name('store');
            Route::get('/edit/{user?}', [AdminEmployeeController::class, 'edit'])->name('edit');
            Route::post('/update/{user?}', [AdminEmployeeController::class, 'update'])->name('update');
            Route::post('/update-password/{user?}', [AdminEmployeeController::class, 'update_password'])->name('update.password');
            Route::get('/change-status/{user?}', [AdminEmployeeController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{user?}', [AdminEmployeeController::class, 'delete'])->name('delete');
        });
    });
    /** Team Routes */
    Route::name('team.')->group(function () {
        Route::get('/teams', [AdminTeamController::class, 'index'])->name('index');
        Route::prefix('team')->group(function () {
            Route::get('/create', [AdminTeamController::class, 'create'])->name('create');
            Route::post('/store', [AdminTeamController::class, 'store'])->name('store');
            Route::get('/edit/{team?}', [AdminTeamController::class, 'edit'])->name('edit');
            Route::post('/update/{team?}', [AdminTeamController::class, 'update'])->name('update');
            Route::get('/change-status/{team?}', [AdminTeamController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{team?}', [AdminTeamController::class, 'delete'])->name('delete');
        });
    });
    /** Team Routes */
    Route::name('team-target.')->group(function () {
        Route::get('/team-targets', [AdminTeamTargetController::class, 'index'])->name('index');
        Route::prefix('team-target')->group(function () {
            Route::post('/update/{team_key?}/{month?}/{year?}', [AdminTeamTargetController::class, 'update'])->name('update');
            Route::get('/logs/{team?}', [AdminTeamTargetController::class, 'log_index'])->name('log.index');
        });
    });
    /** Invoice Routes */
    Route::name('invoice.')->group(function () {
        Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('index');
        Route::prefix('invoice')->group(function () {
            Route::get('/create', [AdminInvoiceController::class, 'create'])->name('create');
            Route::post('/store', [AdminInvoiceController::class, 'store'])->name('store');
            Route::get('/edit/{invoice?}', [AdminInvoiceController::class, 'edit'])->name('edit');
            Route::post('/update/{invoice?}', [AdminInvoiceController::class, 'update'])->name('update');
            Route::delete('/delete/{invoice?}', [AdminInvoiceController::class, 'delete'])->name('delete');
            Route::get('/payment-proofs', [AdminInvoiceController::class, 'getPaymentProof'])->name('payment_proofs');
        });
    });
    /** Sales Routes */
    Route::name('sales.')->prefix('sales')->group(function () {
        Route::get('/sales-kpi', [AdminSalesKpiController::class, 'index'])->name('kpi');
        Route::get('/sales-kpi-2', [AdminSalesKpiController::class, 'index_2'])->name('kpi.2');
        Route::get('/sales-kpi-update', [AdminSalesKpiController::class, 'index_update'])->name('kpi.update');
        Route::get('/sales-kpi-update-2', [AdminSalesKpiController::class, 'index_update_2'])->name('kpi.update.2');
    });
    /** Contacts Routes */
    Route::name('customer.')->group(function () {
        Route::name('contact.')->group(function () {
            Route::get('/customer/contacts', [AdminCustomerContactController::class, 'index'])->name('index');
            Route::get('/customer/inbox', [AdminCustomerInboxController::class, 'index'])->name('inbox');
            Route::prefix('customer/contact')->group(function () {
                Route::get('/create', [AdminCustomerContactController::class, 'create'])->name('create');
                Route::post('/store', [AdminCustomerContactController::class, 'store'])->name('store');
                Route::get('/edit/{customer_contact?}', [AdminCustomerContactController::class, 'edit'])->name('edit');
                Route::post('/update/{customer_contact?}', [AdminCustomerContactController::class, 'update'])->name('update');
                Route::name('note.')->group(function () {
                    Route::prefix('note')->group(function () {
                        Route::post('/store', [AdminCustomerNoteController::class, 'store'])->name('store');
                        Route::post('/update/{note?}', [AdminCustomerNoteController::class, 'update'])->name('update');
                        Route::delete('/delete/{note?}', [AdminCustomerNoteController::class, 'delete'])->name('delete');
                    });
                });
                Route::get('/change-status/{customer_contact?}', [AdminCustomerContactController::class, 'change_status'])->name('change.status');
                Route::delete('/delete/{customer_contact?}', [AdminCustomerContactController::class, 'delete'])->name('delete');
                Route::post('/send-email', [AdminCustomerContactController::class, 'sendEmail'])->name('send.email');

            });
        });
        /** Companies Routes */
        Route::name('company.')->group(function () {
            Route::get('customer/companies', [AdminCustomerCompanyController::class, 'index'])->name('index');
            Route::prefix('customer/company')->group(function () {
                Route::get('/create', [AdminCustomerCompanyController::class, 'create'])->name('create');
                Route::post('/store', [AdminCustomerCompanyController::class, 'store'])->name('store');
                Route::get('/edit/{customer_company?}', [AdminCustomerCompanyController::class, 'edit'])->name('edit');
                Route::post('/update/{customer_company?}', [AdminCustomerCompanyController::class, 'upd  ate'])->name('update');
                Route::get('/change-status/{customer_company?}', [AdminCustomerCompanyController::class, 'change_status'])->name('change.status');
                Route::delete('/delete/{customer_company?}', [AdminCustomerCompanyController::class, 'delete'])->name('delete');
            });
        });
    });
    /** Task Management Routes */
    Route::get('/tasks', [AdminTaskController::class, 'index'])->name('tasks.index');
    /** Lead Routes */
    Route::name('lead.')->group(function () {
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('index');
        Route::prefix('lead')->group(function () {
            Route::get('/create', [AdminLeadController::class, 'create'])->name('create');
            Route::post('/store', [AdminLeadController::class, 'store'])->name('store');
            Route::get('/edit/{lead?}', [AdminLeadController::class, 'edit'])->name('edit');
            Route::post('/update/{lead?}', [AdminLeadController::class, 'update'])->name('update');
            Route::get('/change-lead-status/{lead?}', [AdminLeadController::class, 'change_lead_status'])->name('change.lead-status');
            Route::get('/change-status/{lead?}', [AdminLeadController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{lead?}', [AdminLeadController::class, 'delete'])->name('delete');
        });
    });
    /** Lead Status Routes */
    Route::name('lead-status.')->group(function () {
        Route::get('/lead-statuses', [AdminLeadStatusController::class, 'index'])->name('index');
        Route::prefix('lead-status')->group(function () {
            Route::get('/create', [AdminLeadStatusController::class, 'create'])->name('create');
            Route::post('/store', [AdminLeadStatusController::class, 'store'])->name('store');
            Route::get('/edit/{leadStatus?}', [AdminLeadStatusController::class, 'edit'])->name('edit');
            Route::post('/update/{leadStatus?}', [AdminLeadStatusController::class, 'update'])->name('update');
            Route::get('/change-status/{leadStatus?}', [AdminLeadStatusController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{leadStatus?}', [AdminLeadStatusController::class, 'delete'])->name('delete');
        });
    });
    /** Payment Routes */
    Route::prefix('payments')->name('payment.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('/create', [AdminPaymentController::class, 'create'])->name('create');
        Route::post('/store', [AdminPaymentController::class, 'store'])->name('store');
        Route::get('/edit/{payment?}', [AdminPaymentController::class, 'edit'])->name('edit');
        Route::post('/update/{payment?}', [AdminPaymentController::class, 'update'])->name('update');
        Route::get('payment-filter', [AdminPaymentController::class, 'filterByBrandTeam'])->name('filter');
    });
    /** Payment Transaction Logs Route */
    Route::get('payment-transaction-logs', [AdminPaymentTransactionLogController::class, 'getLogs'])->name('payment-transaction-logs');
    /** CustomerContact Contacts Routes */
    Route::name('client.contact.')->group(function () {
        Route::get('/client/contacts', [AdminClientContactController::class, 'index'])->name('index');
        Route::prefix('client/contact')->group(function () {
            Route::get('/companies/{client_contact?}', [AdminClientContactController::class, 'companies'])->name('companies');
            Route::get('/create', [AdminClientContactController::class, 'create'])->name('create');
            Route::post('/store', [AdminClientContactController::class, 'store'])->name('store');
            Route::get('/edit/{client_contact?}', [AdminClientContactController::class, 'edit'])->name('edit');
            Route::post('/update/{client_contact?}', [AdminClientContactController::class, 'update'])->name('update');
            Route::get('/change-status/{client_contact?}', [AdminClientContactController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{client_contact?}', [AdminClientContactController::class, 'delete'])->name('delete');
        });
    });
    /** CustomerContact Companies Routes */
    Route::name('client.company.')->group(function () {
        Route::get('/client/companies', [AdminClientCompanyController::class, 'index'])->name('index');
        Route::prefix('client/company')->group(function () {
            Route::get('/create', [AdminClientCompanyController::class, 'create'])->name('create');
            Route::post('/store', [AdminClientCompanyController::class, 'store'])->name('store');
            Route::get('/edit/{client_company?}', [AdminClientCompanyController::class, 'edit'])->name('edit');
            Route::post('/update/{client_company?}', [AdminClientCompanyController::class, 'update'])->name('update');
            Route::get('/change-status/{client_company?}', [AdminClientCompanyController::class, 'change_status'])->name('change.status');
            Route::delete('/delete/{client_company?}', [AdminClientCompanyController::class, 'delete'])->name('delete');
        });
    });
    /** Payment Merchant Routes */
    Route::name('client.account.')->group(function () {
        Route::get('/client/accounts', [AdminPaymentMerchantController::class, 'index'])->name('index');
        Route::prefix('client/account')->group(function () {
            Route::get('/create', [AdminPaymentMerchantController::class, 'create'])->name('create');
            Route::post('/store', [AdminPaymentMerchantController::class, 'store'])->name('store');
            Route::get('/edit/{client_account?}', [AdminPaymentMerchantController::class, 'edit'])->name('edit');
            Route::post('/update/{client_account?}', [AdminPaymentMerchantController::class, 'update'])->name('update');
            Route::get('/change-status/{client_account?}', [AdminPaymentMerchantController::class, 'change_status'])->name('change.status');
            Route::get('/by-brand/{brand_key?}/{currency?}', [AdminPaymentMerchantController::class, 'by_brand'])->name('by.brand');
            Route::delete('/delete/{client_account?}', [AdminPaymentMerchantController::class, 'delete'])->name('delete');
        });
    });
    Route::prefix('activity-logs')->name('activity-log.')->group(function () {
        Route::get('/', [AdminActivityLogController::class, 'index'])->name('index');
    });
    Route::post('/save-settings', [AdminSettingController::class, 'saveSettings'])->name('save.settings');

});
