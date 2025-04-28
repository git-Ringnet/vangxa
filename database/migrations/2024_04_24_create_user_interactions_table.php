<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('interaction_type'); // post, trustlist, share
            $table->integer('points')->default(1);
            $table->string('highest_tier')->default('Bronze');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_interactions');
    }
}; 