<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
            // dd($token);
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
     * Get the authenticated user's profile
     */
    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            if ($user) {
                return response()->json([
                    'response_code' => 200,
                    'status' => 'success',
                    'user' => $user,
                ], 200);
            } 

            return response()->json([
                'response_code' => 401,
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        } catch (\Throwable $th) {
            Log::error('Profile retrieval error: ' . $th->getMessage());
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving the profile'
            ], 500);
        }
    }

    /**
     * Update the authenticated user's profile
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'response_code' => 401,
                    'status' => 'error',
                    'message' => 'User not authenticated'
                ], 401);
            }       
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'sometimes|required|string|min:8|confirmed',
                'skill_level' => 'sometimes|nullable|integer|min:1|max:10',
            ]); 
            if (isset($validatedData['name'])) {
                $user->name = $validatedData['name'];
            }
            if (isset($validatedData['email'])) {
                $user->email = $validatedData['email'];
            }
            if (isset($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }               
            if (array_key_exists('skill_level', $validatedData)) {
                $user->skill_level = $validatedData['skill_level'] ?? $user->skill_level;
            }
            $user->save();
            return response()->json([
                'response_code' => 200,
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'user' => $user,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'response_code' => 422,         
                'message' => 'Validation failed',   
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while updating the profile'
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


    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        $validateEmail = $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $validateEmail
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'response_code' => 200,
                'status' => 'success',
                'message' => 'Password reset link sent to your email.',
            ], 200);
        } else {
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'Failed to send password reset link.',
            ], 500);
        } 
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'token' => 'required|string',
                'email' => 'required|string|email|exists:users,email',
                'password' => 'required|string|min:8|confirmed'
            ]);

            $status = Password::reset( $validatedData, function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    $user->tokens()->delete();
                }
            );

            return match ($status) {
                Password::PASSWORD_RESET => response()->json([
                    'response_code' => 200,
                    'status' => 'success',
                    'message' => 'Password reset successfully.',
                ], 200),

                Password::INVALID_TOKEN => response()->json([
                    'response_code' => 400,
                    'status' => 'error',
                    'message' => 'Invalid or expired reset token.',
                ], 400),

                Password::INVALID_USER => response()->json([
                    'response_code' => 404,
                    'status' => 'error',
                    'message' => 'User not found.',
                ], 404),

                default => response()->json([
                    'response_code' => 500,
                    'status' => 'error',
                    'message' => 'Password reset failed.',
                ], 500),
            };

        } catch (ValidationException $e) {
            return response()->json([
                'response_code' => 422,
                'message' => 'Validation failed',   
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while attempting to reset the password.'
            ], 500);
        }
    }

}
