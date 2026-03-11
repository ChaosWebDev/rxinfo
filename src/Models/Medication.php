<?php

namespace Chaoswd\RxInfo\Models;

class Medication
{
    public int $rxuin;              // Uniform Identification Number
    public string $name;            // Formulary Name

    public array $components = [];  // Active ingredients
    public array $strength = [];    // Strength data

    public string $doseForm;        // Tablet, Capsule, Injection
    public string $route;           // Oral, IV, Topical

    public array $brandNames = [];  // Zoloft, Advil, etc.

    public array $classes = [];     // SSRI, CNS Stimulant, etc.

    public array $ndcCodes = [];    // FDA product identifiers

    public function __construct()
    {
        //
    }


}