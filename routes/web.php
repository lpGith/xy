<?php

use App\Http\Controllers\Home\ArticleController;
use App\Http\Controllers\Home\CategoryController;
use App\Http\Controllers\Home\CommentController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PageController;
use App\Http\Controllers\Home\SearchController;
use App\Http\Controllers\Home\TagController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/player', [HomeController::class, 'player']);

Route::get('/article/select', [ArticleController::class, 'selectDate']);

Route::get('/article/{id}', [ArticleController::class, 'index'])->name('article');

Route::get('/category/{id}', [CategoryController::class, 'index'])->name('category');

Route::get('/tag/{id}', [TagController::class, 'index'])->name('tag');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/page/{alias}', [PageController::class, 'index'])->name('page.show');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/mail', [ArticleController::class, 'mail']);

Route::post('/comment', [CommentController::class, 'store'])->name('comment');

Route::get('/send', [CommentController::class, 'send'])->name('send');

