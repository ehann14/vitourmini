<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();

            // Identitas kunjungan (anonim)
            $table->string('visitor_id', 64)->index();      // hash session, untuk hitung pengunjung unik
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('user_agent')->nullable();

            // Perangkat
            $table->string('device_type', 20)->nullable();  // mobile / tablet / desktop / bot
            $table->string('browser', 40)->nullable();
            $table->string('platform', 40)->nullable();     // Android / iOS / Windows / dst

            // Halaman yang dibuka
            $table->string('url', 500);
            $table->string('path', 255)->index();
            $table->string('route_name', 100)->nullable();
            $table->string('page_type', 30)->default('lainnya'); // home / denah / panorama / splash / lainnya
            $table->string('scene_id', 100)->nullable()->index(); // diisi kalau buka panorama

            // Asal & lokasi (opsional)
            $table->string('referrer', 500)->nullable();
            $table->string('country', 60)->nullable();
            $table->string('city', 60)->nullable();

            $table->boolean('is_admin')->default(false);    // kunjungan oleh admin yang login

            $table->timestamp('visited_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
