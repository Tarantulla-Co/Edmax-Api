<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Default hardcoded credentials
        $defaultEmail = "admin@edmax.com";
        $defaultPassword = "Edmax@123.$65";

        if ($request->email === $defaultEmail && $request->password === $defaultPassword) {
            return response()->json([
                'message' => 'Admin login successful',
                'admin' => [
                    'email' => $defaultEmail,
                ],
                'code' => 200,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials',
            'code' => 401,
        ], 401);
    }
}
