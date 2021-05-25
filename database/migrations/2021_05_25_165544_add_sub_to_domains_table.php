<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubToDomainsTable extends Migration
{
    public function up()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->string('sub')->default('cdn');
        });
    }

    public function down()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn('sub');
        });
    }
}
