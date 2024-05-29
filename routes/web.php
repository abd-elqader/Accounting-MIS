<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\Switcherpage;

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

Route::group(['prefix' => 'dashboard', 'middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('livewire.dashboard.index');
    })->name('home');

    Route::view('customers', 'viewName');
    Route::view('servicesAndProducts', 'viewName');
    Route::view('suppliers', 'viewName');
    Route::view('accounting', 'viewName');
    Route::view('Reports', 'viewName');
    Route::view('usersAndPermissions', 'viewName');
    Route::get('swithcer', Switcherpage::class);

});