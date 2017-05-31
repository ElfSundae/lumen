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
        static $defaultAppKey = null;

        if (is_null($defaultAppKey)) {
            if (empty($apps = config('api.apps'))) {
                throw new Exception('The apps for api is not configured.', 1);
            }

            $defaultAppKey = (string) array_first(array_keys($apps));
        }

        return $defaultAppKey;
    }

    public static function appKeyForName($appName)
    {
        return md5((string) $appName.app('encrypter')->getKey());
    }

    public static function generateAppSecretForKey($appKey)
    {
        return sha1(encrypt($appKey));
    }

    public static function generateAppSecretForName($appName)
    {
        return static::generateAppSecretForKey(static::appKeyForName($appName));
    }

    public static function token($key, $secret, $time)
    {
        return substr(md5($secret.(string) $time), 10, 20);
    }

    public static function tokenForKey($key, $time)
    {
        if ($secret = config('api.apps.'.$key.'.secret')) {
            return $this->token($key, $secret, $time);
        }
    }

    public static function tokenData($key, $secret, $time = null)
    {
        $time = $time ?: time();

        return [
            'key' => (string) $key,
            'time' => $time,
            'token' => static::token($key, $secret, $time),
        ];
    }

    public static function tokenDataForKey($key, $time = null)
    {
        if ($secret = config('api.apps.'.$key.'.secret')) {
            return $this->tokenData($key, $secret, $time);
        }
    }

    public static function verifyToken($token, $key, $time)
    {
        return $token && $key && $time && $token === static::tokenForKey($key, $time);
    }
}
