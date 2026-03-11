<?php

namespace Chaoswd\RxInfo\Services;

class MedicationSearch
{
    protected string $path;

    public function __construct()
    {
        $this->path = dirname(__DIR__, 2) . '/test/medications.json';
    }

    public function search(string $query): array
    {
        if (!file_exists($this->path)) {
            return [];
        }

        $contents = file_get_contents($this->path);
        $medications = json_decode($contents, true) ?? [];

        $query = mb_strtolower(trim($query));

        return array_values(array_filter($medications, function ($medication) use ($query) {
            $name = mb_strtolower($medication['name'] ?? '');
            $brands = array_map('mb_strtolower', $medication['brandNames'] ?? []);
            $components = array_map('mb_strtolower', $medication['components'] ?? []);

            if (str_contains($name, $query)) {
                return true;
            }

            foreach ($brands as $brand) {
                if (str_contains($brand, $query)) {
                    return true;
                }
            }

            foreach ($components as $component) {
                if (str_contains($component, $query)) {
                    return true;
                }
            }

            return false;
        }));
    }
}