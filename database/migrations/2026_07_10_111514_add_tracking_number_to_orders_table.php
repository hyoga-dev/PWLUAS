<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom tracking_number setelah kolom status.
            // nullable() digunakan karena saat pesanan baru dibuat, resi pasti masih kosong.
            $table->string('tracking_number', 100)->nullable()->after('status');
        });
    }

    /**
     * Batalkan migrasi untuk menghapus kolom (jika melakukan rollback).
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kembali kolom jika migrasi ini di-rollback
            $table->dropColumn('tracking_number');
        });
    }
};