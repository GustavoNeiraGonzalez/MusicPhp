<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use App\Models\Visits;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class VisitsController extends Controller
{
    public function __construct()
    {
        //
        $this->middleware('auth:api', ['only' => ['addVisitToSong']]);
    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visits = Visits::all();

        $data = [
            'message' => 'Visits Details',
            'visits' => $visits,
        ];

        return response()->json($data);
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
    public function addVisitToSong(Request $request)
    {
        try {
            // Validar la solicitud y obtener los datos necesarios...
            $request->validate([
                'user_id' => 'required',
                'song_id' => 'required',
            ]);

            $user = User::find($request->user_id);
            $song = Song::find($request->song_id);

            if (!$user || !$song) {
                return response()->json(['message' => 'User or song not found'], 404);
            }

            // Verificar si ya existe la relación entre el usuario y la visita
            $existingVisit = $user->visits()->where('song_id', $song->id)->first();

            // Obtener la fecha y hora actual
            $currentDateTime = Carbon::now();

            if ($existingVisit) {
                // Si ya existe una relación de usuario y visita

                // Verificar si la última visita fue hace al menos 8 minutos
                $lastVisitedAt = $existingVisit->visited_at;
                $minutesSinceLastVisit = $currentDateTime->diffInMinutes($lastVisitedAt);

                if ($minutesSinceLastVisit >= 8) {
                    // Agregar +1 al valor anterior de visits
                    $existingVisit->visits += 1;
                    $existingVisit->visited_at = $currentDateTime;
                    $existingVisit->save();
                }
            } else {
                // Si no existe una relación de usuario y visita, crear una nueva
                $visit = $this->visits()->where('song_id', $song->id)->first();
                $visit->user_id = $user->id;
                $visit->visits = 1;
                $visit->visited_at = $currentDateTime;
                $visit->save();
            }

            $data = [
                'message' => 'Visit added successfully',
            ];

            return response()->json($data, 200);
        } catch (ValidationException $e) {
            $data = [
                'message' => 'Validation error',
                'errors' => $e->getMessage(),
            ];

            return response()->json($data, 422);
        } catch (\Exception $e) {
            $data = [
                'message' => 'Failed to add visit',
                'error' => $e->getMessage(),
            ];

            return response()->json($data, 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Visits $visits,$id)
    {
        //
        try {

            $visits = Visits::find($id);

            if (!$visits) {
                return response()->json(['message' => 'Song not found'], 404);
            }
            $data = [
                'message'=>'Song Details',
                'visits' =>$visits->visits,
                'visited_At'=>$visits->visited_At
            ];
            return response()->json($data);

        } catch (\Exception $e) {
            // Realizar las acciones necesarias para manejar este error
            $error = "Failed to retrieve song: " . $e->getMessage();
            return response()->json($error);
        }
    }

    public function countTime(Request $request, $id)
    {
        // FUNCION PARA ALMACENAR EL TIEMPO DE REPRODUCCION DE LA CANCION
        try {
            $tiempoReproduccion = $request->input('currentTime');
            
            // Obtener la visita actual
            $visit = Visits::find($id);

            // Verificar si ya hay una duración almacenada para esta visita
            // Si no, establecerla en 0
            $duracionAnterior = $visit->duration ?? 0;

            // Sumar el tiempo actual al valor anterior de la duración
            $visit->duration = $duracionAnterior + $tiempoReproduccion;
            $visit->save();

            // Luego, puedes devolver una respuesta al cliente
            return response()->json(['message' => 'Tiempo de reproducción guardado correctamente']);
            } catch (ValidationException $e) {
                $data = [
                    'message' => 'Validation error',
                    'errors' => $e->getMessage(),
                ];

                return response()->json($data, 422);
            } catch (\Exception $e) {
                $data = [
                    'message' => 'Failed to save playback time',
                    'error' => $e->getMessage(),
                ];

                return response()->json($data, 500);
            }
    }

    public function storeDevice(Request $request, $id)
    {
        try {
            $device = $request->input('device');

            // Obtener la visita actual
            $visit = Visits::find($id);

            // Guardar el dispositivo del usuario en la visita
            $visit->device = $device;
            $visit->save();

            // Luego, puedes devolver una respuesta al cliente
            return response()->json(['message' => 'Dispositivo guardado correctamente']);
        } catch (ValidationException $e) {
            $data = [
                'message' => 'Validation error',
                'errors' => $e->getMessage(),
            ];

            return response()->json($data, 422);
        } catch (\Exception $e) {
            $data = [
                'message' => 'Failed to save device',
                'error' => $e->getMessage(),
            ];

            return response()->json($data, 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visits $visits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visits $visits)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visits $visits)
    {
        //
    }
}
