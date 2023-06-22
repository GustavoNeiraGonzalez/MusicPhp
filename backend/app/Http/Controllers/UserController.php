<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Users = User::all();
        $data = [
            'message'=>'Users Details',
            'User' =>$Users,
        ];
        //return $Users to json response
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
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return response()->json(['message' => 'User created successfully', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register user: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request){
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user);

                return response()->json(['token' => $token]);
            }

            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected failure on login user: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        try {

            $User = User::find($id);

            if (!$User) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $data = [
                'message'=>'Users Details',
                'User' =>$User,
                'Canciones'=>$User->songs,
                'Generos'=>$User->genres
            ];
            //return $Users to json response
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to show User',
                'error' => 'User no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to show User: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User)
    {
        //
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $User = User::findOrFail($id);

            $User->name = $request->name;
            $User->description = $request->description;
            $User->save();
        
            $data = [
                'message' => 'User updated successfully',
                'User' => $User
            ];
        
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to update User',
                'error' => 'User no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to update User: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User, $id)
    {
        try {
            $User = User::findOrFail($id);
            $User->delete();
    
            $data = [
                'message' => 'User deleted successfully'
            ];
    
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            $data = [
                'message' => 'Failed to delete User',
                'error' => 'User no encontrado con id: ' . $id
            ];
    
            return response()->json($data, 404);
        } catch (Exception $e) {
            // Excepción genérica para cualquier otro tipo de error
            $error = "Failed to delete User: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    
        
    }
    //-------------- UNIR TABLAS SONG Y GENRES CON User -------------  
    public function attachsong(Request $request)
    {
        try {
            $User = User::find($request->user_id);
    
            // Verificar si ya existe la unión entre el User y la canción
            if ($User->songs()->where('song_id', $request->song_id)->exists()) {
                $message = 'Song already attached to the User';
            } else {
                // Unir la canción al User sin duplicación
                $User->songs()->syncWithoutDetaching($request->song_id);
                $message = 'Song attached successfully';
            }
    
            $data = [
                'message' => $message,
                'User' => $User
            ];
    
            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to attach User/song: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }
    
    public function detachsong(Request $request){
        try {
            $User = User::find($request->user_id);

            // Verificar si la unión existe antes de eliminarla
            $detached = $User->songs()->detach($request->song_id);

            if ($detached > 0) {
                $message = 'Song detached successfully';
            } else {
                $message = 'Song was not attached to the User';
            }

            $data = [
                'message' => $message,
                'User' => $User
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $error = "Failed to detach User/song: " . $e->getMessage();
            return response()->json($error);
            // Realiza las acciones necesarias para manejar este error
        }
    }



}
