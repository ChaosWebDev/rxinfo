<?php

namespace Chaoswd\RxInfo\Http;

use Chaoswd\RxInfo\Exceptions\InvalidSearchException;
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

    public function handle(): Response
    {
        try {
            $query = isset($this->query['q']) ? trim($this->query['q']) : null;

            $this->validate($query);

            $results = (new MedicationSearch())->search($query);

            return new Response(results: $results);

        } catch (InvalidSearchException $e) {
            return new Response(results: [
                'error' => $e->getMessage(),
                'statusCode' => 400
            ]);
        } catch (\Throwable $e) {
            return new Response(results: [
                'error' => 'An unexpected error occurred.',
                'statusCode' => 500
            ]);
        }
    }

    private function validate(?string $query): void
    {
        if (!isset($query) || empty($query)) {
            throw new InvalidSearchException(
                "Invalid search. Please use search key of 'q'."
            );
        }
    }
}