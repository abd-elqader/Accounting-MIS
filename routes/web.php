<?php

use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\Customer;
use App\Http\Controllers\Web\TaxController;
use App\Http\Livewire\Dashboard\Switcherpage;
use App\Http\Controllers\Web\BranchController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\CountryController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CurrencyController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\IndustryController;
use App\Http\Controllers\Web\SupplierController;
use App\Http\Controllers\Web\DepartmentController;
use App\Http\Controllers\Web\BranchAddressController;
use App\Http\Controllers\Web\CustomerAddressController;
use App\Http\Controllers\Web\CustomerContactController;
use App\Http\Controllers\Web\SupplierContactController;
use App\Http\Controllers\Web\SupplierAddressesController;
use App\Http\Controllers\Web\CustomerProductInvoiceController;
use App\Http\Controllers\Web\CustomerServiceInvoiceController;
use App\Http\Controllers\Web\SupplierProductInvoiceController;
use App\Http\Controllers\Web\SupplierServiceInvoiceController;
use App\Http\Controllers\Web\CustomerServiceInvoiceTaxController;
use App\Http\Controllers\Web\SupplierProductInvoiceTaxController;
use App\Http\Controllers\Web\SupplierServiceInvoiceTaxController;
use App\Http\Controllers\Web\CustomerServiceInvoiceItemController;
use App\Http\Controllers\Web\SupplierProductInvoiceItemController;
use App\Http\Controllers\Web\SupplierServiceInvoiceItemController;
use App\Http\Controllers\Web\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.index');
// })->name('home');

Route::group(['prefix' => 'authentication', 'middleware' => 'guest'], function () {
    Route::view('login', 'layouts.dashboard.auth.login')->name('loginView');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::get('/', function () {
    return view('livewire.index');
})->middleware('auth')->name('home');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('currencies', CurrencyController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('industries', IndustryController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('services', ServiceController::class);
    // start suppliers
    Route::resource('suppliers', SupplierController::class);
    Route::resource('supplier_addresses', SupplierAddressesController::class);
    Route::resource('supplier_contacts', SupplierContactController::class);
    Route::resource('supplier_service_invoices', SupplierServiceInvoiceController::class);
    Route::resource('supplier_product_invoices', SupplierProductInvoiceController::class);
    // end suppliers

    // start customers
    Route::resource('customers', CustomerController::class);
    Route::resource('customer_addresses', CustomerAddressController::class);
    Route::resource('customer_contacts', CustomerContactController::class);
    Route::resource('customer_service_invoices', CustomerServiceInvoiceController::class);
    Route::resource('customer_product_invoices', CustomerProductInvoiceController::class);
    // end customers

    Route::resource('taxes', TaxController::class);

    // start branch
    Route::resource('branches', BranchController::class);
    Route::resource('branch_addresses', BranchAddressController::class);

    // end branch
});



Route::fallback(function () {
    return view('layouts.dashboard.error-pages.error404');
});
