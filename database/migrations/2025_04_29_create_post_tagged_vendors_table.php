<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tagged_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['post_id', 'vendor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tagged_vendors');
    }
}; 