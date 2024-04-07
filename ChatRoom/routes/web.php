<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome  ');
});
Auth::routes();
Route::group(['prefix' => 'chat-room'], function () {
    Route::get('/',[RoomController::class, 'index'])->name('room.index');
    Route::post('/detail-room',[RoomController::class, 'showRoom'])->name('room.show');
    Route::post('/create-room',[RoomController::class, 'storeRoom'])->name('room.store');
    Route::post('/search', [RoomController::class, 'searchRoom'])->name('room.search');
    Route::post('/searchMember', [RoomController::class, 'searchMember'])->name('room.member');
    Route::post('/join', [RoomController::class, 'join'])->name('room.join');
    Route::post('/chatbox',[RoomController::class, 'chatbox'])->name('room.chatbox');
    Route::post('/sendMessage', [RoomController::class, 'sendMess'])->name('room.sendMessage');

});



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
