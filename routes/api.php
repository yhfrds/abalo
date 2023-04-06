<?php

use App\Models\AbShoppingcart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles', [\App\Http\Controllers\ArticleApiController::class, 'index']);
Route::get('/articles/{name}', [\App\Http\Controllers\ArticleApiController::class, 'search_api']);
Route::delete('/articles/{id}', [\App\Http\Controllers\ArticleApiController::class, 'delete_api']);
Route::post('/articles', [\App\Http\Controllers\ArticleApiController::class, 'add_api']);
/*Route::post('/shoppingcart',[ArticleApiController::class,'add_api_shoppingcart']);*/

//Aufgabe 10

Route::post('/shoppingcart', [\App\Http\Controllers\AbShoppingcartAPIController::class,'addShoppingcart']);
Route::delete('/shoppingcart/{shoppingcartId}/articles/{articleId}', [\App\Http\Controllers\AbShoppingcartAPIController::class, 'deleteItemInShoppingcart']);

//M5 A1

//M5 A10
Route::get('/artikelInAngebot', [ArticleApiController::class, 'artikelInAngebot']);
Route::post('/likingArticle',[ArticleApiController::class, 'likingArticle']);
