<?php

use App\Http\Controllers\UserController;
use App\Models\Task;
use App\Models\User;
use App\Notifications\ApprovalRequestNotification;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('user', UserController::class);
});

Route::get('test-email', function() {
    return (new ApprovalRequestNotification(Task::first()))->toMail(User::first());
});
