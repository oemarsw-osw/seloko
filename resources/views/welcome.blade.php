<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Seloko Produksi</title>
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
                <a href="index.html" class="active">Home</a>
                <a href="dashboard_kegiatan.html">Dashboard</a>
                <a href="tentang.html">Tentang</a>
                <a href="login.html" id="nav-login">Login</a>
            </div>
        </nav>

        <main class="hero-section">
            <div class="hero-content">
                <span class="hero-badge">BPS Jambi Production</span>
                <h1>Pantau Progres Survei dengan <span class="text-primary">Cerdas</span> & Real-time</h1>
                <p>Sistem pemantauan terpadu untuk tim Statistik Produksi. Melacak pengumpulan data, mendeteksi anomali, dan mengelola sumber daya dalam satu platform.</p>
                <div class="hero-actions">
                    <a href="dashboard_kegiatan.html" class="btn-primary">Buka Dashboard <i data-lucide="arrow-right" class="icon-sm"></i></a>
                    <a href="tentang.html" class="btn-secondary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="hero-image-placeholder">
                <div class="glass-card">
                    <i data-lucide="pie-chart" class="hero-icon"></i>
                    <div class="glass-text">
                        <h4>Real-time Analytics</h4>
                        <p>Data termutakhir setiap saat</p>
                    </div>
                </div>
            </div>
        </main>
        
        <section class="resources-grid">
            <div class="resource-card" style="align-items: center; text-align: center;">
                <div class="resource-icon-box" style="margin-bottom: 8px; width: 64px; height: 64px;"><i data-lucide="activity" style="width: 32px; height: 32px;"></i></div>
                <div class="resource-meta">
                    <h4 style="font-size: 18px; margin-bottom: 8px;">Pemantauan Real-time</h4>
                </div>
                <p class="resource-desc">Pantau progres pengumpulan dan persetujuan dokumen survei secara langsung dari seluruh kabupaten/kota.</p>
            </div>
            <div class="resource-card" style="align-items: center; text-align: center;">
                <div class="resource-icon-box green" style="margin-bottom: 8px; width: 64px; height: 64px;"><i data-lucide="shield-alert" style="width: 32px; height: 32px;"></i></div>
                <div class="resource-meta">
                    <h4 style="font-size: 18px; margin-bottom: 8px;">Deteksi Anomali</h4>
                </div>
                <p class="resource-desc">Sistem AI internal yang memberikan notifikasi jika terdapat indikasi data tidak wajar atau keterlambatan dari target.</p>
            </div>
            <div class="resource-card" style="align-items: center; text-align: center;">
                <div class="resource-icon-box" style="margin-bottom: 8px; width: 64px; height: 64px;"><i data-lucide="folder-open" style="width: 32px; height: 32px;"></i></div>
                <div class="resource-meta">
                    <h4 style="font-size: 18px; margin-bottom: 8px;">Manajemen Sumber Daya</h4>
                </div>
                <p class="resource-desc">Akses tersentralisasi untuk buku pedoman, kuesioner aktif, kerangka sampel, dan persuratan resmi.</p>
            </div>
        </section>
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
