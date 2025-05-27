<?php

use App\Http\Controllers\Admin\{DashboardController as AdminDashboardController,
    AccountController as AdminAccountController,
    ActivityLogController as AdminActivityLogController,
    BrandController as AdminBrandController,
    Client\CompanyController as AdminClientCompanyController,
    Client\ContactController as AdminClientContactController,
    Client\PaymentMerchantController as AdminPaymentMerchantController,
    Customer\CompanyController as AdminCustomerCompanyController,
    Customer\ContactController as AdminCustomerContactController,
    Customer\NoteController as AdminCustomerNoteController,
    EmployeeController as AdminEmployeeController,
    InvoiceController as AdminInvoiceController,
    LeadController as AdminLeadController,
    LeadStatusController as AdminLeadStatusController,
    PaymentTransactionLogController as AdminPaymentTransactionLogController,
    PaymentController as AdminPaymentController,
    ProfileController as AdminProfileController,
    SettingController as AdminSettingController,
    TeamController as AdminTeamController,
    TeamTargetController as AdminTeamTargetController
};
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

require __DIR__ . '/admin-auth.php';
Route::middleware(['auth:admin', 'verified:admin', 'throttle:60,1'])->prefix('admin')->name('admin.')->group(function () {

    Route::post('/check-channels', function (Request $request) {
        $authUser = Auth::user();
        $tableToCheck = 'admins';
        $allChannels = config('channels');
        $validChannels = [];
        $host = request()->getHost();
        $port = request()->getPort();
        $fullCurrentDomain = $port && $port != 80 && $port != 443 ? "$host:$port" : $host;
        // Get current path for full redirection
        $currentPath = $request->header('referer')
            ? parse_url($request->header('referer'), PHP_URL_PATH)
            : '/';
        foreach ($allChannels as $domain => $channelName) {
            if ($domain === $fullCurrentDomain) {
                continue;
            }
            try {
                $isLocal = str_contains($domain, 'localhost');
                $ssl = $isLocal ? 'http' : 'https';
                $prefix = app()->environment('development') && !$isLocal ? '/crm-development' : '';
                $url = "{$ssl}://{$domain}{$prefix}/api/check-user";
                $response = Http::timeout(3)->post($url, [
                    'email' => $authUser->email,
                    'table' => $tableToCheck
                ]);
                if ($response->ok() && $response->json('exists')) {
                    $validChannels[] = [
                        'domain' => $domain,
                        'name' => $channelName,
                        'url' => "{$ssl}://{$domain}{$prefix}{$currentPath}", // full URL to be used in <a href>
                    ];
                }

            } catch (\Exception $e) {
                Log::error("Channel check failed for {$domain}: " . $e->getMessage());
            }
        }
        return response()->json([
            'validChannels' => $validChannels,
            'authUser' => $authUser,
            'tableToCheck' => $tableToCheck,
            'allChannels' => $allChannels,
            'host' => $host,
            'port' => $port,
            'fullCurrentDomain' => $fullCurrentDomain,
            'currentPath' => $currentPath,
            'domain' => $domain,
            'isLocal' => $isLocal,
            'ssl' => $ssl,
            'prefix' => $prefix,
            'url' => $url,
            'response' => $response,
            'response_ok' => $response->ok(),
            'response_json' => $response->json('exists'),
        ]);
    })->name('check.channels');
    Route::get('/dashboard', [AdminDashboardController::class, 'index_1'])->name('dashboard');
    Route::get('/dashboard-2', [AdminDashboardController::class, 'index_2'])->name('dashboard.2');
    Route::get('/dashboard-2-update-stats', [AdminDashboardController::class, 'index_2_update_stats'])->name('dashboard.2.update.stats');
    /** Profile Routes */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
        //Route::post('/update', [AdminProfileController::class, 'update'])->name('update');
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
    /** Contacts Routes */
    Route::name('customer.')->group(function () {
        Route::name('contact.')->group(function () {
            Route::get('/customer/contacts', [AdminCustomerContactController::class, 'index'])->name('index');
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
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('/create', [AdminPaymentController::class, 'create'])->name('create');
        Route::post('/store', [AdminPaymentController::class, 'store'])->name('store');
        Route::get('/edit/{payment?}', [AdminPaymentController::class, 'edit'])->name('edit');
        Route::post('/update/{payment?}', [AdminPaymentController::class, 'update'])->name('update');
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
            Route::get('/by-brand/{brand_key?}', [AdminPaymentMerchantController::class, 'by_brand'])->name('by.brand');
            Route::delete('/delete/{client_account?}', [AdminPaymentMerchantController::class, 'delete'])->name('delete');
        });
    });
    Route::prefix('activity-logs')->name('activity-log.')->group(function () {
        Route::get('/', [AdminActivityLogController::class, 'index'])->name('index');
    });
    Route::post('/save-settings', [AdminSettingController::class, 'saveSettings'])->name('save.settings');
});
