<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\RandomQuoteController;
use App\Http\Controllers\Api\filterQuoteController;
use App\Http\Controllers\Api\mostPopularController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// Quote Crud

Route::middleware('auth:sanctum')->prefix('user')->group(function(){
    Route::post('quotes', [QuoteController::class, 'index']);
    Route::post('quotes/create', [QuoteController::class, 'store']);
    Route::post('quotes/show/{id}', [QuoteController::class, 'show']);
    Route::put('quotes/{id}', [QuoteController::class, 'update']);
    Route::delete('quotes/{id}', [QuoteController::class, 'destroy']);

    // random
    Route::get('quotes/random', [RandomQuoteController::class, 'random']);

    // filtrage by word
    Route::get('quotes/filter-by-length', [FilterQuoteController::class, 'filterByLength']);
    Route::get('quotes/most-popular', [mostPopularController::class, 'mostPopular']);

});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
