<?php

namespace Framework\Database\Models;

use Alisa\Alisa;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public static function register(): static
    {
        return once(function () {
            /** @var \Alisa\Alisa $alisa */
            $alisa = Container::getInstance()->make(Alisa::class);

            $userId = $alisa->context()->userId();

            if (!$userId) {
                $userId = $alisa->context()->applicationId();
                $guest = true;
            }

            return static::query()->createOrFirst([
                'id' => $userId,
            ], [
                'is_guest' => $guest ?? false,
            ]);
        });
    }

    public static function current(): static
    {
        return static::register();
    }
}