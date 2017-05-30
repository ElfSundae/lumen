<?php

use App\Support\Http\ApiResponse;
use GuzzleHttp\Client as HttpClient;

if (! function_exists('urlsafe_base64_encode')) {
    /**
     * Encodes the given data with base64, and returns an URL-safe string.
     *
     * @param  string  $data
     * @return string
     */
    function urlsafe_base64_encode($data)
    {
        return strtr(base64_encode($data), ['+' => '-', '/' => '_', '=' => '']);
    }
}

if (! function_exists('urlsafe_base64_decode')) {
    /**
     * Decodes a base64 encoded data.
     *
     * @param  string  $data
     * @param  bool  $strict
     * @return string
     */
    function urlsafe_base64_decode($data, $strict = false)
    {
        return base64_decode(strtr($data.str_repeat('=', (4 - strlen($data) % 4)), '-_', '+/'), $strict);
    }
}

if (! function_exists('string_value')) {
    /**
     * Converts any type to a string.
     *
     * @param  mixed  $value
     * @return string
     */
    function string_value($value, $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    {
        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                return (string) $value;
            }

            if (method_exists($value, 'toArray')) {
                $value = $value->toArray();
            }
        }

        return is_string($value) ? $value : json_encode($value, $jsonOptions);
    }
}

if (! function_exists('api')) {
    /**
     * Create a new API response.
     *
     * @return \App\Support\Http\ApiResponse
     */
    function api(...$args)
    {
        return new ApiResponse(...$args);
    }
}

if (! function_exists('current_app_key')) {
    /**
     * Get the app key for the current api client.
     *
     * @return string|null
     */
    function current_app_key()
    {
        return app('request')->attributes->get('current_app_key');
    }
}

if (! function_exists('http_client')) {
    /**
     * Create a Guzzle http client.
     *
     * @param  array  $config
     * @return \GuzzleHttp\Client
     */
    function http_client($config = [])
    {
        return new HttpClient(
            array_merge([
                'connect_timeout' => 5,
                'timeout' => 20,
            ], $config)
        );
    }
}

if (! function_exists('request_url')) {
    /**
     * Request an URL.
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array   $options
     * @return GuzzleHttp\Psr7\Response|false
     */
    function request_url($url, $method = 'GET', $options = [])
    {
        try {
            return http_client()->request($method, $url, $options);
        } catch (Exception $e) {
        }

        return false;
    }
}

if (! function_exists('request_json')) {
    /**
     * Request an URL, and return the Json data.
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array   $options
     * @return mixed
     */
    function request_json($url, $method = 'GET', $options = [])
    {
        array_set($options, 'headers.Accept', 'application/json');

        if ($content = (string) request_url($url, $method, $options)->getBody()) {
            return json_decode($content, true);
        }
    }
}
