<?php

namespace App\Http\Controllers;

use App\Models\Visits;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class VisitsController extends Controller
{
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
    public function store(Request $request,$id)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'song_id' => 'required',
            ]);

            $visit = new Visits();
            $visit->user_id = $request->user_id;
            $visit->song_id = $request->song_id;
            $visit->visited_at = Carbon::now(); // Genera la fecha y hora actual
            $visit->save();

            $data = [
                'message' => 'Visit created successfully',
                'visit' => $visit,
            ];

            return response()->json($data, 201);
        } catch (ValidationException $e) {
            $data = [
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ];

            return response()->json($data, 422);
        } catch (\Exception $e) {
            $data = [
                'message' => 'Failed to create visit',
                'error' => $e->getMessage(),
            ];

            return response()->json($data, 500);
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Visits $visits)
    {
        //
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
