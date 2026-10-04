<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakePasswordRequiredInUsersTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
    }
}