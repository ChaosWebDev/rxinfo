<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Chaoswd\RxInfo\Http\Request;

Request::capture()
    ->handle()
    ->send();