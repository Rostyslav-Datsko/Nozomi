<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class UserAPI extends Controller
{
    function getAllUsers(Request $request)
    {
        if ( false === $this->checkTokenForAvailability($request->bearerToken()) ){
            return response()->json(['message' => 'Unauthorized '], 401 );
        }

        $result =  User::all();
        if ($result){
            return response()->json(['message' => 'the request has been succeeded','data' => $result],201 );
        }
        else
        {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    function getUsersByID(Request $request, $user_id)
    {
        if ( false === $this->checkTokenForAvailability($request->bearerToken()) ){
            return response()->json(['message' => 'Unauthorized '], 401 );
        }

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
        if ( false === $this->checkTokenForAvailability($request->bearerToken()) ){
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

    function updateUserByID($user_id,Request $request)
    {
        if ( false === $this->checkTokenForAvailability($request->bearerToken()) ){
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

    function deleteUserByID(Request $request, $user_id)
    {
        if ( false === $this->checkTokenForAvailability($request->bearerToken()) ){
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

    function authorization(Request $request)
    {
        $user = User::where('email', "$request->email")->first();
        if ($user){
            if ($user['password'] === md5($request->password)){
                $this->tokenMaker($request->password);
                return response()->json(['message' => 'Authorization was successful',],200 );
            }
            else
            {
                return response()->json(['message' => 'password or login is incorrect'], 404);
            }

        }
        else
        {
            return response()->json(['message' => 'password or login is incorrect'], 404);
        }

    }

    function tokenMaker($data)
    {
        $token_value = md5($data);
        $token = new Token();
        $token->token = $token_value;
        $token->save();
    }

    function checkTokenForAvailability($verification_token)
    {
        $token = Token::where('token', "$verification_token")->first();
        $time = $token->created_at;


        if ( $this->checkTokenTimeUp($time) ){
            $token->delete();
            return false;
        }
            return true;
    }

    function checkTokenTimeUp($time)
    {
        $time->add(new DateInterval('PT' . 15 . 'M'));
        $removal_time = $time->format('Y-m-d h:i:s');
        $date = date('Y-m-d h:i:s');

        $removal_time = strtotime($removal_time);
        $date = strtotime($date);
        $diff = $removal_time-$date;
        if ($diff <= 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
