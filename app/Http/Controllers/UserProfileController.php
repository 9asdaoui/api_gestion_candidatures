<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Display the authenticated user's profile
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('skills');
        return response()->json($user);
    }

    /**
     * Update the authenticated user's profile
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'sometimes|string|max:20|nullable',
            'password' => 'sometimes|string|min:8|nullable',
            'skills' => 'sometimes|array',
            'skills.*' => 'exists:skills,id'
        ]);

        // Update basic user information
        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        
        if (isset($validatedData['phone_number'])) {
            $user->phone_number = $validatedData['phone_number'];
        }
        
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        
        $user->save();
        
        // Update skills if provided
        if (isset($validatedData['skills'])) {
            $user->skills()->sync($validatedData['skills']);
        }
        
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->fresh()->load('skills')
        ]);
    }
}