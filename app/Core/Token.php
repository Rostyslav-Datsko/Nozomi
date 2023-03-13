<?php

namespace App\Core;

use DateInterval;
use App\Models\Token as TokenModel;
class Token
{
    function tokenMaker($data)
    {
        $tokenValue = md5($data);
        $token = new TokenModel();
        $token->token = $tokenValue;
        $token->save();
    }

    function checkTokenForAvailability($verificationToken): bool
    {
        if ($verificationToken === null)
            return false;

        $token = TokenModel::where('token', "$verificationToken")->first();
        $time = $token->created_at;


        if ( $this->checkTokenTimeUp($time) ){
            $token->delete();
            return false;
        }
        return true;
    }

    function checkTokenTimeUp($time): bool
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
