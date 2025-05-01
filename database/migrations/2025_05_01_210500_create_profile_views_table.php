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
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->comment('ID của người xem, null nếu khách');
            $table->foreignId('vendor_id')->constrained('users')->comment('ID của người bán được xem');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_views');
    }
};
