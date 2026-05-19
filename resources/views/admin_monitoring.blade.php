<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Monitoring - Seloko Produksi</title>
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
        .progress-table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 13px; }
        .progress-table th, .progress-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .progress-table th { background: #f8fafc; font-weight: 600; }
        .input-sm { width: 60px; padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px; text-align: center; }
        .btn-save-row { background: var(--success); color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
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
                Panel Admin / <span class="text-primary" style="font-weight: 600;">Update Monitoring</span>
            </div>
            <div class="breadcrumb-user">Halo, <span id="admin-name" style="font-weight: 600;">Admin</span></div>
        </div>

        <button class="mobile-sidebar-toggle" onclick="document.getElementById('admin-sidebar').classList.toggle('show')">
            <i data-lucide="menu"></i> Menu Panel Admin
        </button>

        <div class="admin-page-container">
            <!-- Sidebar -->
            <aside class="admin-sidebar" id="admin-sidebar">
                <a href="admin_monitoring.html" class="active"><i data-lucide="activity"></i> Update Monitoring</a>
                <a href="admin_informasi.html"><i data-lucide="file-text"></i> Update Informasi</a>
                <a href="admin_kegiatan.html" id="menu-kegiatan"><i data-lucide="folder-plus"></i> Manajemen Kegiatan</a>
                <a href="admin_user.html" id="menu-user"><i data-lucide="users"></i> Management User</a>
            </aside>

            <!-- Main Content -->
            <main class="admin-content">
                <div class="content-card">
                    <h3 style="margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">Update Progres per Wilayah</h3>
                    <div class="form-group">
                        <label>Pilih Kegiatan untuk Diupdate</label>
                        <select id="select-kegiatan" class="form-control" style="max-width: 400px;"></select>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="progress-table">
                            <thead>
                                <tr>
                                    <th>Wilayah (Kab/Kota)</th>
                                    <th>Target</th>
                                    <th>CAPI Open</th>
                                    <th>CAPI Submit</th>
                                    <th>CAPI Approved</th>
                                    <th>CAPI Rejected</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="progress-tbody">
                                <tr><td colspan="7" style="text-align: center;">Pilih kegiatan terlebih dahulu</td></tr>
                            </tbody>
                        </table>
                    </div>
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

        let kegiatanData = [];

        async function loadKegiatan() {
            try {
                const res = await fetch('/api/kegiatan');
                kegiatanData = await res.json();
                const sel = document.getElementById('select-kegiatan');
                sel.innerHTML = '<option value="">-- Pilih Kegiatan --</option>';
                kegiatanData.forEach(act => {
                    sel.innerHTML += `<option value="${act.id_kegiatan}">${act.nama_kegiatan}</option>`;
                });
                sel.addEventListener('change', loadProgressData);
            } catch (e) { console.error(e); }
        }

        async function loadProgressData() {
            const id_kegiatan = parseInt(document.getElementById('select-kegiatan').value);
            const tbody = document.getElementById('progress-tbody');
            if (!id_kegiatan) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Pilih kegiatan terlebih dahulu</td></tr>';
                return;
            }

            const currentKegiatan = kegiatanData.find(k => k.id_kegiatan === id_kegiatan);
            const isPAPI = currentKegiatan && currentKegiatan.metode_default === 'PAPI';
            
            // Update table header
            const thead = document.querySelector('.progress-table thead tr');
            if (isPAPI) {
                thead.innerHTML = `
                    <th>Wilayah (Kab/Kota)</th>
                    <th>Target</th>
                    <th>Belum Dicacah</th>
                    <th>Dicacah</th>
                    <th>Diolah</th>
                    <th>Aksi</th>
                `;
            } else {
                thead.innerHTML = `
                    <th>Wilayah (Kab/Kota)</th>
                    <th>Target</th>
                    <th>CAPI Open</th>
                    <th>CAPI Submit</th>
                    <th>CAPI Approved</th>
                    <th>CAPI Rejected</th>
                    <th>Aksi</th>
                `;
            }

            try {
                const res = await fetch(`/api/progress-edit/${id_kegiatan}`, { headers: { 'Authorization': `Bearer ${token}` } });
                const data = await res.json();
                tbody.innerHTML = '';
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    if (isPAPI) {
                        tr.innerHTML = `
                            <td>${row.nama_kabkota}</td>
                            <td>${row.target_sampel}</td>
                            <td><input type="number" id="papi_belum_${row.id_progress}" class="input-sm" value="${row.papi_belum_dicacah ?? 0}"></td>
                            <td><input type="number" id="papi_dicacah_${row.id_progress}" class="input-sm" value="${row.papi_dicacah ?? 0}"></td>
                            <td><input type="number" id="papi_diolah_${row.id_progress}" class="input-sm" value="${row.papi_diolah ?? 0}"></td>
                            <td><button class="btn-save-row" onclick="saveRow(${row.id_progress}, 'PAPI')">Update</button></td>
                        `;
                    } else {
                        tr.innerHTML = `
                            <td>${row.nama_kabkota}</td>
                            <td>${row.target_sampel}</td>
                            <td><input type="number" id="open_${row.id_progress}" class="input-sm" value="${row.capi_open ?? 0}"></td>
                            <td><input type="number" id="submit_${row.id_progress}" class="input-sm" value="${row.capi_submit ?? 0}"></td>
                            <td><input type="number" id="app_${row.id_progress}" class="input-sm" value="${row.capi_approved ?? 0}"></td>
                            <td><input type="number" id="rej_${row.id_progress}" class="input-sm" value="${row.capi_rejected ?? 0}"></td>
                            <td><button class="btn-save-row" onclick="saveRow(${row.id_progress}, 'CAPI')">Update</button></td>
                        `;
                    }
                    tbody.appendChild(tr);
                });
            } catch (e) { console.error(e); }
        }

        async function saveRow(id_progress, mode = 'CAPI') {
            let payload = {};
            if (mode === 'PAPI') {
                payload = {
                    papi_belum_dicacah: document.getElementById(`papi_belum_${id_progress}`).value,
                    papi_dicacah: document.getElementById(`papi_dicacah_${id_progress}`).value,
                    papi_diolah: document.getElementById(`papi_diolah_${id_progress}`).value
                };
            } else {
                payload = {
                    capi_open: document.getElementById(`open_${id_progress}`).value,
                    capi_submit: document.getElementById(`submit_${id_progress}`).value,
                    capi_approved: document.getElementById(`app_${id_progress}`).value,
                    capi_rejected: document.getElementById(`rej_${id_progress}`).value
                };
            }
            try {
                const res = await fetch(`/api/progress/${id_progress}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify(payload)
                });
                if (res.ok) alert('Update Berhasil!');
                else alert('Update Gagal!');
            } catch (e) { alert('Update Gagal! Periksa koneksi server.'); }
        }

        loadKegiatan();
    </script>
</body>
</html>
