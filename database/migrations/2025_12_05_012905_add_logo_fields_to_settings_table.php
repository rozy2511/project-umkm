<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            // Cek dulu kolom apa yang ada
            if (Schema::hasColumn('settings', 'website_logo')) {
                // Tambah setelah website_logo
                $table->string('logo_text')->nullable()->after('website_logo');
            } else {
                // Tambah di akhir
                $table->string('logo_text')->nullable();
            }
            
            $table->enum('logo_type', ['image', 'text'])->default('text');
            $table->string('logo_font')->nullable();
            $table->string('logo_color')->default('#000000');
            $table->integer('logo_size')->default(24);
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['logo_text', 'logo_type', 'logo_font', 'logo_color', 'logo_size']);
        });
    }
};