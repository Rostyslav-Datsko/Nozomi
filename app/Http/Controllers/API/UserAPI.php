<?php

namespace App\Http\Controllers\API;
use App\Core\Token as Token;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class UserAPI extends Controller
{
    function getAllUsers(Request $request): JsonResponse
    {
        $token = new Token();
        if (!$token->checkTokenForAvailability($request->bearerToken()))
            return response()->json(['message' => 'Unauthorized '], 401 );


        $result =  User::all();
        if ($result){
            return response()->json(['message' => 'the request has been succeeded','data' => $result],201 );
        }
        else
        {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    function getUsersByID(Request $request, $userId): JsonResponse
    {
        $token = new Token();
        if (!$token->checkTokenForAvailability($request->bearerToken())){
            return response()->json(['message' => 'Unauthorized '], 401 );
        }

        $result = User::find($userId);
        if ($result){
            return response()->json(['message' => 'the request has been succeeded','data' => $result],201 );
        }
        else
        {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    function createUser(Request $request ): JsonResponse
    {
        $token = new Token();
        if (!$token->checkTokenForAvailability($request->bearerToken())){
            return response()->json(['message' => 'Unauthorized '], 401 );
        }

        $user = new User;
        $user->name = $request->name;
        $user->age = $request->age;
        $user->email = $request->email;
        $user->password = md5($request->password);
        $result =  $user->save();
        if ($result)
        {
            return response()->json(['message' => 'User has been created'], 200);
        }
        else
        {
            return response()->json(['message' => 'query parameters are incorrect'], 400);
        }

    }

    function updateUserByID($user_id,Request $request): JsonResponse
    {
        $token = new Token();
        if (!$token->checkTokenForAvailability($request->bearerToken())){
            return response()->json(['message' => 'Unauthorized '], 401 );
        }

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->age = $request->age;
        $user->email = $request->email;
        $result =  $user->save();

        if ($result)
        {
            return response()->json(['message' => 'User has been updated'], 200);
        }
        else
        {
            return response()->json(['message' => 'query parameters are incorrect'], 400);
        }

    }

    function deleteUserByID(Request $request, $user_id): JsonResponse
    {
        $token = new Token();
        if (!$token->checkTokenForAvailability($request->bearerToken())){
            return response()->json(['message' => 'Unauthorized '], 401 );
        }

        $user = User::find($user_id);
        $result = $user->delete();
        if ($result){
            return response()->json(['message' => 'User has been deleted'],200 );
        }
        else
        {
            return response()->json(['message' => 'query parameters are incorrect'], 404);
        }

    }




}
