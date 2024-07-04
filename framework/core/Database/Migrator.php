<?php

namespace Framework\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migrator
{
    public static function up(): void
    {
        require __DIR__ . '/../../../framework/bootstrap/database.php';

        foreach (glob(__DIR__ . '/../../../database/migrations/*.php') as $file) {
            $migration = require $file;
            $migration->up(Capsule::schema());

            echo basename($file) . '... up' .  PHP_EOL;
        }
    }

    public static function down(): void
    {
        require __DIR__ . '/../../../framework/bootstrap/database.php';

        foreach (array_reverse(glob(__DIR__ . '/../../../database/migrations/*.php')) as $file) {
            $migration = require $file;
            $migration->down(Capsule::schema());

            echo basename($file) . '... down' .  PHP_EOL;
        }
    }

    public static function fresh(): void
    {
        self::down();
        self::up();
    }
}