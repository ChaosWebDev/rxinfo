<?php

use Chaoswd\RxInfo\Http\Request;

require_once __DIR__ . "/../vendor/autoload.php";

$request = Request::capture();
$response = $request->handle();

$test = json_decode($response->send(), true)['results'];

echo "<pre>";
print_r($test);
echo "</pre>";
