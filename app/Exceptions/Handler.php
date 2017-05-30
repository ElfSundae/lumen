<?php

namespace App\Exceptions;

use App\Support\Http\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        ActionFailureException::class,
        InvalidInputException::class,
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
        if ($e instanceof ActionFailureException || $e instanceof InvalidInputException) {
            return $this->convertExceptionToApiResponse($e);
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
     * @return \App\Support\Http\ApiResponse
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
     * @return \App\Support\Http\ApiResponse
     */
    protected function createApiResponse($message = null, $code = null)
    {
        $response = api($message, $code);

        if (($successCode = $response::successCode()) === $response->getCode()) {
            $response->setCode(-1 * $successCode);
        }

        if (empty($response->getMessage())) {
            $response->setMessage('发生错误，操作失败！');
        }

        return $response;
    }
}
