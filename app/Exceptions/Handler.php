<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ElfSundae\Laravel\Api\Exceptions\ApiResponseException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        ApiResponseException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ApiResponseException) {
            return $e->getResponse();
        }

        $response = parent::render($request, $e);

        if ($e instanceof HttpException) {
            return $this->renderHttpException($response, $e);
        }

        return $response;
    }

    /**
     * Render a http exception.
     *
     * @param  \Illuminate\Http\Response $response
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Illuminate\Http\Response
     */
    protected function renderHttpException(Response $response, HttpException $e)
    {
        if (! ($message = $e->getMessage())) {
            switch ($response->getStatusCode()) {
                case 401:
                $message = '401 Unauthorized';
                break;

                case 403:
                $message = '403 Forbidden';
                break;

                case 404:
                $message = '404 Not Found';
                break;
            }
        }

        if ($message) {
            $response->setContent('<title>'.$message.'</title><center><h1>'.$message.'</h1></center><hr>');
        }

        return $response;
    }

    /**
     * Create an API response for the given exception.
     *
     * @param  \Exception  $e
     * @return \ElfSundae\Laravel\Api\Http\ApiResponse
     */
    protected function convertExceptionToApiResponse(Exception $e)
    {
        return $this->createApiResponse($e->getMessage(), $e->getCode());
    }

    /**
     * Create an API response.
     *
     * @param  mixed  $message
     * @param  int  $code
     * @return \ElfSundae\Laravel\Api\Http\ApiResponse
     */
    protected function createApiResponse($message = null, $code = null)
    {
        $response = api($message, $code);

        if ($response->getCode() === $response::successCode()) {
            $response->setCode(-1 * $response->getCode());
        }

        return $response;
    }
}
