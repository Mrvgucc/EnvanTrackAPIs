<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // logout islemi
    function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logged out successfully."
        ]);

    }


}
