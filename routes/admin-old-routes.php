<?php

use App\Http\Controllers\AdminOld\{
    AccountController as AdminAccountController,
    CompanyController as AdminCompanyController,
    ProfileController as AdminProfileController,
    BrandController as AdminBrandController,
    EmployeeController as AdminEmployeeController,
    TeamController as AdminTeamController,
    InvoiceController as AdminInvoiceController,
    ClientController as AdminClientController,
    LeadController as AdminLeadController,
    LeadStatusController as AdminLeadStatusController,
    PaymentController as AdminPaymentController,
    PaymentMerchantController as AdminPaymentMerchantController
};
use Illuminate\Support\Facades\Route;
//
//
//require __DIR__ . '/admin-auth.php';
//
//Route::middleware(['auth:admin'])->prefix('admin-old')->name('admin.')->group(function () {
//
//    /** Profile Routes */
//    Route::prefix('profile')->name('profile.')->group(function () {
//        Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
//        Route::post('/update', [AdminProfileController::class, 'update'])->name('update');
//        Route::post('/image-update', [AdminProfileController::class, 'image_update'])->name('image.update');
//    });
//
//    /** Admin Accounts Routes */
//    Route::name('account.')->group(function () {
//        Route::get('/accounts', [AdminAccountController::class, 'index'])->name('index');
//        Route::prefix('/account')->group(function () {
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
//        Route::get('/', [AdminBrandController::class, 'index'])->name('index');
//        Route::get('/create', [AdminBrandController::class, 'create'])->name('create');
//        Route::post('/store', [AdminBrandController::class, 'store'])->name('store');
//        Route::get('/edit/{brand?}', [AdminBrandController::class, 'edit'])->name('edit');
//        Route::post('/update/{brand?}', [AdminBrandController::class, 'update'])->name('update');
//        Route::get('/change-status/{brand?}', [AdminBrandController::class, 'change_status'])->name('change.status');
//        Route::delete('/delete/{brand?}', [AdminBrandController::class, 'delete'])->name('delete');
//    });
//
//    /** Employee Routes */
//    Route::name('employee.')->group(function () {
//        Route::get('/employees', [AdminEmployeeController::class, 'index'])->name('index');
//        Route::prefix('employee')->group(function () {
//            Route::get('/create', [AdminEmployeeController::class, 'create'])->name('create');
//            Route::post('/store', [AdminEmployeeController::class, 'store'])->name('store');
//            Route::get('/edit/{user?}', [AdminEmployeeController::class, 'edit'])->name('edit');
//            Route::post('/update/{user?}', [AdminEmployeeController::class, 'update'])->name('update');
//            Route::get('/change-status/{user?}', [AdminEmployeeController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{user?}', [AdminEmployeeController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Team Routes */
//    Route::name('team.')->group(function () {
//        Route::get('/teams', [AdminTeamController::class, 'index'])->name('index');
//        Route::prefix('team')->group(function () {
//            Route::get('/create', [AdminTeamController::class, 'create'])->name('create');
//            Route::post('/store', [AdminTeamController::class, 'store'])->name('store');
//            Route::get('/edit/{team?}', [AdminTeamController::class, 'edit'])->name('edit');
//            Route::post('/update/{team?}', [AdminTeamController::class, 'update'])->name('update');
//            Route::get('/change-status/{team?}', [AdminTeamController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{team?}', [AdminTeamController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Invoice Routes */
//    Route::name('invoice.')->group(function () {
//        Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('index');
//        Route::prefix('invoice')->group(function () {
//            Route::get('/create', [AdminInvoiceController::class, 'create'])->name('create');
//            Route::post('/store', [AdminInvoiceController::class, 'store'])->name('store');
//            Route::get('/edit/{invoice?}', [AdminInvoiceController::class, 'edit'])->name('edit');
//            Route::post('/update/{invoice?}', [AdminInvoiceController::class, 'update'])->name('update');
//            Route::delete('/delete/{invoice?}', [AdminInvoiceController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Companies Routes */
//    Route::prefix('companies')->name('company.')->group(function () {
//        Route::get('/', [AdminCompanyController::class, 'index'])->name('index');
//    });
//
//    /** Contacts Routes */
//    Route::name('contact.')->group(function () {
//        Route::get('/contacts', [AdminClientController::class, 'index'])->name('index');
//        Route::prefix('contact')->group(function () {
//            Route::get('/create', [AdminClientController::class, 'create'])->name('create');
//            Route::post('/store', [AdminClientController::class, 'store'])->name('store');
//            Route::get('/edit/{client?}', [AdminClientController::class, 'edit'])->name('edit');
//            Route::post('/update/{client?}', [AdminClientController::class, 'update'])->name('update');
//            Route::get('/change-status/{team?}', [AdminClientController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{client?}', [AdminClientController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Lead Routes */
//    Route::name('lead.')->group(function () {
//        Route::get('/leads', [AdminLeadController::class, 'index'])->name('index');
//        Route::prefix('lead')->group(function () {
//            Route::get('/create', [AdminLeadController::class, 'create'])->name('create');
//            Route::post('/store', [AdminLeadController::class, 'store'])->name('store');
//            Route::get('/edit/{lead?}', [AdminLeadController::class, 'edit'])->name('edit');
//            Route::post('/update/{lead?}', [AdminLeadController::class, 'update'])->name('update');
//            Route::get('/change-lead-status/{lead?}', [AdminLeadController::class, 'change_lead_status'])->name('change.lead-status');
//            Route::get('/change-status/{lead?}', [AdminLeadController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{lead?}', [AdminLeadController::class, 'delete'])->name('delete');
//        });
//    });
//    /** Lead Status Routes */
//    Route::name('lead-status.')->group(function () {
//        Route::get('/lead-statuses', [AdminLeadStatusController::class, 'index'])->name('index');
//        Route::prefix('lead-status')->group(function () {
//            Route::get('/create', [AdminLeadStatusController::class, 'create'])->name('create');
//            Route::post('/store', [AdminLeadStatusController::class, 'store'])->name('store');
//            Route::get('/edit/{leadStatus?}', [AdminLeadStatusController::class, 'edit'])->name('edit');
//            Route::post('/update/{leadStatus?}', [AdminLeadStatusController::class, 'update'])->name('update');
//            Route::get('/change-status/{leadStatus?}', [AdminLeadStatusController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{leadStatus?}', [AdminLeadStatusController::class, 'delete'])->name('delete');
//        });
//    });
//
//    /** Payment Routes */
//    Route::prefix('payment')->name('payment.')->group(function () {
//        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
//        Route::get('/create', [AdminPaymentController::class, 'create'])->name('create');
//        Route::post('/store', [AdminPaymentController::class, 'store'])->name('store');
//        Route::get('/edit/{payment?}', [AdminPaymentController::class, 'edit'])->name('edit');
//        Route::post('/update/{payment?}', [AdminPaymentController::class, 'update'])->name('update');
//    });
//
//    /** Payment Merchant Routes */
//    Route::name('client.')->group(function () {
//        Route::get('/clients', [AdminPaymentMerchantController::class, 'index'])->name('index');
//        Route::prefix('client')->group(function () {
//            Route::get('/create', [AdminPaymentMerchantController::class, 'create'])->name('create');
//            Route::post('/store', [AdminPaymentMerchantController::class, 'store'])->name('store');
//            Route::get('/edit/{client?}', [AdminPaymentMerchantController::class, 'edit'])->name('edit');
//            Route::post('/update/{client?}', [AdminPaymentMerchantController::class, 'update'])->name('update');
//            Route::get('/change-status/{client?}', [AdminPaymentMerchantController::class, 'change_status'])->name('change.status');
//            Route::delete('/delete/{client?}', [AdminPaymentMerchantController::class, 'delete'])->name('delete');
//        });
//    });
//});
