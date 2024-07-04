<?php

namespace App\Models;

use Framework\Database\Models\Auth;

class User extends Auth
{
    protected $fillable = [
        'id',
        'is_guest',
        'question_count',
        'call_count',
    ];

    protected $casts = [
        //
    ];
}