<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_points');
            $table->integer('max_points')->nullable();
            $table->string('icon');
            $table->string('color');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiers');
    }
}; 