<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('level', ['Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->enum('type', ['Akademik', 'Non-Akademik']);
            $table->string('image_path')->nullable();
            $table->integer('ranking')->nullable();
            $table->string('location')->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->string('student_name');
            $table->string('student_class')->nullable();
            $table->string('advisor_name')->nullable();
            $table->string('advisor_title')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};