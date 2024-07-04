<?php

use App\Models\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

$config = require __DIR__ . '/../../config/database.php';

$connection = $config['connections'][$config['default']];

if ($connection['driver'] === 'sqlite' && !file_exists($connection['database'])) {
    touch($connection['database']);
}

$capsule = new Capsule;
$capsule->addConnection($connection);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();