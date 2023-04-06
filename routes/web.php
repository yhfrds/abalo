<?php

use Illuminate\Support\Facades\Route;

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
    //return view('welcome');
    return redirect('/articles');
});
//Aufgabe 5 optional
Route::post('/testdata',[\App\Http\Controllers\AbTestDataController::class, 'AbTestDataAusgeben']);

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

//Aufgabe 10
Route::get('/articles', [\App\Http\Controllers\ArticlesController::class, 'showArticle_M1A10']);
Route::get('/newarticle',function (){return view('NewArticle');});

//M2
//Aufgabe 9
Route::post('/articles',[\App\Http\Controllers\ArticlesController::class, 'addNewArticle_M2A9']);

//M4
//Aufgabe 8
Route::get('/newsite',function (){
    return view('newsite');
});

//M5
//Aufgabe 1 : Open the refactored site of Artikeleingabe
Route::get('/newarticlerefactor', function(){
    return view('NewArticleWithVue');
});

Route::get('/newsiteEmilio', function (){
    return view('newsiteEmiliosVersion');
});

Route::post('/likingArticle',[\App\Http\Controllers\ArticlesController::class, 'likingArticle']);

//Klausuervorbereitung
Route::get('/testklausur', function (){
//    return response()->json('Ajax functioning well');
    return response()->json(['status' => 200, 'msg' => 'Saved successfully']);
});
