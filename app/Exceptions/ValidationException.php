<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends Exception
{
    /**
     * The errors message bag.
     *
     * @var MessageBag
     */
    public $errors;

    /**
     * The recommended response to send to the client.
     *
     * @var Response|null
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  MessageBag  $errors
     * @param  Response    $response
     * @return void
     */
    public function __construct(MessageBag $errors, ?Response $response = null)
    {
        $this->errors   = $errors;
        $this->response = $response;

        $message = join("\n", $errors->all());
        parent::__construct($message);
    }

    /**
     * Get the underlying response instance.
     *
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
