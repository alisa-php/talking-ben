<?php

/** @var \Alisa\Alisa $alisa */

$alisa->onBeforeRun([\App\Controllers\MainController::class, 'beforeRun']);
$alisa->onStart([\App\Controllers\MainController::class, 'start']);
$alisa->onHelp([\App\Controllers\MainController::class, 'help']);
$alisa->onWhatCanYouDo([\App\Controllers\MainController::class, 'features']);
$alisa->onFallback([\App\Controllers\MainController::class, 'fallback']);
$alisa->onError([\App\Controllers\MainController::class, 'exception']);
$alisa->onIntent('BEN.BYE', [\App\Controllers\MainController::class, 'bye']);
$alisa->onCommand('статистика', [\App\Controllers\MainController::class, 'stats']);
$alisa->onIntent('BEN.YES', [\App\Controllers\MainController::class, 'yes']); // На "да" овтечаем "да"
$alisa->onIntent('BEN.NO', [\App\Controllers\MainController::class, 'no']); // На "нет" овтечаем "нет"
$alisa->onIntent('BEN.YES_OR_NO', [\App\Controllers\MainController::class, 'yesOrNo']);