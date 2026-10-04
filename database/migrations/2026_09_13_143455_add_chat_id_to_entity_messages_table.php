<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChatIdToEntityMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('entity_messages', function (Blueprint $table) {
            $table->foreignId('chat_id')->nullable()->after('chat_entity_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('entity_messages', function (Blueprint $table) {
            $table->dropForeign(['chat_id']);
            $table->dropColumn('chat_id');
        });
    }
}