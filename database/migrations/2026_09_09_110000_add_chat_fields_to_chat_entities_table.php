<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatFieldsToChatEntitiesTable extends Migration
{
    public function up()
    {
        Schema::table('chat_entities', function (Blueprint $table) {
            $table->string('chat_name', 64)->nullable()->after('members_count');
            $table->string('chat_username', 32)->nullable()->after('chat_name');
            $table->longText('chat_avatar')->nullable()->after('chat_username');
            $table->text('chat_description')->nullable()->after('chat_avatar');
            $table->timestamp('chat_created_at')->nullable()->after('chat_description');
        });
    }

    public function down()
    {
        Schema::table('chat_entities', function (Blueprint $table) {
            $table->dropColumn(['chat_name', 'chat_username', 'chat_avatar', 'chat_description', 'chat_created_at']);
        });
    }
}