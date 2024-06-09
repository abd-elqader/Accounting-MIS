<?php

use App\Http\Controllers\Web\CurrencyController;
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
Route::get('/', function () {
    return view('layouts.index');
})->name('home');

Route::group(['prefix' => 'dashboard', 'middleware' => 'guest'], function () {
    Route::resource('currencies', CurrencyController::class);
});