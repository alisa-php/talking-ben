<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return new class {
    public function up(Builder $schema)
    {
        if (!$schema->hasTable('users')) {
            $schema->create('users', function (Blueprint $table) {
                $table->string('id', 64)->primary()->unique()->index()->comment('Идентификатор пользователя (user_id или appliaction_id если не авторизован)');
                $table->boolean('is_guest')->comment('Пользователь не авторизован в Яндексе');
                $table->unsignedBigInteger('question_count')->default(0)->comment('Сколько вопросов задал Бену');
                $table->unsignedBigInteger('call_count')->default(0)->comment('Сколько раз позвонил Бену');
                $table->timestamps();
            });
        }
    }

    public function down(Builder $schema)
    {
        $schema->dropIfExists('users');
    }
};