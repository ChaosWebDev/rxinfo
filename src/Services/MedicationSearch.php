<?php

namespace Chaoswd\RxInfo\Services;

class MedicationSearch
{
    public function search(?string $query = null): array
    {
        $file = __DIR__ . '/../../test/medications.json';

        $data = json_decode(file_get_contents($file), true);

        if (!$query) {
            return $data;
        }

        $query = strtolower($query);

        return array_values(array_filter($data, function ($med) use ($query) {

            if (str_contains(strtolower($med['name']), $query)) {
                return true;
            }

            foreach ($med['brandNames'] ?? [] as $brand) {
                if (str_contains(strtolower($brand), $query)) {
                    return true;
                }
            }

            return false;

        }));
    }
}