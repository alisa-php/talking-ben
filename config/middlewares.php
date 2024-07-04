<?php

/**
 * Мидлвари.
 *
 * Позвляет обрабатывать запрос от Диалогов до того
 * как он будет обработан в обработчике.
 */
return [
    \App\Middlewares\RequestToLogMiddleware::class,
];