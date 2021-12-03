<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('body');

            $table->unsignedBigInteger('conversation_id');
            $table->foreign('conversation_id')->references('id')->on('conversations');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('participations', function (Blueprint $table) {
            $table->unsignedBigInteger('last_available_message_id')->nullable();
            $table->foreign('last_available_message_id')->references('id')->on('messages');
        });
    }

    public function down()
    {
        Schema::table('participations', function (Blueprint $table) {
            $table->dropColumn('last_available_message_id');
        });

        Schema::dropIfExists('messages');
    }
}
