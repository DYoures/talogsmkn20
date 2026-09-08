<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->string('accent_color', 10)->default('#8B5CF6')->after('kode');
        });

        // Backfill existing jurusans with their established identity colors
        DB::table('jurusans')->where('kode', 'RPL')->update(['accent_color' => '#8B5CF6']);
        DB::table('jurusans')->where('kode', 'TKJ')->update(['accent_color' => '#06B6D4']);
        DB::table('jurusans')->where('kode', 'MM')->update(['accent_color' => '#F59E0B']);
        DB::table('jurusans')->where('kode', 'AKL')->update(['accent_color' => '#10B981']);
    }

    public function down(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropColumn('accent_color');
        });
    }
};
