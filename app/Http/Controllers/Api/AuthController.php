<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
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
        try {
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
            return response()->json(['error' => 'Error en el registro, por favor intenta nuevamente.'], 500);
        }
    }


   
}
