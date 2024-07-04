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

