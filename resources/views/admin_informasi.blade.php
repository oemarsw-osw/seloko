<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Informasi Dokumen - Seloko Produksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: var(--radius-sm); font-family: var(--font-body); }
        .btn-submit { background-color: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; }
        .btn-submit:hover { background-color: var(--primary-container); }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <nav class="top-nav">
            <div class="nav-brand">
                <img src="seloko_logo.png" alt="Logo" style="height: 32px; width: auto;">
                <span>Seloko Produksi (Admin Panel)</span>
            </div>
            <button class="mobile-top-nav-toggle" onclick="document.getElementById('nav-menu').classList.toggle('show')">
                <i data-lucide="menu"></i>
            </button>
            <div class="nav-links" id="nav-menu">
                <a href="index.html">Home</a>
                <a href="dashboard_kegiatan.html">Dashboard</a>
                <a href="tentang.html">Tentang</a>
                <a href="admin_monitoring.html" class="active">Panel Admin</a>
                <a href="#" onclick="logout()">Logout</a>
            </div>
        </nav>

        <div class="breadcrumb-card">
            <div class="breadcrumb-text">
                <i data-lucide="home" style="width: 18px; height: 18px;"></i>
                Panel Admin / <span class="text-primary" style="font-weight: 600;">Update Informasi</span>
            </div>
            <div class="breadcrumb-user">Halo, <span id="admin-name" style="font-weight: 600;">Admin</span></div>
        </div>

        <button class="mobile-sidebar-toggle" onclick="document.getElementById('admin-sidebar').classList.toggle('show')">
            <i data-lucide="menu"></i> Menu Panel Admin
        </button>

        <div class="admin-page-container">
            <!-- Sidebar -->
            <aside class="admin-sidebar" id="admin-sidebar">
                <a href="admin_monitoring.html"><i data-lucide="activity"></i> Update Monitoring</a>
                <a href="admin_informasi.html" class="active"><i data-lucide="file-text"></i> Update Informasi</a>
                <a href="admin_kegiatan.html" id="menu-kegiatan"><i data-lucide="folder-plus"></i> Manajemen Kegiatan</a>
                <a href="admin_user.html" id="menu-user"><i data-lucide="users"></i> Management User</a>
            </aside>

            <!-- Main Content -->
            <main class="admin-content">
                <div class="content-card">
                    <h3 style="margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">Tautkan Dokumen Survei</h3>
                    <form id="dokumen-form">
                        <div class="form-group">
                            <label>Pilih Kegiatan</label>
                            <select id="id_kegiatan" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <select id="id_periode" class="form-control" required>
                                <option value="1">Triwulan I (2026)</option>
                                <option value="2">Tahunan (2026)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori Dokumen</label>
                            <select id="kategori_dokumen" class="form-control" required>
                                <option value="Kuesioner">Kuesioner</option>
                                <option value="Daftar Sampel">Daftar Sampel</option>
                                <option value="Buku Pedoman">Buku Pedoman</option>
                                <option value="Surat Pengantar">Surat Pengantar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama/Judul Dokumen yang Tampil</label>
                            <input type="text" id="nama_dokumen" class="form-control" placeholder="Cth: Buku Pedoman Pencacahan IMK" required>
                        </div>
                        <div class="form-group">
                            <label>URL / Link Google Drive</label>
                            <input type="url" id="url_gdrive" class="form-control" placeholder="https://drive.google.com/..." required>
                        </div>
                        <button type="submit" class="btn-submit">Simpan Tautan Dokumen</button>
                        <span id="doc-msg" style="margin-left: 12px; font-weight: 600;"></span>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Auth Check
        const token = localStorage.getItem('token');
        const role = localStorage.getItem('user_role');
        const nama = localStorage.getItem('user_nama');

        if (!token) window.location.href = 'login.html';

        document.getElementById('admin-name').innerText = nama || 'Admin';

        // Show all menus for all roles
        // if (role !== 'admin_prov') {
        //     document.getElementById('menu-kegiatan').style.display = 'none';
        //     document.getElementById('menu-user').style.display = 'none';
        // }

        function logout() {
            Swal.fire({
                title: 'Logout Berhasil',
                text: 'Sampai jumpa kembali!',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                localStorage.clear();
                window.location.href = 'login.html';
            });
        }

        async function loadKegiatan() {
            try {
                const res = await fetch('/api/kegiatan');
                const data = await res.json();
                const sel = document.getElementById('id_kegiatan');
                sel.innerHTML = '<option value="">-- Pilih Kegiatan --</option>';
                data.forEach(act => {
                    sel.innerHTML += `<option value="${act.id_kegiatan}">${act.nama_kegiatan}</option>`;
                });
            } catch (e) { console.error(e); }
        }

        document.getElementById('dokumen-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = {
                id_kegiatan: document.getElementById('id_kegiatan').value,
                id_periode: document.getElementById('id_periode').value,
                kategori_dokumen: document.getElementById('kategori_dokumen').value,
                nama_dokumen: document.getElementById('nama_dokumen').value,
                url_gdrive: document.getElementById('url_gdrive').value
            };

            try {
                const res = await fetch('/api/dokumen', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify(payload)
                });
                if (res.ok) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Tautan dokumen berhasil disimpan.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    document.getElementById('doc-msg').innerText = '';
                    document.getElementById('dokumen-form').reset();
                } else {
                    const data = await res.json();
                    Swal.fire('Gagal!', data.error, 'error');
                }
            } catch (e) { console.error(e); }
        });

        loadKegiatan();
    </script>
</body>
</html>
