<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerStatsTable extends Migration
{
    public function up()
    {
        Schema::create('server_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('server_id')->references('id')->on('servers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('cpu')->nullable();
            $table->string('memory_total')->nullable();
            $table->string('memory_used')->nullable();
            $table->string('network_in')->nullable();
            $table->string('network_out')->nullable();
            $table->string('total_storage')->nullable();
            $table->string('used_storage')->nullable();
            $table->string('ssh_connections')->nullable();
            $table->string('uptime')->nullable();
            $table->boolean('down')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_stats');
    }
}
