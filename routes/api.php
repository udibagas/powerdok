<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentQuizController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MasterFormController;
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
    Route::apiResources([
        'department' => DepartmentController::class,
        'document' => DocumentController::class,
        'language' => LanguageController::class,
        'task' => TaskController::class,
        'user' => UserController::class,
        'masterForm' => MasterFormController::class,
    ]);

    Route::prefix('document')->group(function () {
        Route::post('quiz/{document}', [DocumentController::class, 'saveQuiz']);
        Route::get('quiz/{document}', [DocumentController::class, 'getQuiz']);
        Route::delete('quiz/{documentQuiz}', [DocumentController::class, 'deleteQuiz']);
        Route::get('slug/{slug}', [DocumentController::class, 'slug']);
    });

    Route::prefix('task')->group(function () {
        Route::post('attest/{task}', [TaskController::class, 'attest']);
        Route::post('comments/{task}', [TaskController::class, 'comment']);
        Route::get('comments/{task}', [TaskController::class, 'comments']);

        // exam related
        Route::get('exam/{task}', [TaskController::class, 'exam']);
        Route::post('startExam/{task}', [TaskController::class, 'startExam']);
        Route::post('finishExam/{task}', [TaskController::class, 'finishExam']);
        Route::post('submitExam/{task}', [TaskController::class, 'submitExam']);

        Route::get('document/{task}', [TaskController::class, 'document']);
        Route::post('updateDocument/{task}', [TaskController::class, 'updateDocument']);

        // approval related
        Route::get('approvals/{task}', [TaskController::class, 'approvals']);
        Route::post('approval/{task}', [TaskController::class, 'requestApproval']);
        Route::post('approve/{task}', [TaskController::class, 'approve']);
        Route::delete('approval/{taskApproval}', [TaskController::class, 'deleteApproval']);

        Route::get('attachments/{task}', [TaskController::class, 'attachments']);
    });

    Route::get('typeList', [TaskController::class, 'typeList']);
    Route::get('statusList', [TaskController::class, 'statusList']);
    Route::get('priorityList', [TaskController::class, 'priorityList']);

    Route::prefix('notification')->group(function () {
        Route::get('', [NotificationController::class, 'index']);
        Route::get('/getNewNotifications', [NotificationController::class, 'getNewNotifications']);
        Route::put('/markAsRead/{id}', [NotificationController::class, 'markAsRead']);
        Route::put('/markAllAsRead', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/destroy/{id}', [NotificationController::class, 'destroy']);
        Route::delete('/destroy', [NotificationController::class, 'destroyAll']);
    });

    Route::get('download/{attachment}', [AttachmentController::class, 'download']);
    Route::post('upload', [AttachmentController::class, 'store']);
    Route::delete('attachment/deleteByPath', [AttachmentController::class, 'deleteByPath']);

    Route::get('lang', [LanguageController::class, 'lang']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});
