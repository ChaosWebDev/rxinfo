<?php

namespace Chaoswd\RxInfo\Http;

use Chaoswd\RxInfo\Traits\Serializable;

class Response
{
    use Serializable;


    public function __construct(
        public array|object $results,
        public int $responseCode = 200
    ) {

    }

    public function send(): void
    {
        http_response_code($this->responseCode);
        header('Content-Type: application/json');

        echo $this->toJson();
    }
}