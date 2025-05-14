<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('title')->nullable();
            $table->longText('description');
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->json('cuisine')->nullable();
            $table->json('styles')->nullable();
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();
            $table->integer('user_id');
            $table->integer('status')->comment('1: đã đăng, 2: đã ẩn')->default(1);
            $table->integer('type')->comment('1: du lịch, 2: ẩm thực, 3: cộng đồng')->default(1);
            $table->integer('group_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
