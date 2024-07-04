<?php

namespace App\Middlewares;

use Alisa\Context;
use FilesystemIterator;

class RequestToLogMiddleware
{
    public function __invoke(Context $context, $next)
    {
        $next($context);

        $dir = storage_path('logs/requests/' . date('Y-m-d'));

        if (!file_exists($dir)) {
            mkdir($dir, 0776, true);
        }

        $file = $dir . '/requests.log';

        if (file_exists($file) && filesize($file) > 1e+7) {
            $fs = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
            rename($file, $dir . '/requests-' . iterator_count($fs) . '.log');
        }

        $date = date('d.m.Y H:i:s');

        file_put_contents($file, "[$date] " . $context . "\n\n", FILE_APPEND);
    }
}