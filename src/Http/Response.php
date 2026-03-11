<?php

namespace Chaoswd\RxInfo\Http;

use Chaoswd\RxInfo\Traits\Serializable;

class Response
{
    use Serializable;
    public static $response;

    public function handle()
    {
        return $this->toJson() ?? null;
    }
}