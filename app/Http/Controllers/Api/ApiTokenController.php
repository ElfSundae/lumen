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
        $token = Api::tokenForKey($key, $time);

        return api(compact('key', 'time', 'token'));
    }
}
