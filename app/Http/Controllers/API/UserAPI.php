<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class UserAPI extends Controller
{
    function getAllUsers()
    {
        $result =  User::all();
        if ($result){
            return response()->json(['message' => 'the request has been succeeded','data' => $result],201 );
        }
        else
        {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    function getUsersByID($user_id)
    {
        $result = User::find($user_id);
        if ($result){
            return response()->json(['message' => 'the request has been succeeded','data' => $result],201 );
        }
        else
        {
            return response()->json(['message' => 'Not found'], 404);
        }


    }

    function createUser(Request $request )
    {
        $user = new User;
        $user->name = $request->name;
        $user->age = $request->age;
        $user->email = $request->email;
        $result =  $user->save();
        if ($result)
        {
            return response()->json(['message' => 'User has been created','data' => $user] , 201  );
        }
        else
        {
            return response()->json(['message' => 'query parameters are incorrect'], 400);
        }

    }

    function updateUserByID($user_id,Request $request)
    {
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->age = $request->age;
        $user->email = $request->email;
        $result =  $user->save();

        if ($result)
        {
            return response()->json(['message' => 'User has been updated','data' => $user] , 201  );
        }
        else
        {
            return response()->json(['message' => 'query parameters are incorrect'], 400);
        }

    }

    function deleteUserByID($user_id)
    {
        $user = User::find($user_id);
        $user_temp = $user;
        $result = $user->delete();
        if ($result){
            return response()->json(['message' => 'User has been deleted','data' => $user_temp],201 );
        }
        else
        {
            return response()->json(['message' => 'query parameters are incorrect'], 404);
        }

    }
}
