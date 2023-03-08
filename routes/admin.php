<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2023/3/2
 * Time: 11:17
 * File: admin.php
 */

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\HomeController as AdminController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin:qinghe')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('admin:index')->withoutMiddleware('admin:qinghe');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login')->withoutMiddleware('admin:qinghe');
    Route::get('qh', [AdminController::class, 'index'])->name('admin.home');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('article', [ArticleController::class, 'index'])->name('admin.article.index');
    Route::get('article/create', [ArticleController::class, 'create'])->name('admin.article.create');
    Route::post('article', [ArticleController::class, 'store'])->name('admin.article.store');
    Route::get('article/edit/{id}', [ArticleController::class, 'edit'])->name('admin.article.edit');
    Route::put('article/update/{id}', [ArticleController::class, 'update'])->name('admin.article.update');
    Route::delete('article/destroy/{id}', [ArticleController::class, 'destroy'])->name('admin.article.destroy');

    Route::get('category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('category', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::post('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::get('category/set-nav/{id}', [CategoryController::class, 'setNavigation'])->name('admin.category.set-nav');

    Route::get('comment', [CommentController::class, 'index'])->name('admin.comment.index');
    Route::delete('comment', [CommentController::class, 'destroy'])->name('admin.comment.destroy');

    Route::get('tag', [TagController::class, 'index'])->name('admin.tag.index');
    Route::get('tag/create', [TagController::class, 'create'])->name('admin.tag.create');
    Route::post('tag', [TagController::class, 'store'])->name('admin.tag.store');
    Route::get('tag/edit/{id}', [TagController::class, 'edit'])->name('admin.tag.edit');
    Route::put('tag/update/{id}', [TagController::class, 'update'])->name('admin.tag.update');
    Route::post('tag/destroy/{id}', [TagController::class, 'destroy'])->name('admin.tag.destroy');

    Route::get('upload', [UploadController::class, 'index'])->name('admin.upload.index');
    Route::post('upload/file-upload', [UploadController::class, 'fileUpload'])->name('admin.upload.file-upload');
    Route::post('upload/dir-del', [UploadController::class, 'dirDelete'])->name('admin.upload.dir-del');
    Route::post('upload/file-del', [UploadController::class, 'fileDelete'])->name('admin.upload.file-del');
    Route::post('upload/mkdir', [UploadController::class, 'makeDir'])->name('admin.upload.mkdir');

    Route::get('navigation', [NavigationController::class, 'index'])->name('admin.navigation.index');
    Route::get('navigation/create', [NavigationController::class, 'create'])->name('admin.navigation.create');
    Route::get('navigation/{id}', [NavigationController::class, 'edit'])->name('admin.navigation.edit');
    Route::put('navigation/update/{id}', [NavigationController::class, 'update'])->name('admin.navigation.update');
    Route::post('navigation', [NavigationController::class, 'store'])->name('admin.navigation.store');
    Route::delete('navigation/destroy/{id}', [NavigationController::class, 'destroy'])->name('admin.navigation.destroy');

    Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('user', [UserController::class, 'store'])->name('admin.user.store');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('system', [SystemController::class, 'index'])->name('admin.system.index');
    Route::post('system', [SystemController::class, 'store'])->name('admin.system.store');

    Route::get('link', [LinkController::class, 'index'])->name('admin.link.index');
    Route::get('link/create', [LinkController::class, 'create'])->name('admin.link.create');
    Route::post('link', [LinkController::class, 'store'])->name('admin.link.store');
    Route::get('link/edit/{id}', [LinkController::class, 'edit'])->name('admin.link.edit');
    Route::put('link/update/{id}', [LinkController::class, 'update'])->name('admin.link.update');
    Route::post('link/destroy/{id}', [LinkController::class, 'destroy'])->name('admin.link.destroy');

    Route::get('page', [PageController::class, 'index'])->name('admin.page.index');
    Route::get('page/create', [PageController::class, 'create'])->name('admin.page.create');
    Route::post('page', [PageController::class, 'store'])->name('admin.page.store');
    Route::get('page/edit/{id}', [PageController::class, 'edit'])->name('admin.page.edit');
    Route::put('page/update/{id}', [PageController::class, 'update'])->name('admin.page.update');
    Route::get('page/destroy/{id}', [PageController::class, 'destroy'])->name('admin.page.destroy');
});
