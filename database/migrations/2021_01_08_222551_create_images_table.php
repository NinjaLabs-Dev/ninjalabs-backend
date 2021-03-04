<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug');
            $table->string('url');
            $table->longText('private_url')->nullable();
            $table->string('type');
            $table->string('dir');
            $table->integer('is_public')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
