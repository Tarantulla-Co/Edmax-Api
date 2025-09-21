<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/signup",
	 *     tags={"Authentication"},
	 *     summary="User registration",
	 *     description="Register a new user account",
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"name","email","password"},
	 *             @OA\Property(property="name", type="string", example="John Doe"),
	 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
	 *             @OA\Property(property="password", type="string", format="password", example="password123", minLength=6)
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=201,
	 *         description="User registered successfully",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Signup successful"),
	 *             @OA\Property(property="user", ref="#/components/schemas/User"),
	 *             @OA\Property(property="data", type="integer", example=201)
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=422,
	 *         description="Validation error",
	 *         @OA\JsonContent(ref="#/components/schemas/Error")
	 *     )
	 * )
	 */
	public function signup(Request $request)
	{
		$code = 201;
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email',
			'password' => 'required|string|min:6',
		]);

		$user = User::create([
			'name' => $validated['name'],
			'email' => $validated['email'],
			'password' => Hash::make($validated['password']),
		]);

		return response()->json([
			'message' => 'Signup successful',
			'user' => $user,
			'code' => $code
		], $code);
		
	}


public function show($id, Request $request)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'message' => 'User not found',
            'code' => 404
        ], 404);
    }

    return response()->json([
        'message' => 'User retrieved successfully',
        'user' => $user,
        'code' => 200
    ], 200);
}

	/**
	 * @OA\Post(
	 *     path="/api/signin",
	 *     tags={"Authentication"},
	 *     summary="User login",
	 *     description="Authenticate user and return user information",
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"email","password"},
	 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
	 *             @OA\Property(property="password", type="string", format="password", example="password123")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=201,
	 *         description="Login successful",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Signin successful"),
	 *             @OA\Property(property="user", ref="#/components/schemas/User"),
	 *             @OA\Property(property="code", type="integer", example=201)
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Invalid credentials",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Invalid credentials")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=422,
	 *         description="Validation error",
	 *         @OA\JsonContent(ref="#/components/schemas/Error")
	 *     )
	 * )
	 */
	public function signin(Request $request)
	{
		$code = 201;
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required|string',
		]);

		$user = User::where('email', $credentials['email'])->first();

		if (!$user || !Hash::check($credentials['password'], $user->password)) {
			return response()->json(['message' => 'Invalid credentials'], 401);
		}

		$token = $user->createToken('api')->plainTextToken;

		return response()->json([
			'message' => 'Signin successful',
			'user' => $user,
			'token' => $token,
			'token_type' => 'Bearer',
			'code' => $code
		], $code);
	}

	/**
	 * @OA\Get(
	 *     path="/api/me",
	 *     tags={"Authentication"},
	 *     summary="Get authenticated user",
	 *     description="Get the currently authenticated user information",
	 *     security={{"sanctum":{}}},
	 *     @OA\Response(
	 *         response=200,
	 *         description="User information retrieved successfully",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Authenticated user retrieved successfully"),
	 *             @OA\Property(property="user", ref="#/components/schemas/User"),
	 *             @OA\Property(property="code", type="integer", example=200)
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Unauthenticated",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Unauthenticated")
	 *         )
	 *     )
	 * )
	 */
	public function me(Request $request)
	{
		$user = $request->user();
		
		if (!$user) {
			return response()->json([
				'message' => 'Unauthenticated',
				'code' => 401
			], 401);
		}

		return response()->json([
			'message' => 'Authenticated user retrieved successfully',
			'user' => $user,
			'code' => 200
		], 200);
	}
}
