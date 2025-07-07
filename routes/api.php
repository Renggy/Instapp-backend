<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
        Route::post('/signin', [AuthController::class, 'signIn']);
        Route::post('/signup', [AuthController::class, 'signUp']);
        Route::get('/verify',  [AuthController::class, 'verify'])->middleware('auth:sanctum');
        Route::get('/signout', [AuthController::class, 'signOut'])->middleware('auth:sanctum');
    });


Route::middleware('auth:sanctum')
    ->group(function () {
        // Home Feed
        Route::get('/home', [HomeController::class, 'index']);
        Route::get('/home/suggest', [HomeController::class, 'suggest']);

        // Search
        Route::get('/search', [SearchController::class, 'index']);

        // Profile
        Route::get('/{username}', [UserController::class, 'show']);
        Route::get('/{username}/post', [UserController::class, 'post']);
        Route::post('/{username}/post', [UserController::class, 'storePost']);
        Route::post('/{username}/follow', [UserController::class, 'follow']);
        Route::get('/{username}/is-follow', [UserController::class, 'isFollow']);

        // Postingan
        Route::get('/post/{id}', [PostsController::class, 'show']);
        Route::post('/post/{id}/like', [PostsController::class, 'like']);
        Route::post('/post/{id}/comment', [PostsController::class, 'comment']);
    });
