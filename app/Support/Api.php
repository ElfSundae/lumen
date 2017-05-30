<?php

namespace App\Support;

use Exception;

class Api
{
    /**
     * The app key of this app for api request.
     *
     * @return string
     */
    public static function defaultAppKey()
    {
        if (! ($apps = config('api.apps'))) {
            throw new Exception('The apps for api is not configured.', 1);
        }

        return (string) array_first(array_keys($apps));
    }

    public static function appKeyForName($appName)
    {
        return md5((string) $appName.config('app.key'));
    }

    public static function generateAppSecret($appKey)
    {
        return sha1(encrypt($appKey));
    }

    public static function generateAppSecretForName($appName)
    {
        return static::generateAppSecret(static::appKeyForName($appName));
    }

    public static function generateToken($appKey, $time)
    {
        if ($appSecret = config('api.apps.'.$appKey.'.secret')) {
            return substr(md5($appSecret.(string) $time), 10, 20);
        }
    }

    public static function verifyToken($token, $appKey, $time)
    {
        return $token && $appKey && $time && $token === static::generateToken($appKey, $time);
    }
}
