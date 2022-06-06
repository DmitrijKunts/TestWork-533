<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ArticleTagController;
use App\Http\Middleware\SimpleApiAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(SimpleApiAuth::class)->group(function () {

    Route::prefix('articles')->name('articles.')->group(function () {
        Route::get('/list', [ArticleController::class, 'index'])->name('list');
        Route::get('/search', [ArticleController::class, 'search'])->name('search');
    });
    Route::get('/articles/{id}', [ArticleController::class, 'getById'])
        ->whereNumber('id')
        ->name('articles.get');


    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/list', [ArticleTagController::class, 'index'])->name('list');
        Route::get('/search', [ArticleTagController::class, 'search'])->name('search');
    });
    Route::get('/tags/{id}', [ArticleTagController::class, 'getById'])
        ->whereNumber('id')
        ->name('tags.get');
});
