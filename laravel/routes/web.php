<?php

// TODO Clean up use modules
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Sentry\State\Scope;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\APIController;

Route::get('/products', [ProductsController::class, 'getProducts']);

Route::post('/checkout', [CheckoutController::class, 'checkout']);

Route::get('/organization', [OrganizationController::class, 'getOrganization']);

Route::get('/connect', [ConnectController::class, 'getConnect']);

Route::get('/api', [APIController::class, 'getAPI']);

// TODO BELOW
Route::get('/handled', ['as' => 'handled', function (Request $request) {
    try {
        throw new Exception("This is a handled exception");
    } catch (\Throwable $exception) {
        report($exception);
    }
    return $exception;
}]);

Route::get('/unhandled', ['as' => 'unhandled', function () {
    1/0;
}]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/success', ['as' => 'success', function () {
    return 'success';
}]);

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

