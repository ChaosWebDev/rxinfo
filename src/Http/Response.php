<?php

namespace Chaoswd\RxInfo\Http;

use Chaoswd\RxInfo\Traits\Serializable;

class Response
{
    use Serializable;

    public function __construct(public $results)
    {
    }

    public function send()
    {
        return $this->toJson() ?? null;
    }
}