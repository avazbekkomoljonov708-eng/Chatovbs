<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileLinkedToChatEntitiesTable extends Migration
{
    public function up()
    {
        Schema::table('chat_entities', function (Blueprint $table) {
            $table->boolean('profile_linked')->default(false)->after('in_home');
        });
    }

    public function down()
    {
        Schema::table('chat_entities', function (Blueprint $table) {
            $table->dropColumn('profile_linked');
        });
    }
}