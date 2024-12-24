<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // путь к изображению
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}

//Пояснение:
//
//Добавлены внешние ключи для связи с таблицами categories и users.
//Поле image опционально и предназначено для хранения пути к файлу изображения.
