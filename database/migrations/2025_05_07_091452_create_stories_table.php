<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hn_id')->unique();
            $table->string('title');
            $table->text('url')->nullable();
            $table->integer('score')->default(0);
            $table->string('by');
            $table->timestamp('time');
            $table->enum('type', ['top', 'new', 'best']);
            $table->text('text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stories');
    }
};