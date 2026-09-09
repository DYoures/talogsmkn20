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
        Schema::table('tugas_akhirs', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('description');
            $table->string('file_original_name')->nullable()->after('file_path');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_original_name');
            $table->string('file_mime')->nullable()->after('file_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas_akhirs', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_original_name', 'file_size', 'file_mime']);
        });
    }
};
