<?php

use App\Http\Controllers\Api\Admin\AdminCommentController;
use App\Http\Controllers\Api\Admin\AdminPostController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\User\UserController;
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

Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [AuthController::class, 'authenticate']);

Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
Route::apiResource('posts/{postId}/comments', CommentController::class)->middleware('auth:sanctum');

Route::get('/admin/posts/{postId}', [AdminPostController::class, 'show'])
  ->middleware('auth:sanctum')
  ->middleware('auth.admin');

Route::delete('/admin/posts/{postId}', [AdminPostController::class, 'delete'])
  ->middleware('auth:sanctum')
  ->middleware('auth.admin');

Route::post('/admin/posts/{postId}/restore', [AdminPostController::class, 'restore'])
  ->middleware('auth:sanctum')
  ->middleware('auth.admin');

Route::get('/admin/posts/{postId}/comments/{commentId}', [AdminCommentController::class, 'show'])
  ->middleware('auth:sanctum')
  ->middleware('auth.admin');

Route::delete('/admin/posts/{postId}/comments/{commentId}', [AdminCommentController::class, 'delete'])
  ->middleware('auth:sanctum')
  ->middleware('auth.admin');

Route::post('/admin/posts/{postId}/comments/{commentId}/restore', [AdminCommentController::class, 'restore'])
  ->middleware('auth:sanctum')
  ->middleware('auth.admin');
