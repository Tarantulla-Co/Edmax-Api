<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * @OA\Get(
 *     path="/api/user",
 *     tags={"Authentication"},
 *     summary="Get authenticated user",
 *     description="Get the currently authenticated user information",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="User information retrieved successfully",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated",
 *         @OA\JsonContent(ref="#/components/schemas/Error")
 *     )
 * )
 */
Route::get('/me', [AuthController::class, 'me']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/signin', [AuthController::class, 'signin']);
Route::get('/user/{id}', [AuthController::class, 'show']);
Route::apiResource('/product', ProductController::class,);
Route::post('admin', [AdminController::class, 'login']);


// Example API routes - you can add your own routes here
// Example resource routes (uncomment and modify as needed)
// Route::apiResource('user s', UserController::class);
// Route::apiResource('posts', PostController::class);

// Example authenticated routes (uncomment and modify as needed)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'show']);
//     Route::put('/profile', [ProfileController::class, 'update']);
// }); 