<?php

use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canRegister' => true,
        'canResetPassword' => true
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard')->breadcrumb('Dashboard');;

    Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments')->breadcrumb('Shipments');
    Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('shipments.create')->breadcrumb('Create', 'shipments');

});
