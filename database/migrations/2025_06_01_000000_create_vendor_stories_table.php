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
        Schema::create('vendor_stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ID của vendor');
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('image_path')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_stories');
    }
}; 