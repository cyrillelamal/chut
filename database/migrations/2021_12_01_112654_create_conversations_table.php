<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 255)->nullable();
            $table->boolean('private')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
