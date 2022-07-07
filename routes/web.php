<?php

use App\Http\Controllers\AdsData;
use App\Http\Controllers\Page;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAdsApi;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/clients', [Page::class, 'clients'])->name('page.clients');
    Route::get('/clients-add', [Page::class, 'clientsAdd'])->name('page.clients.add');
    Route::post('/clients-add', [Page::class, 'clientsStore'])->name('page.clients.store');
    Route::get('/clients-edit/{id}', [Page::class, 'clientsEdit'])->name('page.clients.edit');
    Route::post('/clients-update', [Page::class, 'clientsUpdate'])->name('page.clients.update');
    Route::get('/reset-password', [Page::class, 'resetPassword'])->name('page.reset.psw');

    Route::get('/stats/account/{range?}/{client?}', [AdsData::class, 'account'])->name('stats.account');
    Route::get('/stats/keywords/{range?}/{client?}', [AdsData::class, 'keywords'])->name('stats.keywords');
    Route::get('/stats/calls/{range?}/{client?}', [AdsData::class, 'calls'])->name('stats.calls');

    Route::get('/reset/{user}', [Page::class, 'resetPassword'])->name('password.reset');


});
