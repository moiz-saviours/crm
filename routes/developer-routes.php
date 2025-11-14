<?php
//
//use App\Http\Controllers\Developer\{
//    AdminAccountController as AdminAccountController,
//    AccountController as DeveloperAccountController,
//    ProfileController as DeveloperProfileController,
//    BrandController as DeveloperBrandController,
//    EmployeeController as DeveloperEmployeeController,
//    TeamController as DeveloperTeamController,
//    InvoiceController as DeveloperInvoiceController,
//    ClientController as DeveloperClientController,
//    LeadController as DeveloperLeadController,
//    LeadStatusController as DeveloperLeadStatusController,
//    PaymentController as DeveloperPaymentController,
//    PaymentMerchantController as DeveloperPaymentMerchantController};
//use Illuminate\Support\Facades\Route;
//
//
//require __DIR__ . '/developer-auth.php';
//
//Route::middleware(['auth:developer'])->prefix('developer')->name('developer.')->group(function () {
//
//    /** Profile Routes */
//    Route::prefix('profile')->name('profile.')->group(function () {
//        Route::get('/', [DeveloperProfileController::class, 'edit'])->name('edit');
//        Route::post('/update', [DeveloperProfileController::class, 'update'])->name('update');
//        Route::post('/image-update', [DeveloperProfileController::class, 'image_update'])->name('image.update');
//    });
//    /** Developer Accounts Routes */
//    Route::name('account.')->group(function () {
//        Route::get('/accounts', [DeveloperAccountController::class, 'index'])->name('index');
//        Route::prefix('account')->group(function () {
//            Route::get('/create', [DeveloperAccountController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperAccountController::class, 'store'])->name('store');
//            Route::get('/edit/{developer?}', [DeveloperAccountController::class, 'edit'])->name('edit');
//            Route::post('/update/{developer?}', [DeveloperAccountController::class, 'update'])->name('update');
//            Route::get('/change-status/{developer?}', [DeveloperAccountController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{developer?}', [DeveloperAccountController::class, 'delete'])->name('delete');
//        });
//    });
//    /** Admin Accounts Routes */
//    Route::name('admin.account.')->group(function () {
//        Route::get('/admin-accounts', [AdminAccountController::class, 'index'])->name('index');
//        Route::prefix('/admin-account')->group(function () {
//            Route::get('/create', [AdminAccountController::class, 'create'])->name('create');
//            Route::post('/store', [AdminAccountController::class, 'store'])->name('store');
//            Route::get('/edit/{admin?}', [AdminAccountController::class, 'edit'])->name('edit');
//            Route::post('/update/{admin?}', [AdminAccountController::class, 'update'])->name('update');
//            Route::get('/change-status/{admin?}', [AdminAccountController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{admin?}', [AdminAccountController::class, 'delete'])->name('delete');
//        });
//    });
//    /** Brand Routes */
//    Route::prefix('brands')->name('brand.')->group(function () {
//        Route::get('/', [DeveloperBrandController::class, 'index'])->name('index');
//        Route::get('/create', [DeveloperBrandController::class, 'create'])->name('create');
//        Route::post('/store', [DeveloperBrandController::class, 'store'])->name('store');
//        Route::get('/edit/{brand?}', [DeveloperBrandController::class, 'edit'])->name('edit');
//        Route::post('/update/{brand?}', [DeveloperBrandController::class, 'update'])->name('update');
//        Route::get('/change-status/{brand?}', [DeveloperBrandController::class, 'change_status'])->name('change.status');
//        Route::delete('/delete/{brand?}', [DeveloperBrandController::class, 'delete'])->name('delete');
//    });
//
//    /** Employee Routes */
//    Route::name('employee.')->group(function () {
//        Route::get('/employees', [DeveloperEmployeeController::class, 'index'])->name('index');
//        Route::prefix('employee')->group(function () {
//            Route::get('/create', [DeveloperEmployeeController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperEmployeeController::class, 'store'])->name('store');
//            Route::get('/edit/{user?}', [DeveloperEmployeeController::class, 'edit'])->name('edit');
//            Route::post('/update/{user?}', [DeveloperEmployeeController::class, 'update'])->name('update');
//            Route::get('/change-status/{user?}', [DeveloperEmployeeController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{user?}', [DeveloperEmployeeController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Team Routes */
//    Route::name('team.')->group(function () {
//        Route::get('/teams', [DeveloperTeamController::class, 'index'])->name('index');
//        Route::prefix('team')->group(function () {
//            Route::get('/create', [DeveloperTeamController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperTeamController::class, 'store'])->name('store');
//            Route::get('/edit/{team?}', [DeveloperTeamController::class, 'edit'])->name('edit');
//            Route::post('/update/{team?}', [DeveloperTeamController::class, 'update'])->name('update');
//            Route::get('/change-status/{team?}', [DeveloperTeamController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{team?}', [DeveloperTeamController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Invoice Routes */
//    Route::name('invoice.')->group(function () {
//        Route::get('/invoices', [DeveloperInvoiceController::class, 'index'])->name('index');
//        Route::prefix('invoice')->group(function () {
//            Route::get('/create', [DeveloperInvoiceController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperInvoiceController::class, 'store'])->name('store');
//            Route::get('/edit/{invoice?}', [DeveloperInvoiceController::class, 'edit'])->name('edit');
//            Route::post('/update/{invoice?}', [DeveloperInvoiceController::class, 'update'])->name('update');
//            Route::delete('/delete/{invoice?}', [DeveloperInvoiceController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** CustomerContact Routes */
//    Route::name('client.')->group(function () {
//        Route::get('/clients', [DeveloperClientController::class, 'index'])->name('index');
//        Route::prefix('client')->group(function () {
//            Route::get('/create', [DeveloperClientController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperClientController::class, 'store'])->name('store');
//            Route::get('/edit/{client?}', [DeveloperClientController::class, 'edit'])->name('edit');
//            Route::post('/update/{client?}', [DeveloperClientController::class, 'update'])->name('update');
//            Route::get('/change-status/{team?}', [DeveloperClientController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{client?}', [DeveloperClientController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Lead Routes */
//    Route::name('lead.')->group(function () {
//        Route::get('/leads', [DeveloperLeadController::class, 'index'])->name('index');
//        Route::prefix('lead')->group(function () {
//            Route::get('/create', [DeveloperLeadController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperLeadController::class, 'store'])->name('store');
//            Route::get('/edit/{lead?}', [DeveloperLeadController::class, 'edit'])->name('edit');
//            Route::post('/update/{lead?}', [DeveloperLeadController::class, 'update'])->name('update');
//            Route::get('/change-lead-status/{lead?}', [DeveloperLeadController::class, 'change_lead_status'])->name('change.lead-status');
//            Route::get('/change-status/{lead?}', [DeveloperLeadController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{lead?}', [DeveloperLeadController::class, 'delete'])->name('delete');
//        });
//    });
//    /** Lead Status Routes */
//    Route::name('lead-status.')->group(function () {
//        Route::get('/lead-statuses', [DeveloperLeadStatusController::class, 'index'])->name('index');
//        Route::prefix('lead-status')->group(function () {
//            Route::get('/create', [DeveloperLeadStatusController::class, 'create'])->name('create');
//            Route::post('/store', [DeveloperLeadStatusController::class, 'store'])->name('store');
//            Route::get('/edit/{leadStatus?}', [DeveloperLeadStatusController::class, 'edit'])->name('edit');
//            Route::post('/update/{leadStatus?}', [DeveloperLeadStatusController::class, 'update'])->name('update');
//            Route::get('/change-status/{leadStatus?}', [DeveloperLeadStatusController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{leadStatus?}', [DeveloperLeadStatusController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Payment Routes */
//    Route::prefix('payment')->name('payment.')->group(function () {
//        Route::get('/', [DeveloperPaymentController::class, 'index'])->name('index');
//        Route::get('/create', [DeveloperPaymentController::class, 'create'])->name('create');
//        Route::post('/store', [DeveloperPaymentController::class, 'store'])->name('store');
//        Route::get('/edit/{payment?}', [DeveloperPaymentController::class, 'edit'])->name('edit');
//        Route::post('/update/{payment?}', [DeveloperPaymentController::class, 'update'])->name('update');
//    });
//
//    /** Payment Merchant Routes */
//    Route::prefix('payment-merchant')->name('payment.merchant.')->group(function () {
//        Route::get('/', [DeveloperPaymentMerchantController::class, 'index'])->name('index');
//        Route::get('/create', [DeveloperPaymentMerchantController::class, 'create'])->name('create');
//        Route::post('/store', [DeveloperPaymentMerchantController::class, 'store'])->name('store');
//        Route::post('/edit', [DeveloperPaymentMerchantController::class, 'edit'])->name('edit');
//        Route::post('/update', [DeveloperPaymentMerchantController::class, 'update'])->name('update');
//    });
//});
