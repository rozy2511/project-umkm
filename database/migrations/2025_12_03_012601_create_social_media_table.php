<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Instagram, Facebook, Twitter, etc
            $table->string('icon'); // fa-instagram, fa-facebook, fa-twitter
            $table->string('url')->nullable(); // Link social media
            $table->boolean('is_active')->default(true); // Aktif/tidak
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};