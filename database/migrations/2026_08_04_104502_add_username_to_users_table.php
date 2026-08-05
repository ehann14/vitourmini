<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Hapus kolom username kalau sudah ada (sisa dari percobaan gagal sebelumnya)
        if (Schema::hasColumn('users', 'username')) {
            // Cek apakah sudah ada unique constraint, hapus dulu
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique(['username']);
                });
            } catch (\Exception $e) {
                // Tidak ada unique constraint, abaikan
            }
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('username');
            });
        }

        // Step 2: Tambah kolom username NULLABLE dulu (tidak unique)
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
        });

        // Step 3: Isi username untuk semua existing users
        $users = DB::table('users')->get();
        $usedUsernames = [];
        
        foreach ($users as $user) {
            // Generate base username dari email atau nama
            if (!empty($user->email)) {
                $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode('@', $user->email)[0]));
            } elseif (!empty($user->name)) {
                $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', str_replace(' ', '', $user->name)));
            } else {
                $baseUsername = 'user' . $user->id;
            }
            
            if (empty($baseUsername)) {
                $baseUsername = 'user' . $user->id;
            }

            // Pastikan unik
            $username = $baseUsername;
            $counter = 1;
            while (in_array($username, $usedUsernames)) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            $usedUsernames[] = $username;
            
            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        }

        // Step 4: Sekarang baru buat NOT NULL dan UNIQUE
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
            $table->unique('username');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};