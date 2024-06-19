<?php

use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\Switcherpage;
use App\Http\Controllers\Web\CountryController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CurrencyController;
use App\Http\Controllers\Web\IndustryController;
use App\Http\Controllers\Web\SupplierController;
use App\Http\Controllers\Web\DepartmentController;
use App\Http\Controllers\Web\SupplierAddressesController;

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
Route::get('/', function () {
    return view('layouts.index');
})->name('home');

Route::group(['prefix' => 'dashboard', 'middleware' => 'guest'], function () {
    Route::resource('currencies', CurrencyController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('industries', IndustryController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('supplier_addresses', SupplierAddressesController::class);
});