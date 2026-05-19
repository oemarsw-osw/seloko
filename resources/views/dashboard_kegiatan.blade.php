<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemantauan - Seloko Produksi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <a href="dashboard_kegiatan.html" class="active">Dashboard</a>
                <a href="tentang.html">Tentang</a>
                <a href="login.html" id="nav-login">Login</a>
            </div>
        </nav>

        <header class="dashboard-header">
            <div class="header-left">
                <h1>Dashboard Pemantauan</h1>
                <div class="header-meta">
                    <select id="kegiatan-selector" style="font-family: var(--font-body); padding: 4px 12px; border-radius: var(--radius-sm); border: 1px solid #cbd5e1; font-weight: 500; font-size: 14px; background-color: var(--surface); color: var(--text-main); cursor: pointer; outline: none; margin-right: 8px;">
                        <option value="">Memuat Kegiatan...</option>
                    </select>
                </div>
            </div>
            <div class="header-right">
                <div class="days-badge">
                    <i data-lucide="clock" class="icon-sm"></i>
                    <span>Sisa Hari: <strong>16</strong></span>
                </div>
            </div>
        </header>

        <section class="metrics-grid">
            <div class="metric-card">
                <div class="metric-icon-wrapper primary-light">
                    <i data-lucide="users" class="icon-md text-primary"></i>
                </div>
                <div class="metric-info">
                    <span class="metric-label">TARGET SAMPEL</span>
                    <h2 class="metric-value" id="val-target">12.500</h2>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon-wrapper primary-light">
                    <i data-lucide="file-up" class="icon-md text-primary"></i>
                </div>
                <div class="metric-info">
                    <span class="metric-label">TOTAL SUBMIT</span>
                    <h2 class="metric-value" id="val-submit">8.420</h2>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon-wrapper success-light">
                    <i data-lucide="check-circle" class="icon-md text-success"></i>
                </div>
                <div class="metric-info">
                    <span class="metric-label">TOTAL APPROVE</span>
                    <h2 class="metric-value" id="val-approve">7.850</h2>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon-wrapper primary-dark">
                    <i data-lucide="shield-check" class="icon-md text-white"></i>
                </div>
                <div class="metric-info">
                    <span class="metric-label">PERSENTASE CAPAIAN</span>
                    <h2 class="metric-value" id="val-progress">67.36%</h2>
                </div>
            </div>
        </section>

        <div class="main-content-layout">
            <section class="content-card regional-progress">
                <div class="card-header">
                    <div>
                        <h3>Progres per Wilayah</h3>
                        <p class="card-subtitle">Completion by Kabupaten/Kota</p>
                    </div>
                    <div class="toggle-group" id="toggle-bar">
                        <button class="toggle-btn active" data-view="percentage">Persentase</button>
                        <button class="toggle-btn" data-view="quantity">Kuantitas</button>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="regionalChart"></canvas>
                </div>
            </section>

            <section class="content-card performance-curve">
                <div class="card-header">
                    <div>
                        <h3>Performance Curve</h3>
                        <p class="card-subtitle">Submission vs Target Trend</p>
                    </div>
                    <div class="toggle-group">
                        <button class="toggle-btn active">Provinsi</button>
                        <button class="toggle-btn">Kab/Kota</button>
                    </div>
                </div>



                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
            </section>
        </div>

        <h3 class="section-title">Sumber Daya</h3>

        <section class="resources-grid">
            <div class="resource-card">
                <div class="resource-header">
                    <div class="resource-icon-box"><i data-lucide="book-open"></i></div>
                    <div class="resource-meta">
                        <h4>Buku Pedoman</h4>
                        <span class="badge-status">Update: 2 days ago</span>
                    </div>
                </div>
                <p class="resource-desc">Panduan lengkap pelaksanaan survei lapangan beserta tata cara wawancara.</p>
                <button class="btn-outline"><i data-lucide="download"></i> Unduh</button>
            </div>

            <div class="resource-card">
                <div class="resource-header">
                    <div class="resource-icon-box green"><i data-lucide="text-select"></i></div>
                    <div class="resource-meta">
                        <h4>Kuesioner</h4>
                        <span class="badge-status">V2.1 - Aktif</span>
                    </div>
                </div>
                <p class="resource-desc">Daftar pertanyaan terstruktur untuk responden individu dan rumah tangga.</p>
                <button class="btn-outline"><i data-lucide="external-link"></i> Buka</button>
            </div>

            <div class="resource-card">
                <div class="resource-header">
                    <div class="resource-icon-box"><i data-lucide="map"></i></div>
                    <div class="resource-meta">
                        <h4>Kerangka Sampel</h4>
                        <span class="badge-status">Data Final</span>
                    </div>
                </div>
                <p class="resource-desc">Daftar blok sensus dan rumah tangga target sasaran untuk setiap wilayah.</p>
                <button class="btn-outline"><i data-lucide="download"></i> Unduh CSV</button>
            </div>

            <div class="resource-card">
                <div class="resource-header">
                    <div class="resource-icon-box"><i data-lucide="mail"></i></div>
                    <div class="resource-meta">
                        <h4>Surat Pengantar</h4>
                        <span class="badge-status">Template Resmi</span>
                    </div>
                </div>
                <p class="resource-desc">Dokumen legalitas untuk ditunjukkan kepada responden dan aparat desa.</p>
                <button class="btn-outline"><i data-lucide="download"></i> Unduh PDF</button>
            </div>
        </section>

    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
            logoutLink.onclick = function(e) {
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
