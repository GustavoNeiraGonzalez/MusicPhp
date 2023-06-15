<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenresController;

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
Route::post('/artists/post', [ArtistController::class, 'store']);
Route::get('/artists/get/{id}', [ArtistController::class, 'show']);
Route::delete('/artists/delete/{id}', [ArtistController::class, 'destroy']);
Route::put('/artists/put/{id}', [ArtistController::class, 'update']);

//songs
Route::get('/songs', [SongController::class, 'index']);
Route::post('/songs/post', [SongController::class, 'store']);
Route::get('/songs/get/file/{id}', [SongController::class, 'showFile']);
Route::get('/songs/get/name/{id}', [SongController::class, 'showName']);

Route::delete('/songs/delete/{id}', [SongController::class, 'destroy']);
Route::put('/songs/put/{id}', [SongController::class, 'update']);

//genre
Route::get('/genre', [GenresController::class, 'index']);
Route::post('/genre/post', [GenresController::class, 'store']);
Route::get('/genre/get/{id}', [GenresController::class, 'show']);
Route::delete('/genre/delete/{id}', [GenresController::class, 'destroy']);
Route::put('/genre/put/{id}', [GenresController::class, 'update']);


// unir tablas
Route::post('/artists/songs', [ArtistController::class, 'attach']);
