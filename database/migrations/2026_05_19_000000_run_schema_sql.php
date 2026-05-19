<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = file_get_contents(base_path('../schema.sql'));
        $sql = str_replace('SERIAL PRIMARY KEY', 'INTEGER PRIMARY KEY', $sql);
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_progress_history');
        Schema::dropIfExists('t_dokumen_survei');
        Schema::dropIfExists('t_monitoring_progress');
        Schema::dropIfExists('m_user');
        Schema::dropIfExists('t_target_kegiatan');
        Schema::dropIfExists('m_periode');
        Schema::dropIfExists('m_kabkota');
        Schema::dropIfExists('m_kegiatan');
        Schema::dropIfExists('m_sub_tim');
        Schema::dropIfExists('m_tim');
    }
};
