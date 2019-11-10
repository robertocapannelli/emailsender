<?php

require __DIR__ . '/vendor/autoload.php';

use Model\Request;

$request = new Request( "Ciccio", "ciao@ciccio.com", "234567889" );

echo $request->getName();


