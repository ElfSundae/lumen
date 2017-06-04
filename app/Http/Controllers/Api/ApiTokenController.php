<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ElfSundae\LumenKit\Api\Token;

class ApiTokenController extends Controller
{
    /**
     * Generate a new api token.
     *
     * @return \ElfSundae\LumenKit\Http\ApiResponse
     */
    public function refreshToken(Token $token)
    {
        return api(['data' => $token->generateDataForKey(current_app_key())]);
    }
}
