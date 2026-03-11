<?php

namespace Chaoswd\RxInfo\Http;

use Chaoswd\RxInfo\Services\MedicationSearch;



class Request
{
    protected array $query;

    public static function capture(): self
    {
        $instance = new self();
        $instance->query = $_GET;

        return $instance;
    }

    public function handle()
    {
        $query = $this->query['q'] ?? null;

        $results = (new MedicationSearch())->search($query);

        return new Response($results);
    }
}