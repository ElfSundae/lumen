<meta name="api-key" content="{{ $key = App\Support\Api::defaultAppKey() }}">
<meta name="api-time" content="{{ $time = time() }}">
<meta name="api-token" content="{{ App\Support\Api::tokenForKey($key, $time) }}">
