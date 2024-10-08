<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        try {
            $rules = [
                'username' => ['required', 'unique:users'],
                'email' => ['required', 'unique:users'],
                'password' => ['required', 'min:6', 'confirmed'],
                'name' => ['required'],
                'last_name' => ['required'],
                'phone' => ['required'],
                'date_of_birth' => ['required'],
                'gender' => ['required', 'in:hombre,mujer']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validación fallida',
                    'errors' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }
            DB::beginTransaction();
            $user = new User();
            $user->username = str_replace(' ', '_', $request->username);
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = "client";
            $user->save();
            $user_id = $user->id;
            $request->merge(['user_id' => $user_id]);
            Profile::create($request->all());
            DB::commit();
            return response()->json(['message' => "Hola, $user->username tu registro fue completado"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422); // Unprocessable Content
            }
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => 'El correo no se encuentra registrado'], 404);
            }
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'La contraseña es incorrecta'], 401);
            }
            Auth::login($user);           
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error interno en el servidor. Por favor, intente nuevamente.',
                'details' => $e->getMessage() // Esto es opcional, para mostrar el detalle del error solo en desarrollo
            ], 500); 
        }
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
