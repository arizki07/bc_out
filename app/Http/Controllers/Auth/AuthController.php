<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registered(Request $request): JsonResponse
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users', // Gunakan 'users' dengan titik dua
            'password' => 'required',
        ]);

        // Jika validasi gagal, kirim response error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ], 400);
        }

        // Proses pendaftaran user baru
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Membuat token untuk user (gunakan metode createToken dari Sanctum)
        $success['token'] =  $user->createToken('bc_api')->plainTextToken;
        $success['name'] =  $user->name;

        // Mengirim response sukses
        return response()->json([
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully.'
        ], 201);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah',
            ], 401);
        }

        // User is authenticated; generate a token
        $user = Auth::user();
        $token = $user->createToken('bc_api')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token // Return the actual token string
        ], 200);
    }

    public function logout(Request $request)
    {
        // Ensure the user is authenticated
        $user = auth()->user();

        if ($user) {
            // Revoke the user's token
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully.'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated.'
        ], 401);
    }
}
