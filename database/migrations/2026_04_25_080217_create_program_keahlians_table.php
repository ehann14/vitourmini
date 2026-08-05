<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_keahlian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan'); // Contoh: RPL, TKJ, MM
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_keahlian');
    }
};