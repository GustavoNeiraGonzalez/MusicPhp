<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//artist
Route::get('/artists', [ArtistController::class, 'index']);
Route::post('/artists', [ArtistController::class, 'store']);
Route::get('/artists/{id}', [ArtistController::class, 'show']);
Route::delete('/artists/{id}', [ArtistController::class, 'destroy']);
Route::put('/artists/{id}', [ArtistController::class, 'update']);

//songs
Route::get('/songs', [SongController::class, 'index']);
Route::post('/songs', [SongController::class, 'store']);
Route::get('/songs/file/{id}', [SongController::class, 'showFile']);
Route::get('/songs/name/{id}', [SongController::class, 'showName']);

Route::delete('/songs/{id}', [SongController::class, 'destroy']);
Route::put('/songs/{id}', [SongController::class, 'update']);

