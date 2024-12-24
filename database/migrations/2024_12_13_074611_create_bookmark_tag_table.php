<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarkTagTable extends Migration
{
    public function up()
    {
        Schema::create('bookmark_tag', function (Blueprint $table) {
            $table->foreignId('bookmark_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookmark_tag');
    }
}

//Пояснение:
//
//Миграция создаёт таблицу для связи "многие ко многим" между bookmarks и tags.
