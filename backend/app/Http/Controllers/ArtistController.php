<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $artists = Artist::all();
        //return $artists to json response
        return response()->json($artists);
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
    public function show(Artist $artist, $id)
    {
        try {

            $artist = Artist::find($id);

            if (!$artist) {
                return response()->json(['message' => 'Artist not found'], 404);
            }
        
            return response()->json($artist);
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
    public function attach(request $request){
        $artist =  Artist::find($request->artist_id);
        $artist->services()->attach($request->song_id);
        $data = [
            'message' => 'Service attached succesfully',
            'Artist' => $artist
        ];
        return response()->json($data);
    }
}
