<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_tim', function (Blueprint $table) {
            $table->id('id_tim');
            $table->string('nama_tim', 100);
        });

        Schema::create('m_sub_tim', function (Blueprint $table) {
            $table->id('id_sub_tim');
            $table->foreignId('id_tim')->constrained('m_tim', 'id_tim')->onDelete('cascade');
            $table->string('nama_sub_tim', 100);
        });

        Schema::create('m_kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->foreignId('id_sub_tim')->constrained('m_sub_tim', 'id_sub_tim')->onDelete('cascade');
            $table->string('nama_kegiatan', 150);
            $table->enum('metode_default', ['CAPI', 'PAPI']);
            $table->date('tanggal_deadline');
        });

        Schema::create('m_kabkota', function (Blueprint $table) {
            $table->char('id_kabkota', 4)->primary();
            $table->string('nama_kabkota', 50);
        });

        Schema::create('m_periode', function (Blueprint $table) {
            $table->id('id_periode');
            $table->integer('tahun');
            $table->string('nama_periode', 50);
        });

        Schema::create('t_target_kegiatan', function (Blueprint $table) {
            $table->id('id_target');
            $table->foreignId('id_kegiatan')->constrained('m_kegiatan', 'id_kegiatan')->onDelete('cascade');
            $table->foreignId('id_periode')->constrained('m_periode', 'id_periode')->onDelete('cascade');
            $table->char('id_kabkota', 4);
            $table->enum('metode_pendataan', ['CAPI', 'PAPI']);
            $table->integer('target_sampel');
            
            $table->foreign('id_kabkota')->references('id_kabkota')->on('m_kabkota')->onDelete('cascade');
        });

        Schema::create('m_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nip', 18)->unique();
            $table->string('nama_user', 100);
            $table->string('password');
            $table->enum('role', ['admin_prov', 'admin_sub_tim', 'operator_kabkota']);
            $table->char('id_kabkota', 4)->nullable();
            $table->foreignId('id_sub_tim')->nullable()->constrained('m_sub_tim', 'id_sub_tim')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('id_kabkota')->references('id_kabkota')->on('m_kabkota')->onDelete('cascade');
        });

        Schema::create('t_monitoring_progress', function (Blueprint $table) {
            $table->id('id_progress');
            $table->foreignId('id_target')->constrained('t_target_kegiatan', 'id_target')->onDelete('cascade');
            $table->timestamp('tanggal_update')->useCurrent();
            $table->integer('papi_belum_dicacah')->default(0);
            $table->integer('papi_dicacah')->default(0);
            $table->integer('papi_diolah')->default(0);
            $table->integer('capi_open')->default(0);
            $table->integer('capi_submit')->default(0);
            $table->integer('capi_rejected')->default(0);
            $table->integer('capi_approved')->default(0);
            $table->foreignId('updated_by')->nullable()->constrained('m_user', 'id_user')->onDelete('set null');
        });

        Schema::create('t_dokumen_survei', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->foreignId('id_kegiatan')->constrained('m_kegiatan', 'id_kegiatan')->onDelete('cascade');
            $table->foreignId('id_periode')->constrained('m_periode', 'id_periode')->onDelete('cascade');
            $table->string('kategori_dokumen', 50);
            $table->string('nama_dokumen', 150);
            $table->text('url_gdrive');
            $table->foreignId('updated_by')->nullable()->constrained('m_user', 'id_user')->onDelete('set null');
            $table->timestamp('tanggal_upload')->useCurrent();
        });

        Schema::create('t_progress_history', function (Blueprint $table) {
            $table->id('id_history');
            $table->foreignId('id_kegiatan')->constrained('m_kegiatan', 'id_kegiatan')->onDelete('cascade');
            $table->char('id_kabkota', 4)->nullable();
            $table->timestamp('tanggal_update')->useCurrent();
            $table->integer('capi_submit')->default(0);
            $table->integer('capi_approved')->default(0);
            
            $table->foreign('id_kabkota')->references('id_kabkota')->on('m_kabkota')->onDelete('cascade');
        });

        // Required by Laravel Auth
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
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
