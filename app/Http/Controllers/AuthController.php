<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => [
                'required',
                'integer',
                Rule::exists('staff', 'staff_id')->where('status', 1),
                Rule::unique('users', 'staff_id'),
            ],
            'username' => [
                'required',
                'string',
                'max:64',
                'unique:users,username',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'staff_id' => $validated['staff_id'],
                'username' => $validated['username'],
                'password' => $validated['password'],
            ]);

            UserLevel::create([
                'staff_id' => $user->staff_id,
            ]);

            return $user;
        });

        $user->load(['staff', 'userLevel']);

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => new UserResource($user),
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::with(['staff', 'userLevel'])
            ->where('username', $credentials['username'])
            ->first();

        if (
            !$user ||
            !Hash::check($credentials['password'], $user->password)
        ) {
            throw ValidationException::withMessages([
                'username' => [
                    'The provided credentials are incorrect.',
                ],
            ]);
        }

        $token = $user->createToken('school-mis-token')
            ->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => (new UserResource($user))->resolve($request),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }

    public function me(Request $request)
    {
        return new UserResource(
            $request->user()->load(['staff', 'userLevel'])
        );
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                'dimensions:max_width=4000,max_height=4000',
            ],
        ]);

        $user = $request->user();

        $oldPath = $user->avatar_path;

        $path = $request->file('avatar')->store(
            'avatars',
            'public'
        );

        if (!$path) {
            return response()->json([
                'message' => 'Unable to upload avatar.',
            ], 500);
        }

        $user->avatar_path = $path;
        $user->save();

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        $user->load(['staff', 'userLevel']);

        return response()->json([
            'message' => 'Avatar uploaded successfully.',
            'avatar_url' => $user->avatar_url,
            'user' => new UserResource($user),
        ]);
    }
}