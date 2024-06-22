<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TempImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// these are the route which are placed in the BlogControler inside app/Http/Controller
Route::get('blogs', [BlogController::class, 'index']);//shows all blogs

Route::post('blogs', [BlogController::class, 'store']);

Route::post('save-temp-image', [TempImageController::class, 'store']);
Route::get('blogs/{id}', [BlogController::class, 'show']);

Route::put('blogs/{id}', [BlogController::class, 'update']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
