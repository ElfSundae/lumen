<?php

namespace App\Http\Controllers\Api;

use ElfSundae\Laravel\Api\Token;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    /**
     * Generate a new api token.
     *
     * @return \ElfSundae\Laravel\Api\Http\ApiResponse
     */
    public function refreshToken(Token $token)
    {
        return api(['data' => $token->generateDataForKey(current_app_key())]);
    }
}
