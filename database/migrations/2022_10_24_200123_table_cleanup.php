<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableCleanup extends Migration
{
    public function up()
    {
        Schema::dropIfExists('server_stats');
        Schema::dropIfExists('servers');
        Schema::dropIfExists('twitch_users');
    }
}
