<?php

namespace Chaoswd\RxInfo\Services;

class MedicationSearch
{
    protected string $path;

    public function __construct()
    {
        $this->path = __DIR__ . '/../../test/medications.json';
    }

    public function search(?string $query = null, array $filters = []): array
    {
        if (!file_exists($this->path)) {
            return [];
        }

        $contents = file_get_contents($this->path);
        $medications = json_decode($contents, true);

        if (!is_array($medications)) {
            return [];
        }

        $query = $query !== null ? mb_strtolower(trim($query)) : null;
        $results = [];

        foreach ($medications as $medication) {
            if (!$this->matchesFilters($medication, $filters)) {
                continue;
            }

            $score = $query ? $this->scoreMedication($medication, $query) : 1;

            if ($query === null || $query === '' || $score > 0) {
                $medication['_score'] = $score;
                $results[] = $medication;
            }
        }

        usort($results, function ($a, $b) {
            return $b['_score'] <=> $a['_score'];
        });

        return array_map(function ($medication) {
            unset($medication['_score']);
            return $medication;
        }, $results);
    }

    protected function scoreMedication(array $medication, string $query): int
    {
        $score = 0;

        $name = mb_strtolower((string) ($medication['name'] ?? ''));
        $brands = array_map(
            fn($brand) => mb_strtolower((string) $brand),
            $medication['brandNames'] ?? []
        );
        $classes = array_map(
            fn($class) => mb_strtolower((string) $class),
            $medication['classes'] ?? []
        );

        if ($name === $query) {
            $score += 100;
        } elseif ($name !== '' && str_contains($name, $query)) {
            $score += 50;
        }

        foreach ($brands as $brand) {
            if ($brand === $query) {
                $score += 80;
            } elseif (str_contains($brand, $query)) {
                $score += 40;
            }
        }

        foreach ($classes as $class) {
            if ($class === $query) {
                $score += 20;
            } elseif (str_contains($class, $query)) {
                $score += 10;
            }
        }

        return $score;
    }

    protected function matchesFilters(array $medication, array $filters): bool
    {
        if (!empty($filters['form'])) {
            $form = mb_strtolower((string) ($medication['doseForm'] ?? ''));
            if ($form !== mb_strtolower($filters['form'])) {
                return false;
            }
        }

        if (!empty($filters['route'])) {
            $route = mb_strtolower((string) ($medication['route'] ?? ''));
            if ($route !== mb_strtolower($filters['route'])) {
                return false;
            }
        }

        if (!empty($filters['strength'])) {
            $strength = (string) ($medication['strength_mg'] ?? '');
            if ($strength !== (string) $filters['strength']) {
                return false;
            }
        }

        return true;
    }
}