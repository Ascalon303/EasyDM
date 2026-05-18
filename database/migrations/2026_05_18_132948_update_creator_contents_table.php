<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('creator_contents', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn('content_data');

            // Tambah kolom baru
            $table->longText('content_body')->nullable()->after('description');
            $table->string('file_path')->nullable()->after('content_body');
            $table->string('file_type')->nullable()->after('file_path');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_type');
        });
    }

    public function down(): void
    {
        Schema::table('creator_contents', function (Blueprint $table) {
            $table->dropColumn(['content_body', 'file_path', 'file_type', 'file_size']);
            $table->json('content_data')->nullable();
        });
    }
};