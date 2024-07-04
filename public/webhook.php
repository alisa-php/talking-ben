<?php

define('ALISA_START', time());

require __DIR__ . '/../vendor/autoload.php';

/** @var \Alisa\Alisa $alisa */
$alisa = require __DIR__ . '/../framework/bootstrap/app.php';

$alisa->run();