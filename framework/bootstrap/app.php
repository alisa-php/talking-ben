<?php

use Alisa\Alisa;
use App\Models\User;
use Dotenv\Dotenv;
use Illuminate\Container\Container;

Dotenv::createImmutable(__DIR__ . '/../..')->load();

$config = require __DIR__ . '/../../config/app.php';
$config['assets'] = require __DIR__ . '/../../config/assets.php';
$config['buttons'] = require __DIR__ . '/../../config/buttons.php';
$config['components'] = require __DIR__ . '/../../config/components.php';
$config['middlewares'] = require __DIR__ . '/../../config/middlewares.php';

$alisa = new Alisa($config);

Container::getInstance()->singleton(Alisa::class, fn () => $alisa);

require __DIR__ . '/database.php';

User::register();

foreach (require __DIR__ . '/../../config/routes.php' as $route) {
    require __DIR__ . '/../../routes/' . trim($route, '\/') . '.php';
}

return $alisa;