<?php

use Bagisto\AzureAuth\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

$middleware = ['web'];
$prefix = config('app.admin_url') . '/azure';

Route::group(['middleware' => $middleware, 'prefix' => $prefix], function () {
    Route::get('/auth', [SessionController::class, 'redirectToAzure'])->name('azure.authenticate');

    Route::get('/callback', [SessionController::class, 'handleCallback'])->name('azure.callback');
});
