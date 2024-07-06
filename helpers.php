<?php

use App\Models\User;

if (!function_exists('project_path')) {
    function project_path(?string $path = ''): string
    {
        return rtrim(__DIR__ . '/' . $path, '\/');
    }
}

if (!function_exists('storage_path')) {
    function storage_path(?string $path = ''): string
    {
        return rtrim(project_path('storage/' . $path), '\/');
    }
}

if (!function_exists('user')) {
    function user(): User
    {
        return User::current();
    }
}

if (!function_exists('roll')) {
    /**
     * $chances = [
     *   ['%' => 10, 'result' => 'это вероятность 10%'],
     *   ['%' => 50, 'result' => 'это вероятность 50%'],
     *   ['%' => 4.5, 'result' => 'это вероятность 4.5%'],
     *   ['%' => 5.5, 'result' => 'это вероятность 5.5%'],
     *   ['%' => 30, 'result' => 'это вероятность 30%'],
     * ];
     *
     * @param array $chances
     * @return mixed
     * @throws Exception
     */
    function roll(array $chances): mixed
    {
        $sum = 0;
        foreach ($chances as $item) {
            $sum += (int)($item['%'] * 100);
        }

        if ($sum !== 10000) {
            throw new Exception("Сумма вероятностей должна быть равна 100, текущая сумма: " . ($sum / 100));
        }

        $random = mt_rand(1, 10000);
        $currentSum = 0;

        foreach ($chances as $item) {
            $currentSum += (int)($item['%'] * 100);
            if ($random <= $currentSum) {
                return $item['result'];
            }
        }

        // Если по какой-то причине мы дошли до этой точки, возвращаем случайный элемент
        return $chances[array_rand($chances)]['result'];
    }
}

