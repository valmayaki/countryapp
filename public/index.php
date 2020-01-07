<?php

use App\Core\Http\Request;


require __DIR__.'/../vendor/autoload.php';

// ob_start();
session_start();
$app = require __DIR__.'/../bootstrap/app.php';

$response = $app->run(Request::capture());

$response->send();

// ob_end_flush();
exit();