<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller for user authentication
 */

 
class UserAuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     @OA\Response(response=200, description="User created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function register(Request $request){
        $registerUserData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',
            'role_id' => 'required|exists:roles,id',

        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
            'role_id' => $registerUserData['role_id'],

        ]);
        return response()->json([
            'message' => 'User Created ',
            'user' => $user,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and generate token",
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request){

        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8',

        ]);

        if(!$token = auth()->attempt($loginUserData)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        return response()->json([
            'message' => 'Logged In',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60 * 60,
            'user' => auth()->user(),
        ],200);

    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user and invalidate tokens",
     *     @OA\Response(response=200, description="Logged out successfully")
     * )
     */
    public function logout(){
        
        auth()->logout();
        
        return response()->json([
            'message' => 'Logged Out'
        ]);
    }

       /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Refresh JWT token",
     *     @OA\Response(response=200, description="Token refreshed successfully"),
     *     @OA\Response(response=401, description="Token refresh failed")
     * )
     */
    public function refresh()
    {
        try {
            $newToken = auth()->refresh();

            return response()->json([
                'message' => 'Token Refreshed',
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token Refresh Failed'], 401);
        }
    }
}
