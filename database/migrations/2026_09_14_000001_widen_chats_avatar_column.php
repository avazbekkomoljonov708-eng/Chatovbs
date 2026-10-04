<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class WidenChatsAvatarColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `chats` MODIFY `avatar` LONGTEXT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `chats` MODIFY `avatar` VARCHAR(255) NULL');
    }
}