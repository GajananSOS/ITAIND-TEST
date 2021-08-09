<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserContrroller;
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
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('articles', ArticleController::class);
    Route::get('/article/delete/{id}', [ArticleController::class, 'destroy'])->name('article.delete');
    Route::post('/comment/store', [ArticleController::class, 'storeComment']);
    // Route::get('/search-post', [PostController::class, 'search']);

    Route::middleware(['Author'])->group(function () {
        Route::post('/upload/article-image/{id}', [ArticleController::class, 'storeImage']);
    });
});
