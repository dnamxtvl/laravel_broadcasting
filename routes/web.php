<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group([
    'middleware' => ['auth', 'verified']
], function () {
    Route::resource('users', UserController::class);
    Route::group(['prefix' => 'chat'], function () {
        Route::get('/list-conversation', [ChatController::class, 'listConversation'])->name('chats.listConversation');
        Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('chats.sendMessage');
        Route::get('/get-message-of-conversation/{conversationId}', [ChatController::class, 'getMessageOfConversation'])->name('chats.getMessageOfConversation');
        Route::post('/create-conversation', [ChatController::class, 'createNewConversation'])->name('chats.createNewConversation');
    });
});
