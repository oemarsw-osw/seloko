<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kegiatan - Seloko Produksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: var(--primary-container);
        }

        .btn-secondary {
            background-color: #cbd5e1;
            color: #1e293b;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #94a3b8;
        }

        .progress-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            font-size: 13px;
        }

        .progress-table th,
        .progress-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .progress-table th {
            background: #f8fafc;
            font-weight: 600;
        }

        .btn-sm {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            color: white;
            font-weight: 600;
            cursor: pointer;
            font-size: 11px;
            margin-right: 4px;
        }

        .btn-edit {
            background: var(--primary);
        }

        .btn-delete {
            background: var(--error);
        }

        #form-container {
            display: none;
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }
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
                Panel Admin / <span class="text-primary" style="font-weight: 600;">Manajemen Kegiatan</span>
            </div>
            <div class="breadcrumb-user">Halo, <span id="admin-name" style="font-weight: 600;">Admin</span></div>
        </div>

        <button class="mobile-sidebar-toggle"
            onclick="document.getElementById('admin-sidebar').classList.toggle('show')">
            <i data-lucide="menu"></i> Menu Panel Admin
        </button>

        <div class="admin-page-container">
            <!-- Sidebar -->
            <aside class="admin-sidebar" id="admin-sidebar">
                <a href="admin_monitoring.html"><i data-lucide="activity"></i> Update Monitoring</a>
                <a href="admin_informasi.html"><i data-lucide="file-text"></i> Update Informasi</a>
                <a href="admin_kegiatan.html" class="active" id="menu-kegiatan"><i data-lucide="folder-plus"></i>
                    Manajemen Kegiatan</a>
                <a href="admin_user.html" id="menu-user"><i data-lucide="users"></i> Management User</a>
            </aside>

            <!-- Main Content -->
            <main class="admin-content">
                <div class="content-card">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px;">
                        <h3>Daftar Kegiatan</h3>
                        <button class="btn-submit" onclick="showForm('add')"><i data-lucide="plus"
                                style="width: 16px; height: 16px; display: inline-block; vertical-align: text-bottom;"></i>
                            Tambah Kegiatan</button>
                    </div>

                    <!-- Form Container (Hidden by default) -->
                    <div id="form-container">
                        <h4 id="form-title" style="margin-bottom: 16px;">Tambah Kegiatan Baru</h4>
                        <form id="kegiatan-form">
                            <input type="hidden" id="edit_id_kegiatan">
                            <div class="form-group">
                                <label>Tim</label>
                                <select id="id_tim" class="form-control" required>
                                    <option value="">-- Pilih Tim --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Tim</label>
                                <select id="id_sub_tim" class="form-control" required disabled>
                                    <option value="">-- Pilih Tim Terlebih Dahulu --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Kegiatan</label>
                                <input type="text" id="nama_kegiatan" class="form-control"
                                    placeholder="Cth: Survei Konstruksi Tahunan" required>
                            </div>
                            <div class="form-group">
                                <label>Metode Default</label>
                                <select id="metode_default" class="form-control" required>
                                    <option value="CAPI">CAPI</option>
                                    <option value="PAPI">PAPI</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Deadline Kegiatan</label>
                                <input type="date" id="tanggal_deadline" class="form-control" required>
                            </div>
                            <div class="form-group" id="div-target">
                                <label>Jenis Pengisian Target</label>
                                <div style="display: flex; gap: 16px; margin-bottom: 12px; font-size: 13px;">
                                    <label style="font-weight: normal; display: flex; align-items: center; gap: 6px;">
                                        <input type="radio" name="target_type" value="uniform" checked onchange="toggleTargetType(this.value)"> Sama untuk semua Kab/Kota
                                    </label>
                                    <label style="font-weight: normal; display: flex; align-items: center; gap: 6px;">
                                        <input type="radio" name="target_type" value="specific" onchange="toggleTargetType(this.value)"> Spesifik per Kab/Kota
                                    </label>
                                </div>

                                <!-- Uniform Target Input -->
                                <div id="target-uniform-wrapper">
                                    <label>Jumlah Target</label>
                                    <input type="number" id="target_per_kabkota" class="form-control" value="100">
                                </div>

                                <!-- Specific Target Inputs -->
                                <div id="target-specific-wrapper" style="display: none; background: #fff; border: 1px solid #cbd5e1; padding: 16px; border-radius: var(--radius-sm);">
                                    <label style="margin-bottom: 12px;">Target per Kabupaten/Kota</label>
                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;" id="specific-targets-list">
                                        <!-- Populated dynamically -->
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <button type="submit" class="btn-submit">Simpan Kegiatan</button>
                                <button type="button" class="btn-secondary" onclick="hideForm()">Batal</button>
                                <span id="kegiatan-msg" style="margin-left: 12px; font-weight: 600;"></span>
                            </div>
                        </form>
                    </div>

                    <!-- Kegiatan Table -->
                    <div style="overflow-x: auto;">
                        <table class="progress-table">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Tim</th>
                                    <th>Sub Tim</th>
                                    <th>Metode Default</th>
                                    <th>Tanggal Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="kegiatan-tbody">
                                <tr>
                                    <td colspan="6" style="text-align: center;">Memuat data...</td>
                                </tr>
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

        // Allow all roles to access this page
        // if (role !== 'admin_prov') {
        //     alert('Akses Ditolak. Hanya Admin Provinsi.');
        //     window.location.href = 'admin_monitoring.html';
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

        let isEditMode = false;
        let allSubTims = [];
        let kegiatanData = [];

        // Load Tim Dropdown
        async function loadTim() {
            try {
                const res = await fetch('/api/tim');
                const data = await res.json();
                const selTim = document.getElementById('id_tim');
                selTim.innerHTML = '<option value="">-- Pilih Tim --</option>';
                data.forEach(t => {
                    selTim.innerHTML += `<option value="${t.id_tim}">${t.nama_tim}</option>`;
                });
            } catch (e) { console.error(e); }
        }

        // Load Sub Tim Data
        async function fetchSubTim() {
            try {
                const res = await fetch('/api/subtim');
                allSubTims = await res.json();
            } catch (e) { console.error(e); }
        }

        // Filter Sub Tim when Tim changes
        document.getElementById('id_tim').addEventListener('change', function () {
            const idTim = this.value;
            const selSub = document.getElementById('id_sub_tim');

            if (!idTim) {
                selSub.innerHTML = '<option value="">-- Pilih Tim Terlebih Dahulu --</option>';
                selSub.disabled = true;
                return;
            }

            selSub.disabled = false;
            selSub.innerHTML = '<option value="">-- Pilih Sub Tim --</option>';
            const filtered = allSubTims.filter(st => st.id_tim == idTim);
            filtered.forEach(st => {
                selSub.innerHTML += `<option value="${st.id_sub_tim}">${st.nama_sub_tim}</option>`;
            });
        });

        // Fetch Kegiatan Table
        async function fetchKegiatan() {
            try {
                const res = await fetch('/api/kegiatan');
                kegiatanData = await res.json();
                const tbody = document.getElementById('kegiatan-tbody');
                tbody.innerHTML = '';

                kegiatanData.forEach(k => {
                    let formattedDate = '-';
                    let deadlineBadge = `<span style="background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 11px;">-</span>`;
                    if (k.tanggal_deadline) {
                        const d = new Date(k.tanggal_deadline);
                        formattedDate = d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                        deadlineBadge = `<span style="background: #fee2e2; color: #ba1a1a; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 11px;"><i data-lucide="calendar" style="width: 12px; height: 12px; display: inline-block; vertical-align: text-bottom; margin-right: 4px;"></i>${formattedDate}</span>`;
                    }
                    tbody.innerHTML += `
                        <tr>
                            <td><strong>${k.nama_kegiatan}</strong></td>
                            <td>${k.nama_tim}</td>
                            <td>${k.nama_sub_tim}</td>
                            <td><span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 11px;">${k.metode_default || 'CAPI'}</span></td>
                            <td>${deadlineBadge}</td>
                            <td>
                                <button class="btn-sm btn-edit" onclick="editKegiatan(${k.id_kegiatan})">Edit</button>
                                <button class="btn-sm btn-delete" onclick="deleteKegiatan(${k.id_kegiatan})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
                lucide.createIcons();
            } catch (e) { console.error(e); }
        }

        const listKabkota = [
            { id: '1501', nama: 'Kerinci' },
            { id: '1502', nama: 'Merangin' },
            { id: '1503', nama: 'Sarolangun' },
            { id: '1504', nama: 'Batanghari' },
            { id: '1505', nama: 'Muaro Jambi' },
            { id: '1507', nama: 'Tanjung Jabung Barat' },
            { id: '1506', nama: 'Tanjung Jabung Timur' },
            { id: '1509', nama: 'Bungo' },
            { id: '1508', nama: 'Tebo' },
            { id: '1571', nama: 'Kota Jambi' },
            { id: '1572', nama: 'Kota Sungai Penuh' }
        ];

        function initSpecificTargetsList() {
            const container = document.getElementById('specific-targets-list');
            container.innerHTML = '';
            listKabkota.forEach(kk => {
                container.innerHTML += `
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 4px;">${kk.nama}</label>
                        <input type="number" id="target_kabkota_${kk.id}" class="form-control target-specific-input" value="100" min="0">
                    </div>
                `;
            });
        }

        function toggleTargetType(val) {
            if (val === 'uniform') {
                document.getElementById('target-uniform-wrapper').style.display = 'block';
                document.getElementById('target-specific-wrapper').style.display = 'none';
                document.getElementById('target_per_kabkota').required = true;
                document.querySelectorAll('.target-specific-input').forEach(inp => inp.required = false);
            } else {
                document.getElementById('target-uniform-wrapper').style.display = 'none';
                document.getElementById('target-specific-wrapper').style.display = 'block';
                document.getElementById('target_per_kabkota').required = false;
                document.querySelectorAll('.target-specific-input').forEach(inp => inp.required = true);
            }
        }

        function showForm(mode, id = null) {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('kegiatan-form').reset();
            document.getElementById('id_sub_tim').disabled = true;
            document.getElementById('id_sub_tim').innerHTML = '<option value="">-- Pilih Tim Terlebih Dahulu --</option>';
            document.getElementById('kegiatan-msg').innerText = '';

            if (mode === 'add') {
                isEditMode = false;
                document.getElementById('form-title').innerText = 'Tambah Kegiatan Baru';
                document.getElementById('div-target').style.display = 'block';
                
                // Reset radios to uniform
                document.querySelectorAll('input[name="target_type"]').forEach(r => {
                    if (r.value === 'uniform') r.checked = true;
                });
                toggleTargetType('uniform');
                document.getElementById('target_per_kabkota').value = '100';
                initSpecificTargetsList();
                document.getElementById('tanggal_deadline').value = '';

                document.getElementById('edit_id_kegiatan').value = '';
            } else if (mode === 'edit') {
                isEditMode = true;
                document.getElementById('form-title').innerText = 'Edit Kegiatan';
                document.getElementById('div-target').style.display = 'block';

                const kegiatan = kegiatanData.find(k => k.id_kegiatan === id);
                if (kegiatan) {
                    document.getElementById('edit_id_kegiatan').value = kegiatan.id_kegiatan;
                    document.getElementById('nama_kegiatan').value = kegiatan.nama_kegiatan;
                    document.getElementById('metode_default').value = kegiatan.metode_default || 'CAPI';
                    document.getElementById('tanggal_deadline').value = kegiatan.tanggal_deadline || '';
                    document.getElementById('id_tim').value = kegiatan.id_tim;

                    // Manually trigger filter and select the correct sub tim
                    const selSub = document.getElementById('id_sub_tim');
                    selSub.disabled = false;
                    selSub.innerHTML = '<option value="">-- Pilih Sub Tim --</option>';
                    const filtered = allSubTims.filter(st => st.id_tim == kegiatan.id_tim);
                    filtered.forEach(st => {
                        selSub.innerHTML += `<option value="${st.id_sub_tim}">${st.nama_sub_tim}</option>`;
                    });
                    selSub.value = kegiatan.id_sub_tim;

                    // Fetch targets and populate
                    initSpecificTargetsList();
                    fetch(`/api/progress-edit/${id}`, { headers: { 'Authorization': `Bearer ${token}` } })
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                // Check if all targets are identical
                                const firstTarget = data[0].target_sampel;
                                const isUniform = data.every(row => row.target_sampel === firstTarget);

                                // Populate specific target inputs anyway
                                data.forEach(row => {
                                    const input = document.getElementById(`target_kabkota_${row.id_kabkota}`);
                                    if (input) input.value = row.target_sampel;
                                });

                                if (isUniform) {
                                    document.querySelectorAll('input[name="target_type"]').forEach(r => {
                                        if (r.value === 'uniform') r.checked = true;
                                    });
                                    toggleTargetType('uniform');
                                    document.getElementById('target_per_kabkota').value = firstTarget;
                                } else {
                                    document.querySelectorAll('input[name="target_type"]').forEach(r => {
                                        if (r.value === 'specific') r.checked = true;
                                    });
                                    toggleTargetType('specific');
                                }
                            }
                        })
                        .catch(err => console.error('Gagal mengambil target kegiatan:', err));
                }
            }
        }

        function hideForm() {
            document.getElementById('form-container').style.display = 'none';
        }

        function editKegiatan(id) {
            showForm('edit', id);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        async function deleteKegiatan(id) {
            const confirmResult = await Swal.fire({
                title: 'Hapus Kegiatan?',
                text: "Menghapus kegiatan juga akan menghapus semua target, progress, history, dan dokumen survei terkait!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!'
            });

            if (!confirmResult.isConfirmed) return;

            try {
                const res = await fetch(`/api/kegiatan/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (res.ok) {
                    Swal.fire('Terhapus!', 'Kegiatan berhasil dihapus.', 'success');
                    fetchKegiatan();
                } else {
                    const data = await res.json();
                    Swal.fire('Gagal!', data.error, 'error');
                }
            } catch (e) { Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error'); }
        }

        document.getElementById('kegiatan-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const payload = {
                id_sub_tim: document.getElementById('id_sub_tim').value,
                nama_kegiatan: document.getElementById('nama_kegiatan').value,
                metode_default: document.getElementById('metode_default').value,
                tanggal_deadline: document.getElementById('tanggal_deadline').value || null
            };

            const targetType = document.querySelector('input[name="target_type"]:checked').value;
            if (targetType === 'uniform') {
                payload.target_per_kabkota = document.getElementById('target_per_kabkota').value;
            } else {
                const specific = {};
                listKabkota.forEach(kk => {
                    specific[kk.id] = document.getElementById(`target_kabkota_${kk.id}`).value;
                });
                payload.target_spesifik = specific;
            }

            const url = isEditMode ? `/api/kegiatan/${document.getElementById('edit_id_kegiatan').value}` : '/api/kegiatan';
            const method = isEditMode ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: isEditMode ? 'Data kegiatan diperbarui.' : 'Kegiatan baru ditambahkan.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    document.getElementById('kegiatan-msg').innerText = '';
                    fetchKegiatan();
                    setTimeout(() => { hideForm(); }, 1500);
                } else {
                    const data = await res.json();
                    Swal.fire('Gagal!', data.error, 'error');
                }
            } catch (e) { console.error(e); }
        });

        // Initialize Data
        async function init() {
            await loadTim();
            await fetchSubTim();
            await fetchKegiatan();
        }
        init();
    </script>
</body>

</html>
