<?php

namespace App\Controllers;

use Alisa\Context;
use Alisa\Support\Markup;
use Alisa\Yandex\Sessions\Session;
use App\Models\User;
use Throwable;

class MainController
{
    public function beforeRun(Context $context)
    {
        if (!Session::get('already_call')) {
            Session::set('already_call', true);
            user()->increment('call_count');
        }
    }

    public function start(Context $context)
    {
        if (!Session::get('already_call')) {
            Session::set('already_call', true);
            user()->increment('call_count');
        }

        $text = Markup::variant([
            'Выполняется звонок Б{{е},{+э}}ну...',
            'Звоню Б{{е},{+э}}ну, секунду...',
            'Звоню Б{{е},{+э}}ну, одну минуту...',
            'Минуточку, набираю Б{{е},{+э}}на...',
        ]);

        $context->reply("
            {pause:550}

            📞 {$text}

            {text:💬 Задавай вопросы на которые  можно ответить <<<да>>> или <<<нет>>>.}

            {pause:550}

            {audio:allo}
        ", buttons: 'main');
    }

    public function help(Context $context)
    {
        $context->reply('
            💬 Сейчас ты разговариваешь с Б{{е},{+э}}ном, задавай ему любые вопросы на которые можно ответить <<<да>>> или <<<нет>>>.

            💬 Чтобы закончить, скажи ему <<<пока>>>.

            💬 А чтобы узнать статистику, скажи <<<статистика>>>.

            📞 Передаю трубку обратно Б{{е},{+э}}ну.

            {audio:ben}
        ', buttons: 'main');
    }

    public function features(Context $context)
    {
        $context->reply('
            💬 Задавай любые вопросы Б{{е},{+э}}ну, а он ответит: <<<да>>> или <<<нет>>>.

            📞 Передаю трубку обратно Б{{е},{+э}}ну.

            {audio:ben}
        ', buttons: 'main');
    }

    public function bye(Context $context)
    {
        $context->finish('💬🐶 ...', '{audio:phone-drop}');
    }

    public function stats(Context $context)
    {
        $userQuestionCount = user()->question_count;
        $userCallCount = user()->call_count;

        $totalQuestionCount = User::sum('question_count');
        $totalCallCount = User::sum('call_count');

        if ($totalQuestionCount != 0) {
            $userQuestionPercentage = round(($userQuestionCount / $totalQuestionCount) * 100);
        } else {
            $userQuestionPercentage = 0;
        }

        if ($totalCallCount != 0) {
            $userCallPercentage = round(($userCallCount / $totalCallCount) * 100);
        } else {
            $userCallPercentage = 0;
        }

        $context->reply("
            Вы позвонили Б{{е},{+э}}ну 📞 {{$userCallCount}: раз, раза, раз} и задали 💬 {{$userQuestionCount}: вопрос, вопроса, вопросов}!

            А всего пользователи Яндекса позвонили Б{{е},{+э}}ну 📞 {{$totalCallCount}: раз, раза, раз} (из них ваши составляют {$userCallPercentage}%) и задали 💬 {{$totalQuestionCount}: вопрос, вопроса, вопросов} (из них ваши составляют {$userQuestionPercentage}%).

            📞 Передаю трубку обратно Б{{е},{+э}}ну.

            {audio:ben}
        ", buttons: 'main');
    }

    public function fallback(Context $context)
    {
        user()->increment('question_count');

        $dice = mt_rand(1, 10);

        if (in_array($dice, [1, 2, 3])) {
            $text = '💬🐶 Yee-es...';
            $sound = 'yes';
        }

        if (in_array($dice, [4, 5, 6])) {
            $text = '💬🐶 No.';
            $sound = 'no';
        }

        if (in_array($dice, [7, 8, 9])) {
            $text = '💬🐶 Hoho-ho...';
            $sound = 'hohoho';
        }

        if (in_array($dice, [10])) {
            $text = '💬🐶 Ughh.';
            $sound = 'ughh';
        }

        $context->reply($text, '{audio:' . $sound . '}', buttons: 'main');
    }

    public function exception(Context $context, Throwable $exception)
    {
        $dir = storage_path('logs/exceptions/' . date('Y-m-d'));

        if (!file_exists($dir)) {
            mkdir($dir, 0776, true);
        }

        $file = $dir . '/exceptions.log';

        file_put_contents($file, '[' . date('d.m.Y H:i:s') . "] \n[context] -> " . $context . "\n[exception] -> " . $exception . "\n\n", FILE_APPEND);
    }
}