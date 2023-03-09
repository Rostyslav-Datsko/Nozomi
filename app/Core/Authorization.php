<?php

namespace App\Core;

use App\Core\Token as Token;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authorization
{
    function authorization(Request $request): JsonResponse
    {
        $user = User::where('email', "$request->email")->first();
        if ($user['password'] === md5($request->password)){
            $token = new Token();
            $token->tokenMaker($request->password);
            return response()->json(['message' => 'Authorization was successful',],200 );
        }
        else
        {
            return response()->json(['message' => 'password or login is incorrect'], 404);
        }

    }
}
