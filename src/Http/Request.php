<?php

namespace Chaoswd\RxInfo\Http;

use Chaoswd\RxInfo\Traits\Serializable;


class Request
{
    use Serializable;
    
    public static $request;

    public function handle()
    {
        return $this->request ?? null;
    }
}