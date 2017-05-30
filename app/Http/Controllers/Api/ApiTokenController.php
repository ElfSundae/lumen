<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\Api;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    /**
     * Generate a new api token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(Request $request)
    {
        $key = current_app_key();
        $time = time();
        $token = Api::generateToken($key, $time);

        return api([
            'data' => ['_key' => $key, '_time' => $time, '_token' => $token],
            'parameters' => "_key=$key&_time=$time&_token=$token",
            'headers' => ['X-API-KEY' => $key, 'X-API-TIME' => $time, 'X-API-TOKEN' => $token],
        ]);
    }
}
