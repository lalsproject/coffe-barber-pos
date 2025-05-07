<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CapsterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportCapsterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionCapsterController;
use App\Models\TransactionCapster;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) return redirect('/home');
    return view('auth.login');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

// Admin User
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // User Management
    Route::get('users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');

    Route::get('capsters/index', [CapsterController::class, 'index'])->name('capsters.index');
    Route::get('capsters/create', [CapsterController::class, 'create'])->name('capsters.create');
    Route::get('capsters/edit/{id}', [CapsterController::class, 'edit'])->name('capsters.edit');
    Route::patch('capsters/update/{id}', [CapsterController::class, 'update'])->name('capsters.update');
    Route::post('capsters/store', [CapsterController::class, 'store'])->name('capsters.store');


    Route::get('services/index', [ServicesController::class, 'index'])->name('services.index');
    Route::get('services/create', [ServicesController::class, 'create'])->name('services.create');
    Route::get('services/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');
    Route::patch('services/update/{id}', [ServicesController::class, 'update'])->name('services.update');
    Route::post('services/store', [ServicesController::class, 'store'])->name('services.store');
});

Route::group(['middleware' => ['auth', 'role:admin|purchasing']], function () {
    // Master
    // Suppliers
    Route::get('suppliers/index', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::patch('suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::get('suppliers/import', [SupplierController::class, 'import'])->name('suppliers.import');
    Route::post('suppliers/import/process', [SupplierController::class, 'importProcess'])->name('suppliers.importProcess');
    Route::delete('suppliers/delete/{id}', [SupplierController::class, 'delete'])->name('suppliers.delete');
});

Route::group(['middleware' => ['auth', 'role:admin|sales|delivery|finance']], function () {
    // Master
    // Customers
    Route::get('customers/index', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::patch('customers/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::post('customers/import/process', [CustomerController::class, 'importProcess'])->name('customers.importProcess');
    Route::delete('customers/delete/{id}', [CustomerController::class, 'delete'])->name('customers.delete');
});

Route::group(['middleware' => ['auth', 'role:admin|sales|purchasing|inventory|cashier']], function () {
    /* Master */
    // Brand
    Route::get('brands/index', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::get('brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::patch('brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::post('brands/store', [BrandController::class, 'store'])->name('brands.store');

    // Categories
    Route::get('categories/index', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

    // Units
    Route::get('units/index', [UnitController::class, 'index'])->name('units.index');
    Route::get('units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('units/store', [UnitController::class, 'store'])->name('units.store');
    Route::get('units/edit/{id}', [UnitController::class, 'edit'])->name('units.edit');
    Route::patch('units/update/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('units/delete/{id}', [UnitController::class, 'delete'])->name('units.delete');

    // Products
    Route::get('products/index', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::patch('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::delete('products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
    Route::get('products/list', [ProductController::class, 'list'])->name('products.list');

    // Purchase Orders
    Route::get('purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchase-orders.create');
    Route::post('purchase-orders/store', [PurchaseOrderController::class, 'store'])->name('purchase-orders.store');
    Route::patch('purchase-orders/update/{id}', [PurchaseOrderController::class, 'update'])->name('purchase-orders.update');
    Route::get('purchase-orders/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('purchase-orders.edit');
    Route::get('purchase-orders/list-approval', [PurchaseOrderController::class, 'listApproval'])->name('purchase-orders.list-approval');
    Route::get('purchase-orders/show-approval', [PurchaseOrderController::class, 'showApproval'])->name('purchase-orders.show-approval');
    Route::get('purchase-orders/detail-approval/{id}', [PurchaseOrderController::class, 'detailApproval'])->name('purchase-orders.detail-approval');
    Route::get('purchase-orders/approval-form/{id}', [PurchaseOrderController::class, 'approvalForm'])->name('purchase-orders.approval-form');
    Route::patch('purchase-orders/add-stock/{id}', [PurchaseOrderController::class, 'addInventory'])->name('purchase-orders.add-inventory');
    Route::patch('purchase-orders/approved/{id}', [PurchaseOrderController::class, 'approved'])->name('purchase-orders.approved');
    Route::patch('purchase-orders/export/{id}', [PurchaseOrderController::class, 'exportPurchaseOrder'])->name('purchase-order.export-purchase-order');
    Route::get('purchase-orders/create-approval/{id}/{supplierId}', [PurchaseOrderController::class, 'createApprovalWithSoNumber'])->name('purchase-orders.createApprovalWithSoNumber');
    Route::post('purchase-orders/approved-with-sonumber/{id}', [PurchaseOrderController::class, 'approvedWithSoNumber'])->name('purchase-orders.approvedWithSoNumber');

    Route::resource('branch', BranchController::class);
    Route::name('branch.')->prefix('branch')->group(function () {
        Route::get('/branch', [BranchController::class, 'index'])->name('branch.index');
    });
});

// Profile Management
Route::group(['middleware' => ['auth']], function () {
    Route::patch('users/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::get('users/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::get('users/change-profile', [UserController::class, 'changeProfile'])->name('users.change-profile');
    Route::patch('users/update-profile', [UserController::class, 'updateProfile'])->name('users.update-profile');
});

Route::group(['middleware' => ['auth', 'role:admin|cashier']], function () {
    Route::get('/transaction/export/{transaction_id}', [ReportController::class, 'generateTransactionPdf'])->name('transaction.export-pdf');
    Route::get('/report/index', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/list', [ReportController::class, 'list'])->name('report.list');
    Route::get('/report/today', [ReportController::class, 'todayReport'])->name('report.today');
    Route::get('/report/weekly', [ReportController::class, 'weeklyReport'])->name('report.weekly');
    Route::get('/report/monthly', [ReportController::class, 'monthlyReport'])->name('report.monthly');
    Route::get('/report/search', [ReportController::class, 'search'])->name('report.search');
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');

    Route::get('/transaction/capster/export/{transaction_id}', [ReportCapsterController::class, 'generateTransactionPdf'])->name('capster.export-pdf');
    Route::get('/report/capster/index', [ReportCapsterController::class, 'index'])->name('capster.report.index');
    Route::get('/report/capster/list', [ReportCapsterController::class, 'list'])->name('capster.report.list');
    Route::get('/report/capster/today', [ReportCapsterController::class, 'todayReport'])->name('capster.report.today');
    Route::get('/report/capster/weekly', [ReportCapsterController::class, 'weeklyReport'])->name('capster.report.weekly');
    Route::get('/report/capster/monthly', [ReportCapsterController::class, 'monthlyReport'])->name('capster.report.monthly');
    Route::get('/report/capster/search', [ReportCapsterController::class, 'search'])->name('capster.report.search');


    Route::get('/transaction/search', [TransactionController::class, 'productFilter'])->name('transaction.search');
    Route::post('/transaction/submit', [TransactionController::class, 'onTransactionSubmited'])->name('transaction.submit');
    Route::post('/transaction/submit/capster', [TransactionCapsterController::class, 'onTransactionCapsterSubmited'])->name('transaction.submit.capster');
    Route::post('/transaction/shown', [TransactionController::class, 'onTransactionShown'])->name('transaction.shown');
    Route::post('/transaction/submit/deposit', [TransactionController::class, 'onDepositSubmit'])->name('transaction.deposit');
    Route::post('/transaction/submit/closing/store', [TransactionController::class, 'onCloseStoreSubmit'])->name('transaction.close-store');
    Route::get('/transaction/dialog', [TransactionController::class, 'onShowTransactionDetail'])->name('transaction.dialog');
    Route::get('/transaction/home', [HomeController::class, 'onFilterTransaction'])->name('transaction.home');
    Route::get('transaction/capsters/index', [TransactionCapsterController::class, 'index'])->name('transaction.capsters.index');
    Route::get('transaction/capsters/create', [TransactionCapsterController::class, 'create'])->name('transaction.capsters.create');
    Route::get('transaction/capsters/edit/{id}', [TransactionCapsterController::class, 'edit'])->name('transaction.capsters.edit');
    Route::patch('transaction/capsters/update/{id}', [TransactionCapsterController::class, 'update'])->name('transaction.capsters.update');
    Route::post('transaction/capsters/store', [TransactionCapsterController::class, 'store'])->name('transaction.capsters.store');
    Route::get('/transaction/capster/dialog', [TransactionCapsterController::class, 'onShowTransactionDetail'])->name('transaction.capster.dialog');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('settings/index', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
