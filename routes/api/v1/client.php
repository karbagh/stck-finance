<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('client.')->controller(ClientController::class)
    ->prefix('clients')->middleware(['auth:api'])->group(function () {
        Route::name('list')->get('', 'list');
        Route::name('store')->post('', 'store');
        Route::prefix('{client:id}')->name('client.')->group(function() {
            Route::name('show')->get('', 'show');
            Route::name('update')->put('', 'update');
            Route::name('destroy')->delete('', 'destroy');
        });
    });
