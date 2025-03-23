<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\RandomQuoteController;
use App\Http\Controllers\Api\filterQuoteController;
use App\Http\Controllers\Api\mostPopularController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\FavoriteController;





Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// logout
Route::middleware('auth:sanctum', 'role:user')->post('/logout', [AuthController::class, 'logout']);


// Quote Crud

Route::middleware('auth:sanctum')->prefix('user')->group(function(){
    Route::post('quotes', [QuoteController::class, 'index']);
    Route::post('quotes/create', [QuoteController::class, 'store']);
    Route::post('quotes/show/{id}', [QuoteController::class, 'show']);
    Route::put('quotes/{id}', [QuoteController::class, 'update']);
    Route::delete('quotes/{id}', [QuoteController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->prefix('user')->group(function(){
      Route::get('quotes/random', [RandomQuoteController::class, 'random']);
      Route::get('quotes/filter-by-length', [FilterQuoteController::class, 'filterByLength']);
      Route::get('quotes/most-popular', [mostPopularController::class, 'mostPopular']);

      Route::post('quotes/tags', [TagsController::class, 'create']);



      Route::post('/quotes/{quote}/like', [LikeController::class, 'like']);

    // Route pour retirer un like d'une citation
    Route::post('/quotes/{quote}/unlike', [LikeController::class, 'unlike']);


    // ************************ favoris ********************************

    Route::post('/quotes/{quote}/favorite', [FavoriteController::class, 'addToFavorites']);
    Route::post('/quotes/{quote}/unfavorite', [FavoriteController::class, 'removeFromFavorites']);
    Route::get('/favorites', [FavoriteController::class, 'getFavorites']);


});




// Route::middleware(['auth:sanctum', 'role:admin'])->group(function(){
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
// });



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
