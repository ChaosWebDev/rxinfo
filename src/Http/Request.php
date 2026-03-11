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

            http_response_code(200);
            return new Response(results: $results);

        } catch (InvalidSearchException $e) {
            http_response_code(400);
            return new Response(results: ['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            http_response_code(500);
            return new Response(results: ['error' => 'An unexpected error occurred.']);
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