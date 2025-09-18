<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        $supported = ['google', 'github'];
        if(!in_array($provider, $supported)) {
            return response()->json(['message' => 'Unsupported provider'], 400);
        }
        
        
        try{
            return Socialite::driver($provider)->stateless()->redirect();
        } catch (\Exception $e) {
            Log::error("Social Auth Redirect Error: " . $e->getMessage());
            return response()->json(['message' => 'Unable to redirect to provider.'], 500);
        }
    }

    public function handleProviderCallback($provider)
    {
        $supported = ['google', 'github'];
        if(!in_array($provider, $supported)) {
            return response()->json(['message' => 'Unsupported provider'], 400);
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            if($socialUser->getEmail() === null) {
                return response()->json(['message' => 'No email returned by the provider'], 422);
            }

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'password' => Hash::make(str()->random(16)), 
                    'email_verified_at' => now(), 
                    'role' => 'student'
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Authentication successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'provider' => $provider,
            ],200);

        } catch (\Exception $e) {
            Log::error("Social Auth Callback Error: " . $e->getMessage());
            return response()->json(['message' => 'Authentication failed.'], 500);
        }

        // Here you would typically find or create the user in your database
        // and generate a token for them. For simplicity, we'll just return
        // the social user info.

        return response()->json([
            'id' => $socialUser->getId(),
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'avatar' => $socialUser->getAvatar(),
            'provider' => $provider,
        ]);
    }



}
