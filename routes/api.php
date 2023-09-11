<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CloudinaryController;

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

Route::post('/upload',  [CloudinaryController::class, 'upload']);
Route::get('/get-image', [CloudinaryController::class, 'getImageDetail']);
Route::get('/image-resize', [CloudinaryController::class, 'imageResize']);
Route::delete('/delete', [CloudinaryController::class, 'destroy']);
