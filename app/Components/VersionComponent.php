<?php

namespace App\Components;

use Alisa\Component;
use Alisa\Context;

class VersionComponent extends Component
{
    public function register(string $version = null)
    {
        $this->alisa->onCommand(['версия', 'version'], function (Context $context) use ($version) {
            $context->reply("Версия навыка: {$version}");
        });
    }
}