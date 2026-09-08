<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->string('kode', 10)->nullable()->after('name');
            $table->string('slug', 100)->unique()->nullable()->after('kode');
            $table->json('kurikulum')->nullable()->after('description')
                ->comment('Array of mata pelajaran / modul kurikulum');
            $table->json('prospek_karir')->nullable()->after('kurikulum')
                ->comment('Array of career prospect strings');
            $table->json('tools_industri')->nullable()->after('prospek_karir')
                ->comment('Array of industry tools/technologies');
            $table->string('akreditasi', 20)->nullable()->default('A')->after('tools_industri');
        });
    }

    public function down(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropColumn(['kode', 'slug', 'kurikulum', 'prospek_karir', 'tools_industri', 'akreditasi']);
        });
    }
};
