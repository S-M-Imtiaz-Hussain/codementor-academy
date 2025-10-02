<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\SocialAuthController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/api/register', [AuthenticationController::class, 'register']);
Route::post('/api/login', [AuthenticationController::class, 'login']);
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthenticationController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/logout', [AuthenticationController::class, 'logout']);
    
    //Update profile
    Route::get('user/profile', [AuthenticationController::class, 'profile']);
    Route::patch('user/profile', [AuthenticationController::class, 'updateProfile']);
});

Route::middleware('auth:sanctum')->post('email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!'],200);
})->name('verification.send');


Route::get('email/verify/{id}/{hash}', function ($id, $hash, $request) {
    $user = User::find($id);

    if(!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }
    if(!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid verification link'], 400);
    }   

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified'], 200);
    }
    $user->markEmailAsVerified();
    return response()->json(['message' => 'Email successfully verified'], 200);
})->middleware(['signed'])->name('verification.verify');


Route::post('email/resend-verification', function (Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified'], 200);
    }

    $user->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification link sent!'], 200);
})->name('verification.resend');


Route::get('auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);



Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Access routes for admin only
});

Route::middleware(['auth:sanctum', 'role:admin,mentor'])->group(function () {
    //access routes for admin and mentor
});

Route::middleware(['auth:santum','verified'])->group(function() {
    //access routes for verified users
});

