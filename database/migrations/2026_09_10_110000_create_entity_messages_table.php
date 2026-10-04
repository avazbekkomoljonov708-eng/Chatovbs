<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('entity_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_entity_id')->constrained('chat_entities')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('body')->nullable();
            $table->string('audio_path')->nullable();
            $table->unsignedInteger('audio_duration')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_mime')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
            $table->index(['chat_entity_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('entity_messages');
    }
}
