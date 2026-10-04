<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityMessageViewsTable extends Migration
{
    public function up()
    {
        Schema::create('entity_message_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['entity_message_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('entity_message_views');
    }
}