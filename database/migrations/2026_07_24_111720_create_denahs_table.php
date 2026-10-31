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
        Schema::create('denahs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama ruangan (contoh: "Ruang Teori 1")
            $table->string('gedung'); // Gedung (contoh: "Gedung A")
            $table->string('lantai')->nullable(); // Lantai (contoh: "Lantai 1")
            $table->decimal('position_x', 8, 2); // Posisi X dalam persen (0-100)
            $table->decimal('position_y', 8, 2); // Posisi Y dalam persen (0-100)
            $table->foreignId('panorama_id')->nullable()->constrained('panoramas')->nullOnDelete();
            $table->text('description')->nullable(); // Deskripsi ruangan
            $table->string('icon')->default('fa-door-open'); // Icon FontAwesome
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denahs');
    }
};
