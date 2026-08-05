<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('denahs', function (Blueprint $table) {
            $table->integer('jumlah_kursi')->default(0)->after('description');
            $table->integer('jumlah_meja')->default(0)->after('jumlah_kursi');
            $table->integer('jumlah_pc')->default(0)->after('jumlah_meja');
            $table->string('ukuran_ruangan')->nullable()->after('jumlah_pc');
        });
    }

    public function down(): void
    {
        Schema::table('denahs', function (Blueprint $table) {
            $table->dropColumn(['jumlah_kursi', 'jumlah_meja', 'jumlah_pc', 'ukuran_ruangan']);
        });
    }
};