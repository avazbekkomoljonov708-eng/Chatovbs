<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHomeFlagToChatEntitiesTable extends Migration
{
    public function up()
    {
        Schema::table('chat_entities', function (Blueprint $table) {
            $table->boolean('in_home')->default(false)->after('members_count');
        });
    }

    public function down()
    {
        Schema::table('chat_entities', function (Blueprint $table) {
            $table->dropColumn('in_home');
        });
    }
}