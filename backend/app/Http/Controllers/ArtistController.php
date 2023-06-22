<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Middleware\GetUserFromToken;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->middleware('auth:api');
        $artists = Artist::all();
        $data = [
            'message'=>'Artists Details',
            'Artist' =>$artists,
        ];
        //return $artists to json response
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //no se utiliza create porque no es una api rest
        //en caso contrario de una web tradicional, si se usaria
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $artist = new Artist;
            $artist->name = $request->name;
            $artist->description = $request->description;
            $artist->save();
            $data = [
                'message' => 'Artist created succesfully',
                'artist' => $artist
            ];
            return response()->json($data);
        } catch (Exception $e) {
            // Excepción genérica para cualquier tipo de error
            $error = "Failed to create artist: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        try {

            $artist = Artist::find($id);

            if (!$artist) {
                return response()->json(['message' => 'Artist not found'], 404);
            }
            $data = [
                'message'=>'Artists Details',
                'Artist' =>$artist,
                'Canciones'=>$artist->songs,
                'Generos'=>$artist->genres
            ];
            //return $artists to json response
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to show artist',
                'error' => 'Artista no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to show artist: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        //
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $artist = Artist::findOrFail($id);

            $artist->name = $request->name;
            $artist->description = $request->description;
            $artist->save();
        
            $data = [
                'message' => 'Artist updated successfully',
                'artist' => $artist
            ];
        
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to update artist',
                'error' => 'Artista no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to update artist: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist, $id)
    {
        try {
            $artist = Artist::findOrFail($id);
            $artist->delete();
    
            $data = [
                'message' => 'Artist deleted successfully'
            ];
    
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to delete artist',
                'error' => 'Artista no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to delete artist: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    
        
    }
    //-------------- UNIR TABLAS SONG Y GENRES CON ARTIST -------------  
    public function attachsong(Request $request)
    {
        try {
            $artist = Artist::find($request->artist_id);
    
            // Verificar si ya existe la unión entre el artista y la canción
            if ($artist->songs()->where('song_id', $request->song_id)->exists()) {
                $message = 'Song already attached to the artist';
            } else {
                // Unir la canción al artista sin duplicación
                $artist->songs()->syncWithoutDetaching($request->song_id);
                $message = 'Song attached successfully';
            }
    
            $data = [
                'message' => $message,
                'Artist' => $artist
            ];
    
            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to attach artist/song: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }
    
    public function detachsong(Request $request){
        try {
            $artist = Artist::find($request->artist_id);

            // Verificar si la unión existe antes de eliminarla
            $detached = $artist->songs()->detach($request->song_id);

            if ($detached > 0) {
                $message = 'Song detached successfully';
            } else {
                $message = 'Song was not attached to the artist';
            }

            $data = [
                'message' => $message,
                'Artist' => $artist
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to detach artist/song: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    public function attachgenre(Request $request){
        try {
            $artist = Artist::find($request->artist_id);

            // Verificar si ya existe la unión entre el artista y el género
            if ($artist->genres()->where('genres_id', $request->genre_id)->exists()) {
                $message = 'Genre already attached to the artist';
            } else {
                // Unir el género al artista sin duplicación
                $artist->genres()->syncWithoutDetaching($request->genre_id);
                $message = 'Genre attached successfully';
            }

            $data = [
                'message' => $message,
                'Artist' => $artist
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to attach artist/genre: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    public function detachgenre(Request $request){
        try {
            $artist = Artist::find($request->artist_id);

            // Verificar si la unión existe antes de eliminarla
            $detached = $artist->genres()->detach($request->genre_id);

            if ($detached > 0) {
                $message = 'Genre detached successfully';
            } else {
                $message = 'Genre was not attached to the artist';
            }

            $data = [
                'message' => $message,
                'Artist' => $artist
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to detach artist/genre: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }
}
