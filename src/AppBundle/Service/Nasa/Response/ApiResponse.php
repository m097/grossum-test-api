<?php

namespace AppBundle\Service\Nasa\Response;

use AppBundle\Service\Nasa\Exception\InvalidJsonException;

class ApiResponse
{
    protected $statusCode;

    protected $response;

    public function __construct($statusCode, $responseBody = null)
    {
        $this->statusCode = (int) $statusCode;

        if (!empty($responseBody)) {
            $response = \GuzzleHttp\json_decode($responseBody, true);

            if (!$response && JSON_ERROR_NONE !== ($error = json_last_error())) {
                throw new InvalidJsonException(
                    "Invalid JSON in the API response body. Error code #$error",
                    $error
                );
            }

            $this->response = $response;
        }
    }

    public function getStatusCode() :int
    {
        return $this->statusCode;
    }

    public function isSuccessful() : bool
    {
        return $this->statusCode < 400;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->response[$offset]);
    }


    public function offsetGet($offset)
    {
        if (!isset($this->response[$offset])) {
            throw new \InvalidArgumentException("Property \"$offset\" not found");
        }

        return $this->response[$offset];
    }
}
