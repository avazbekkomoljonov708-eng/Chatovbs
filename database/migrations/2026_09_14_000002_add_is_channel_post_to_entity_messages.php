<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsChannelPostToEntityMessages extends Migration
{
    /**
     * Kanal postidan biriktirilgan chatga avtomatik ko'chirilgan xabarlarni
     * (forward nusxalarni) oddiy chat xabarlaridan ajratib olish uchun.
     */
    public function up()
    {
        Schema::table('entity_messages', function (Blueprint $table) {
            $table->boolean('is_channel_post')->default(false)->after('chat_id');
        });
    }

    public function down()
    {
        Schema::table('entity_messages', function (Blueprint $table) {
            $table->dropColumn('is_channel_post');
        });
    }
}