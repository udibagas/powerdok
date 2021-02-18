<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::post('login', [AuthController::class, 'login']);

Route::post('token', function (Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return [
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'user' => $user
    ];
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('document/{slug}', [DocumentController::class, 'slug']);
    Route::get('lang', [LanguageController::class, 'lang']);

    Route::apiResources([
        'department' => DepartmentController::class,
        'document' => DocumentController::class,
        'language' => LanguageController::class,
        'task' => TaskController::class,
        'user' => UserController::class,
    ]);

    Route::prefix('notification')->group(function () {
        Route::get('', [NotificationController::class, 'index']);
        Route::get('/getNewNotifications', [NotificationController::class, 'getNewNotifications']);
        Route::put('/markAsRead/{id}', [NotificationController::class, 'markAsRead']);
        Route::put('/markAllAsRead', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/destroy/{id}', [NotificationController::class, 'destroy']);
        Route::delete('/destroy', [NotificationController::class, 'destroyAll']);
    });
});
