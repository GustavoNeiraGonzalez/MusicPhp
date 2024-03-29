<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//recordar que al acceder a la url de la peticion siempre hay que usar 
//donde api es parte si o si del link http://127.0.0.1:8000/api/
//artist
Route::get('/artists', [ArtistController::class, 'index']);
Route::get('/artists/get/{id}', [ArtistController::class, 'show']);

//songs
Route::get('/songs/get/file/{id}', [SongController::class, 'showFile']);
Route::get('/songs/get/name/{id}', [SongController::class, 'showName']);

Route::get('/songs', [SongController::class, 'index']);

//genre
Route::get('/genre', [GenresController::class, 'index']);
Route::get('/genre/get/{id}', [GenresController::class, 'show']);

// index users
Route::get('/users', [UserController::class, 'index'])->name('index');;

//obtener visitas
Route::get('/visits', [VisitsController::class, 'index']);
Route::get('/get/visits/{id}', [VisitsController::class, 'show']);
Route::get('/get/visitsuser/{id}', [VisitsController::class, 'showUser']);


// -------------------- rutas para admins ----------------
Route::group([
    'middleware' => 'role:admin'
    ], function ($router) {
        //artist
        Route::post('/artists/post', [ArtistController::class, 'store']);
        Route::delete('/artists/delete/{id}', [ArtistController::class, 'destroy']);
        Route::put('/artists/put/{id}', [ArtistController::class, 'update']);

        //songs
        Route::post('/songs/post', [SongController::class, 'store']);
        Route::delete('/songs/delete/{id}', [SongController::class, 'destroy']);
        Route::put('/songs/put/{id}', [SongController::class, 'update']);

        //genre
        Route::post('/genre/post', [GenresController::class, 'store']);
        Route::delete('/genre/delete/{id}', [GenresController::class, 'destroy']);
        Route::put('/genre/put/{id}', [GenresController::class, 'update']);

        //unir tablas artista song
        Route::post('/atach/artists/songs', [ArtistController::class, 'attachsong']);
        Route::post('/detach/artists/songs', [ArtistController::class, 'detachsong']);
        
        //unir tablas artista genero
        Route::post('/atach/artists/genres', [ArtistController::class, 'attachgenre']);
        Route::post('/detach/artists/genres', [ArtistController::class, 'detachgenre']);

        /* unir tablas cancion genero */
        
        Route::post('/atach/songs/genres', [SongController::class, 'attachgenre']);
        Route::post('/detach/songs/genres', [SongController::class, 'detachgenre']);
        
        /* roles */
        Route::post('/delete/users/roles', [UserController::class, 'removeRole']);
        Route::post('/put/users/roles', [UserController::class, 'assignRole']);
        
        /*delete update users */
        Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
        Route::put('/users/put/{id}', [UserController::class, 'update']);
        
    });
// ---------------- rutas usuarios NO LOGEADOS ----------------
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {



    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::post('/users/refresh', [UserController::class, 'refresh']);
    Route::post('/users/register', [UserController::class, 'register']);
    Route::post('/users/login', [UserController::class, 'login'])->name('login');
    Route::get('/users/med', [UserController::class, 'me']);

});
//con ->middleware('auth:api') verificas que este logeado
Route::post('/add/visits/{song_id}', [VisitsController::class, 'addVisitToSong'])->middleware('auth:api');
Route::post('atach/users/songs', [UserController::class, 'attachsong'])->middleware('auth:api');
Route::post('detach/users/songs', [UserController::class, 'detachsong'])->middleware('auth:api');
Route::post('/genre/post', [GenresController::class, 'store'])->middleware('auth:api');
