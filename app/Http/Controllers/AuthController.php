<?php
namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
     public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255', // Corregido de 'usuario' a 'name'
            'email' => 'required|string|email|max:255|unique:usuarios', // Asegúrate de que el nombre de la tabla sea 'usuarios'
            'password' => 'required|string|min:8',
            'rol' => 'required|string|in:admin,profesor',
            'profesor_id' => 'nullable|integer|exists:profesores,cedula', // Agregado según tu definición
        ]);

        // Crear el usuario
        $user = Usuarios::create([
            'name' => $request->name, // Cambié de 'usuario' a 'name'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'profesor_id' => $request->profesor_id, // Incluir el campo profesor_id
        ]);

        // Generar el token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    } 

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Usuarios::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
/*
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
            
            'rol' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        

        $user = User::create([
            'usuario' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return response()->json(['user' => $user], 201);
    }

    // Inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Las credenciales son incorrectas'], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    // Cierre de sesión
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Cierre de sesión exitoso'], 200);
    }
}

*/