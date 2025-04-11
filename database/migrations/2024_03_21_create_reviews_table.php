<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->integer('user_id');
            $table->integer('food_rating');
            $table->integer('satisfaction_level')->comment('1: rất tệ, 2: tệ, 3: trung bình, 4: khá, 5: rất tốt');
            $table->text('comment')->nullable();
            $table->integer('status')->default(1)->comment('1: public, 2: pending, 3: hide');
            $table->integer('type')->default(1)->comment('1: du lịch, 2: ẩm thực');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}; 