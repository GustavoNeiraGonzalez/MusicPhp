<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $genres = Genres::all();
        //return $artists to json response
        return response()->json($genres);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {

            $genres = new Genres;
            $genres->genre = $request->genre;
            $genres->save();
            $data = [
                'message' => 'Genre created succesfully',
                'genres' => $genres
            ];
            return response()->json($data);
        } catch (Exception $e) {
            // Excepción genérica para cualquier tipo de error
            $error = "Failed to create genres: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Genres $genres,$id)
    {
        //
        try {

            $genres = Genres::find($id);

            if (!$genres) {
                return response()->json(['message' => 'Genre not found'], 404);
            }
        
            return response()->json($genres);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to show genres',
                'error' => 'genres no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to show genre: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genres $genres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genres $genres, $id)
    {
        try {
            $genre = Genres::findOrFail($id);

            $genre->genre = $request->genre;
            $genre->save();
        
            $data = [
                'message' => 'Genres updated successfully',
                'Genres' => $genre
            ];
        
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to update Genres',
                'error' => 'Genres no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to update Genres: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genres $genres,$id)
    {
        try {
            $genre = Genres::findOrFail($id);
            $genre->delete();
    
            $data = [
                'message' => 'Genres deleted successfully'
            ];
    
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to delete Genres',
                'error' => 'Genres no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to delete Genres: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    
        
    }
    
}
