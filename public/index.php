<?php

use App\Core\Http\Request;

$app = require __DIR__.'/../bootstrap/app.php';

$response = $app->run(Request::capture());

$response->send();

exit();