<?php

namespace App\Core;

use DateInterval;
use App\Models\Token as Token;

class Token
{
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
        $removalTime = $time->format('Y-m-d h:i:s');
        $date = date('Y-m-d h:i:s');

        $removalTime = strtotime($removalTime);
        $date = strtotime($date);
        $diff = $removalTime - $date;
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
