<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerReposTable extends Migration
{
    public function up()
    {
        Schema::create('server_repos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('server_id')->references('id')->on('servers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('branch');
            $table->string('secret');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_repos');
    }
}
