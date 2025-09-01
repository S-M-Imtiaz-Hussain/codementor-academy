<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\User;

class AuthenticationController extends Controller
{
    /**
     * Register a new user.
     */

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:student,mentor,admin',
                'skill_level' => 'nullable|integer|min:1|max:10',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'skill_level' => $validatedData['skill_level'] ?? 1,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
dd($token);
            return response()->json([
                'response_code' => 201,
                'status' => 'success',
                'message' => 'Registration successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'response_code' => 422,
                'message' => 'Validation failed',   
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'Registration failed', 
            ], 500);
        }
    }


    /**
     * Login user and create token
     */
    public function login(Request $request) 
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            ;
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'response_code' => 401,
                    'status'        => 'error',
                    'message'       => 'Unauthorized',
                ], 401);
            }
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'response_code' => 200,
                'status' => 'success',
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_info'     => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'response_code' => 422,
                'message' => 'Validation failed',   
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'Login failed'
            ], 500);
        }
    }


    /**
     * Logout user (Revoke the token)
     */
    public function logout(Request $request)
    {
        try {

            $user = $request->user();
            if($user) {

                $user->tokens()->delete();

                return response()->json([
                    'response_code' => 200,
                    'status' => 'success',
                    'message' => 'Logout successful',
                ], 200);
            } 

            return response()->json([
                'response_code' => 401,
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);

        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'An error occurred during logout'
            ], 500);
        }
    }


}
