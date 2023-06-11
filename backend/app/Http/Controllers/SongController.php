<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TheSeer\Tokenizer\Exception;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::all();
        //return $artists to json response
        return response()->json($songs);
    
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
        try {

            // Validar la solicitud y procesar los datos necesarios...

            // Obtener el archivo de la canción
            $songFile = $request->file('song');

            // Generar un nombre único para el archivo
            $fileName = uniqid() . '.' . $songFile->getClientOriginalExtension();

            // Almacenar el archivo en el sistema de archivos
            $songFile->storeAs('songs', $fileName);

            // Crear una nueva instancia del modelo Song y asignar la ruta de la canción
            $song = new Song;
            $song->song_path = 'songs/' . $fileName;
            // Otros campos de la canción...
            $song->song_name = $request->song_name;
            $song->save();
            
            // Devolver una respuesta adecuada...
            $data = [
                'message' => 'Artist created succesfully',
                'artist' => $song
            ];
            return response()->json($data);
        }catch (Exception $e) {
            // Excepción genérica para cualquier tipo de error
            $error = "Failed to saving song: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        //
    }
}
