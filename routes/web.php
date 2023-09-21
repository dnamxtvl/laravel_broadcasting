<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ChatController;

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

Route::get('/get-google-sign-in-url', [GoogleController::class, 'getGoogleSignInUrl'])->name('getLogInUrl');
Route::get('/google/callback', [GoogleController::class, 'loginCallback'])->name('loginGoogleCallback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'admin'
], function () {
    Route::resource('articles', ArticleController::class);
    Route::resource('users', UserController::class);
    Route::get('export-user/2', [UserController::class, 'test'])->name('users.exportUser');
    Route::resource('roles', RoleController::class);
    // Route::get('/index', [ChatController::class, 'index'])->name('chats.index');
    Route::group(['prefix' => 'chats'], function () {
        Route::get('/index', [ChatController::class, 'index'])->name('chats.index');
        Route::post('/send-message-to-user', [ChatController::class, 'sendUserMessage'])->name('chats.sendUserMessage');
        Route::post('/detail-message-single/{toUserId}', [ChatController::class, 'listDetailMessage'])->name('chats.listDetailMessageSingle');
        Route::post('/block-user', [ChatController::class, 'blockUser'])->name('chats.blockUser');
        Route::post('/un-block-user', [ChatController::class, 'unBlockUser'])->name('chats.blockUser');
    });
});
