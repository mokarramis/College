<?php

use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleAssignmentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\User\ContentController as UserContentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Main', 'prefix' => '/main'], function() {
    Route::get('/', [MainController::class, 'index']);
});

Route::group(['prefix' => '/auth'], function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['namespace' => 'Admin', 'prefix' => '/dashboard'], function () {
    Route::post('/store', [ContentController::class, 'store'])->name('store');
    Route::get('/index', [ContentController::class, 'index']);
    Route::get('/delete', [ContentController::class, 'delete']);

    Route::get('/user-index', [UserController::class, 'index']);
    Route::post('/user-store', [UserController::class, 'store']);
    Route::get('/user-edit/{id}', [UserController::class, 'edit']);
    Route::put('/user-update/{user}', [UserController::class, 'update']);

    Route::post('/roles-store', [RoleController::class, 'create']);
    Route::get('/roles-destroy/{id}', [RoleController::class, 'destroy']);
    Route::put('/role-update/{id}', [RoleController::class, 'update']);
    
    Route::post('/permission-store', [PermissionController::class, 'store']);
    Route::get('/permissions-show/{id}', [PermissionController::class, 'show']);
    Route::get('/permission-destroy/{id}', [PermissionController::class, 'destroy']);
    Route::put('/permission-update/{id}', [PermissionController::class, 'update']);
});

Route::group(['namespace' => 'User', 'prefix' => '/user'], function (){
    Route::get('/show/{content}', [UserContentController::class, 'show']);
    Route::get('/download-file/{content}', [UserContentController::class, 'downloadFile']);
    Route::get('/download-video/{content}', [UserContentController::class, 'downloadVideo']);
});


