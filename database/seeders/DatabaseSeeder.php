<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data KabKota
        $kabkotas = [
            ['id_kabkota' => '1501', 'nama_kabkota' => 'Kerinci'],
            ['id_kabkota' => '1502', 'nama_kabkota' => 'Merangin'],
            ['id_kabkota' => '1503', 'nama_kabkota' => 'Sarolangun'],
            ['id_kabkota' => '1504', 'nama_kabkota' => 'Batanghari'],
            ['id_kabkota' => '1505', 'nama_kabkota' => 'Muaro Jambi'],
            ['id_kabkota' => '1507', 'nama_kabkota' => 'Tanjung Jabung Barat'],
            ['id_kabkota' => '1506', 'nama_kabkota' => 'Tanjung Jabung Timur'],
            ['id_kabkota' => '1509', 'nama_kabkota' => 'Bungo'],
            ['id_kabkota' => '1508', 'nama_kabkota' => 'Tebo'],
            ['id_kabkota' => '1571', 'nama_kabkota' => 'Kota Jambi'],
            ['id_kabkota' => '1572', 'nama_kabkota' => 'Kota Sungai Penuh'],
        ];
        DB::table('m_kabkota')->insert($kabkotas);

        // 2. Data Tim
        $tims = [
            ['nama_tim' => 'Statistik Sumber Daya Mineral Konstruksi dan Industri'],
            ['nama_tim' => 'Statistik Sumber Daya Hayati']
        ];
        DB::table('m_tim')->insert($tims);

        // 3. Data Sub Tim
        $subTims = [
            ['id_tim' => 1, 'nama_sub_tim' => 'Statistik Industri'],
            ['id_tim' => 1, 'nama_sub_tim' => 'Statistik Konstruksi'],
            ['id_tim' => 1, 'nama_sub_tim' => 'Statistik Pertambangan dan Energi'],
            ['id_tim' => 2, 'nama_sub_tim' => 'Statistik Tanaman Pangan'],
            ['id_tim' => 2, 'nama_sub_tim' => 'Statistik Hortikultura'],
            ['id_tim' => 2, 'nama_sub_tim' => 'Statistik Perkebunan'],
            ['id_tim' => 2, 'nama_sub_tim' => 'Statistik Peternakan'],
            ['id_tim' => 2, 'nama_sub_tim' => 'Statistik Perikanan'],
            ['id_tim' => 2, 'nama_sub_tim' => 'Statistik Kehutanan'],
        ];
        DB::table('m_sub_tim')->insert($subTims);

        // 4. Data Kegiatan
        $kegiatans = [
            ['id_sub_tim' => 1, 'nama_kegiatan' => 'Survei Tahunan Perusahaan Industri Manufaktur (STPIM)', 'metode_default' => 'CAPI', 'tanggal_deadline' => '2026-06-30'],
            ['id_sub_tim' => 1, 'nama_kegiatan' => 'Pemutakhiran DPA', 'metode_default' => 'CAPI', 'tanggal_deadline' => '2026-07-15'],
            ['id_sub_tim' => 1, 'nama_kegiatan' => 'Survei IBS Triwulanan', 'metode_default' => 'CAPI', 'tanggal_deadline' => '2026-08-01'],
            ['id_sub_tim' => 1, 'nama_kegiatan' => 'Survei IMK Triwulan', 'metode_default' => 'CAPI', 'tanggal_deadline' => '2026-08-01'],
            ['id_sub_tim' => 1, 'nama_kegiatan' => 'Survei IMK Tahunan', 'metode_default' => 'CAPI', 'tanggal_deadline' => '2026-09-30'],
            ['id_sub_tim' => 4, 'nama_kegiatan' => 'Survei Ubinan Padi', 'metode_default' => 'CAPI', 'tanggal_deadline' => '2026-05-30']
        ];
        DB::table('m_kegiatan')->insert($kegiatans);

        // 5. Data Periode
        $periodes = [
            ['tahun' => 2026, 'nama_periode' => 'Triwulan I'],
            ['tahun' => 2026, 'nama_periode' => 'Tahunan']
        ];
        DB::table('m_periode')->insert($periodes);

        // 6. User Admin (password123)
        DB::table('m_user')->insert([
            'nip' => 'admin',
            'nama_user' => 'Administrator Provinsi',
            'password' => Hash::make('password123'),
            'role' => 'admin_prov',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // ============================================
        // DUMMY DATA SURVEI UBINAN PADI (Kegiatan ID 6)
        // ============================================
        
        $targets = [
            ['id_kabkota' => '1501', 'target' => 1200],
            ['id_kabkota' => '1502', 'target' => 1500],
            ['id_kabkota' => '1503', 'target' => 900],
            ['id_kabkota' => '1504', 'target' => 1100],
            ['id_kabkota' => '1505', 'target' => 1300],
            ['id_kabkota' => '1506', 'target' => 2000],
            ['id_kabkota' => '1507', 'target' => 1400],
            ['id_kabkota' => '1508', 'target' => 1000],
            ['id_kabkota' => '1509', 'target' => 1050],
            ['id_kabkota' => '1571', 'target' => 250],
            ['id_kabkota' => '1572', 'target' => 800],
        ];

        foreach ($targets as $index => $t) {
            // Target
            $id_target = DB::table('t_target_kegiatan')->insertGetId([
                'id_kegiatan' => 6,
                'id_periode' => 1,
                'id_kabkota' => $t['id_kabkota'],
                'metode_pendataan' => 'CAPI',
                'target_sampel' => $t['target']
            ]);

            // Final realisasi (simulated progress)
            $progressRatio = min(0.3 + ($index * 0.05), 0.95);
            $totalCapi = round($t['target'] * $progressRatio);
            $approved = round($totalCapi * 0.85);
            $submit = $totalCapi - $approved;

            // Monitoring Progress
            DB::table('t_monitoring_progress')->insert([
                'id_target' => $id_target,
                'capi_submit' => $submit,
                'capi_approved' => $approved,
                'tanggal_update' => Carbon::now()
            ]);
            
            // Progress History (Snapshot for one day)
            DB::table('t_progress_history')->insert([
                'id_kegiatan' => 6,
                'id_kabkota' => $t['id_kabkota'],
                'capi_submit' => $submit,
                'capi_approved' => $approved,
                'tanggal_update' => Carbon::now()->subDays(1)
            ]);
        }
        
        // Overall Provincial History
        DB::table('t_progress_history')->insert([
            'id_kegiatan' => 6,
            'id_kabkota' => null,
            'capi_submit' => 1500, // example aggregate
            'capi_approved' => 5000,
            'tanggal_update' => Carbon::now()->subDays(1)
        ]);

    }
}
