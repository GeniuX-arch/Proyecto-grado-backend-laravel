<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\HorarioDisponibleController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\SalonController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



//CRUDs
Route::resource('/profesores', ProfesorController::class);
Route::apiResource('horarios_disponibles', HorarioDisponibleController::class);
Route::apiResource('profesor_materia', ProfesorMateriaController::class);
Route::apiResource('materias', MateriaController::class);
Route::apiResource('clases', ClaseController::class);
Route::apiResource('/salones', SalonController::class);


Route::post('/login', function (Request $request) {
    // Validar la entrada
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    // Buscar el miembro en la base de datos
    $member = User::where('email', $credentials['email'])->first(); 

    // Verificar si el miembro existe y si la contraseña es correcta
    if ($member && Hash::check($credentials['password'], $member->password)) {
        // Regenerar la sesión
        $request->session()->regenerate();
        Auth::login($member); // Iniciar sesión usando el modelo miembro
        return response()->json(['message' => 'Authenticated']);
    }
    // Si no se autentica, devolver un error
    return response()->json(['message' => 'Invalid credentials'], 401);
});




Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF token set']);
});




Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['message' => 'Logged out']);
});






Route::post('/register', function (Request $request) {
    // Validar la entrada
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed', // Asegúrate de que la contraseña sea confirmada
    ]);

    // Si la validación falla, devuelve un error
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Crear un nuevo usuario
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Encriptar la contraseña
    ]);

    // Opcional: Regenerar la sesión después del registro y autenticar al usuario
    Auth::login($user);

    return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
});

