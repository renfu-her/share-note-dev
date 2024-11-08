<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminNoteController;

Route::get('/', function () {
    return view('welcome');
});

// 管理員登入
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::group([
    'middleware' => ['admin.auth'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('notes', AdminNoteController::class);
});
