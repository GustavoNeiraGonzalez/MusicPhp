<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Visits;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TheSeer\Tokenizer\Exception;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
            $songFile->storeAs('public', $fileName);

            // Crear una nueva instancia del modelo Song y asignar la ruta de la canción
            $song = new Song;
            $song->song_path = 'public/' . $fileName;
            // Otros campos de la canción...
            $song->song_name = $request->song_name;
            $song->save();

            // creacion de la visita para la cancion
            $visit = new Visits();
            $visit->song_id = $song->id;
            $visit->visited_at = null; // Establecer como nulo, ya que aún no se ha visitado
            $visit->save(); 
           
            // Devolver una respuesta adecuada...
            $data = [
                'message' => 'Song created successfully',
                'song' => $song,
            ];
            return response()->json($data, 201);
        } catch (ValidationException $e) {
            $data = [
                'message' => 'Validation error',
                'errors' => $e->getMessage(),
            ];

            return response()->json($data, 422);
        } catch (\Exception $e) {
            $data = [
                'message' => 'Failed to create song',
                'error' => $e->getMessage(),
            ];

            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showFile(Song $song,$id)
    {
        try {
            // Buscar la canción en la base de datos
            $song = Song::find($id);

            // Verificar si se encontró la canción
            if (!$song) {
                throw new \Exception('Song not found');
            }

            // Obtener la ruta completa de la canción
            $songPath = storage_path('app/' . $song->song_path);

            // Verificar si el archivo de la canción existe
            if (!file_exists($songPath)) {
                throw new \Exception('Song file not found');
            }
             // Devolver la canción como una respuesta de archivo
            $response = response()->file($songPath);

            return $response;

            // Devolver la canción como una respuesta de descarga
        } catch (\Exception $e) {
            // Realizar las acciones necesarias para manejar este error
            $error = "Failed to retrieve song: " . $e->getMessage();
            return response()->json($error);
        }
    }
    public function showName(Song $song,$id)
    {
        try {

            $song = Song::find($id);

            if (!$song) {
                return response()->json(['message' => 'Song not found'], 404);
            }
            $data = [
                'message'=>'Song Details',
                'Song' =>$song->song_name,
                'Generos'=>$song->genres
            ];
            return response()->json($data);

        } catch (\Exception $e) {
            // Realizar las acciones necesarias para manejar este error
            $error = "Failed to retrieve song: " . $e->getMessage();
            return response()->json($error);
        }
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
    public function update(Request $request, Song $song, $id)
    {
        try {
            // Buscar la canción en la base de datos
            $song = Song::find($id);

            // Verificar si se encontró la canción
            if (!$song) {
                throw new \Exception('Song not found');
            }
    
            // Obtener el archivo de la nueva canción
            $newSongFile = $request->file('song');
    
            // Verificar si se proporcionó un nuevo archivo de canción
            if ($newSongFile) {
                // Obtener la ruta completa del archivo anterior
                $oldSongPath = storage_path('app/' . $song->song_path);
    
                // Verificar si el archivo anterior existe y eliminarlo
                if (file_exists($oldSongPath)) {
                    unlink($oldSongPath);
                }
    
                // Generar un nombre único para el nuevo archivo
                $newFileName = uniqid() . '.' . $newSongFile->getClientOriginalExtension();
    
                // Almacenar el nuevo archivo en el sistema de archivos
                $newSongFile->storeAs('', $newFileName, 'public');
    
                // Actualizar la ruta de la canción con el nuevo archivo
                $song->song_path = 'public/' . $newFileName;
            }
    
            // Actualizar los demás campos de la canción si es necesario
            $song->song_name = $request->song_name;
            
            // Otros campos de la canción...
    
            // Guardar los cambios en la base de datos
            $song->save();
    
            // Devolver una respuesta adecuada...
            $data = [
                'message' => 'Song updated successfully',
                'song' => $request->all()
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            // Realizar las acciones necesarias para manejar este error
            $error = "Failed to update song: " . $e->getMessage();
            return response()->json($error);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song,$id)
    {
        try {

            $song = Song::find($id);
        
            // Verificar si se encontró la cancion
            if (!$song) {
                throw new \Exception('Song not found');
            }
        
            // Eliminar de la base de datos
            $song->delete();
        
            // Devolver una respuesta adecuada...
            $data = [
                'message' => 'Song deleted successfully'
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            // Realizar las acciones necesarias para manejar este error
            $error = "Failed to delete song: " . $e->getMessage();
            return response()->json($error);
        }     
    }
    // ---------------------- UNIR SONG Y GENRES ------------------
    public function attachgenre(Request $request){
        try {
            $song = Song::find($request->song_id);

            // Verificar si ya existe la unión entre el artista y el género
            if ($song->genres()->where('genres_id', $request->genre_id)->exists()) {
                $message = 'Genre already attached to the Song';
            } else {
                // Unir el género al artista sin duplicación
                $song->genres()->syncWithoutDetaching($request->genre_id);
                $message = 'Genre attached successfully';
            }

            $data = [
                'message' => $message,
                'Song' => $song
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to attach Song/genre: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    public function detachgenre(Request $request){
        try {
            $song = Song::find($request->song_id);

            // Verificar si la unión existe antes de eliminarla
            $detached = $song->genres()->detach($request->genre_id);

            if ($detached > 0) {
                $message = 'Genre detached successfully';
            } else {
                $message = 'Genre was not attached to the Song';
            }

            $data = [
                'message' => $message,
                'Song' => $song
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to detach Song/genre: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }
}
