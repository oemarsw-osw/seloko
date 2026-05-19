<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Seloko Produksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="dashboard-container">
        <nav class="top-nav">
            <div class="nav-brand">
                <img src="logo.png" alt="Logo" style="height: 32px; width: auto;">
                <span>Seloko Produksi</span>
            </div>
            <button class="mobile-top-nav-toggle" onclick="document.getElementById('nav-menu').classList.toggle('show')">
                <i data-lucide="menu"></i>
            </button>
            <div class="nav-links" id="nav-menu">
                <a href="index.html">Home</a>
                <a href="dashboard_kegiatan.html">Dashboard</a>
                <a href="tentang.html" class="active">Tentang</a>
                <a href="login.html" id="nav-login">Login</a>
            </div>
        </nav>

        <main class="about-section">
            <div class="content-card about-card">
                <h2>Tentang Seloko Produksi</h2>
                <p><strong>Seloko Produksi</strong> adalah inisiatif strategis dari tim <strong>Statistik Produksi BPS
                        Provinsi Jambi</strong> untuk memodernisasi cara pemantauan pelaksanaan survei di lapangan.</p>
                <p>Platform ini dirancang khusus untuk memfasilitasi pengawasan target sampel, persetujuan dokumen,
                    hingga visualisasi tren pendataan harian di 11 Kabupaten/Kota secara <i>real-time</i>.</p>

                <h3>Visi Misi</h3>
                <p>Meningkatkan kualitas data survei melalui pemantauan yang ketat, deteksi anomali secara dini, dan
                    ketersediaan seluruh sumber daya (buku pedoman, kuesioner, kerangka sampel) yang tersentralisasi
                    bagi seluruh petugas dan pengawas survei.</p>

                <h3>Nilai Inti (Core Values)</h3>
                <div class="team-grid">
                    <div class="metric-card">
                        <div class="metric-icon-wrapper primary-light">
                            <i data-lucide="target" class="icon-md text-primary"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-label">TUJUAN UTAMA</span>
                            <h2 class="metric-value" style="font-size: 16px;">Kualitas Data</h2>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon-wrapper success-light">
                            <i data-lucide="zap" class="icon-md text-success"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-label">KECEPATAN</span>
                            <h2 class="metric-value" style="font-size: 16px;">Akurasi Waktu</h2>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon-wrapper primary-dark">
                            <i data-lucide="shield-check" class="icon-md text-white"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-label">KEANDALAN</span>
                            <h2 class="metric-value" style="font-size: 16px;">Integritas Tinggi</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Struktur Tim Statistik Produksi -->
            <div class="content-card about-card">
                <h3
                    style="border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 24px; margin-top: 0px;">
                    Struktur Tim
                    Statistik Produksi</h3>

                <!-- Ketua Tim Section -->
                <h4
                    style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                    Ketua Tim</h4>
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 32px;">
                    <!-- Ketua 1 -->
                    <div style="display: flex; align-items: center; gap: 16px; padding: 16px; border: 1px solid #e2e8f0; border-radius: var(--radius-md); background: #f8fafc; border-left: 4px solid var(--primary); transition: transform 0.2s, box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 56px; height: 56px; border-radius: 50%; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 108, 73, 0.15); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/1.png" alt="Eny Tristanti SST, M.E."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h4 style="font-size: 15px; font-weight: 600; margin: 0 0 4px 0; color: var(--text-main);">
                                Eny Tristanti SST, M.E.</h4>
                            <p style="font-size: 12px; color: var(--primary); font-weight: 600; margin: 0 0 2px 0;">
                                Ketua Tim Statistik Sumber Daya Hayati</p>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statistisi Madya</p>
                        </div>
                    </div>
                    <!-- Ketua 2 -->
                    <div style="display: flex; align-items: center; gap: 16px; padding: 16px; border: 1px solid #e2e8f0; border-radius: var(--radius-md); background: #f8fafc; border-left: 4px solid #0ea5e9; transition: transform 0.2s, box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 56px; height: 56px; border-radius: 50%; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.15); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/2.png" alt="Eva Riani SST, M.E."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h4 style="font-size: 15px; font-weight: 600; margin: 0 0 4px 0; color: var(--text-main);">
                                Eva Riani SST, M.E.</h4>
                            <p style="font-size: 12px; color: #0ea5e9; font-weight: 600; margin: 0 0 2px 0;">
                                Ketua Tim Statistik Sumber Daya Mineral, Konstruksi, dan Industri
                            </p>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statistisi Madya</p>
                        </div>
                    </div>
                </div>

                <!-- Anggota Tim Section -->
                <h4
                    style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                    Anggota Tim</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                    <!-- Anggota 1 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/3.png" alt="Rian Hidayat, S.Tr.Stat."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Oemar Syarief Wibisono, S.ST, M.Kom</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Pranata Komputer Pertama
                            </p>
                        </div>
                    </div>
                    <!-- Anggota 2 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/4.png" alt="Dewi Sartika, S.Si."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Muhammad Al Fatih S.Tr.Stat.</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statisi Pertama</p>
                        </div>
                    </div>
                    <!-- Anggota 3 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/5.png" alt="Budi Santoso, A.Md."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Linda Marlina S.Si</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statistisi Muda</p>
                        </div>
                    </div>
                    <!-- Anggota 4 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/6.png" alt="Siti Aminah, S.E."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Heni Widiyanti S.Si., M.E.</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statistisi Muda</p>
                        </div>
                    </div>
                    <!-- Anggota 5 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/7.png" alt="Ahmad Fauzi, S.Tr.Stat."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Fathina Mufrodi S.E</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statisi Muda</p>
                        </div>
                    </div>
                    <!-- Anggota 6 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/8.png" alt="Rini Lestari, S.Si."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Vita Eisynta Dewi S.E., M.E.</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statistisi Muda</p>
                        </div>
                    </div>
                    <!-- Anggota 7 -->
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: var(--radius-sm); background: white; transition: transform 0.2s, box-shadow 0.2s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-sm)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div
                            style="position: relative; width: 44px; height: 44px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1); flex-shrink: 0; background: #cbd5e1;">
                            <img src="images/9.png" alt="Eko Prasetyo, A.Md.Ds."
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 600; margin: 0 0 2px 0; color: var(--text-main);">
                                Eka Aulia Liusta S.Tr.Stat.</h5>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Statistisi Pertama</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

        // Cek status login
        const token = localStorage.getItem('token');
        if (token) {
            const navMenu = document.getElementById('nav-menu');
            document.getElementById('nav-login').style.display = 'none';

            const adminLink = document.createElement('a');
            adminLink.href = 'admin_monitoring.html';
            adminLink.innerText = 'Panel Admin';

            const logoutLink = document.createElement('a');
            logoutLink.href = '#';
            logoutLink.innerText = 'Logout';
            logoutLink.onclick = function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Logout Berhasil',
                    text: 'Sampai jumpa kembali!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    localStorage.clear();
                    window.location.reload();
                });
            };

            navMenu.appendChild(adminLink);
            navMenu.appendChild(logoutLink);
        }
    </script>
</body>

</html>
