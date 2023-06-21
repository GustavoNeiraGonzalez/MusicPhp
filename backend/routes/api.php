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
//recordar que al acceder a la url de la peticion siempre hay que usar 
//donde api es parte si o si del link http://127.0.0.1:8000/api/
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
//artista cancion
Route::post('/atach/artists/songs', [ArtistController::class, 'attachsong']);
Route::post('/detach/artists/songs', [ArtistController::class, 'attachgenre']);

//artista genero
Route::post('/atach/artists/genres', [ArtistController::class, 'attachgenre']);
Route::post('/detach/artists/genres', [ArtistController::class, 'detachgenre']);
