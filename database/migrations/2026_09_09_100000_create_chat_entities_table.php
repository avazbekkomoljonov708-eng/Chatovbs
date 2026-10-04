<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatEntitiesTable extends Migration
{
    public function up()
    {
        Schema::create('chat_entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type', 20);
            $table->string('name', 64);
            $table->string('username', 32)->nullable();
            $table->text('description')->nullable();
            $table->string('visibility', 20)->default('public');
            $table->longText('avatar')->nullable();
            $table->unsignedInteger('members_count')->default(1);
            $table->timestamps();

            $table->index(['user_id', 'type', 'created_at']);
            $table->unique(['user_id', 'type', 'username']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_entities');
    }
}