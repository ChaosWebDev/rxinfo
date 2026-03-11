<?php

namespace Chaoswd\RxInfo\Traits;

trait Serializable
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}