<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationsTable extends Migration
{
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('visible_title', 255)->nullable();

            $table->foreignId('conversation_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->unique(['conversation_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('participations');
    }
}
