<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management User - Seloko Produksi</title>
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
        .btn-secondary { background-color: #94a3b8; color: white; border: none; padding: 10px 20px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; }
        .btn-secondary:hover { background-color: #64748b; }
        
        .progress-table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 13px; }
        .progress-table th, .progress-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .progress-table th { background: #f8fafc; font-weight: 600; }
        .btn-sm { padding: 6px 10px; font-size: 12px; border-radius: 4px; border: none; cursor: pointer; font-weight: 600; color: white; margin-right: 4px; }
        .btn-edit { background: var(--primary); }
        .btn-delete { background: var(--error); }
        
        #form-container { display: none; background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #e2e8f0; }
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
                Panel Admin / <span class="text-primary" style="font-weight: 600;">Management User</span>
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
                <a href="admin_informasi.html"><i data-lucide="file-text"></i> Update Informasi</a>
                <a href="admin_kegiatan.html" id="menu-kegiatan"><i data-lucide="folder-plus"></i> Manajemen Kegiatan</a>
                <a href="admin_user.html" class="active" id="menu-user"><i data-lucide="users"></i> Management User</a>
            </aside>

            <!-- Main Content -->
            <main class="admin-content">
                <div class="content-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px;">
                        <h3>Daftar Pengguna Sistem</h3>
                        <button class="btn-submit" onclick="showForm('add')"><i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: text-bottom;"></i> Tambah User</button>
                    </div>

                    <!-- Form Container (Hidden by default) -->
                    <div id="form-container">
                        <h4 id="form-title" style="margin-bottom: 16px;">Tambah User Baru</h4>
                        <form id="user-form">
                            <input type="hidden" id="edit_id_user">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="nama_user" class="form-control" placeholder="Nama Pegawai" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="nip" class="form-control" placeholder="Masukkan Username" required>
                            </div>
                            <div class="form-group">
                                <label>Password <span id="password-hint" style="font-weight: normal; color: #64748b; font-size: 11px;">(Kosongkan jika tidak ingin mengubah saat edit)</span></label>
                                <input type="password" id="password" class="form-control" placeholder="Masukkan Password">
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select id="role" class="form-control" required>
                                    <option value="admin_prov">Admin Provinsi</option>
                                    <option value="admin_sub_tim">Admin Sub Tim</option>
                                    <option value="operator_kabkota">Operator Kab/Kota</option>
                                </select>
                            </div>
                            <div class="form-group" id="div-subtim" style="display: none;">
                                <label>Pilih Sub Tim (Khusus Admin Sub Tim)</label>
                                <select id="id_sub_tim" class="form-control">
                                    <option value="">-- Memuat Sub Tim... --</option>
                                </select>
                            </div>
                            <div class="form-group" id="div-kabkota" style="display: none;">
                                <label>Kabupaten / Kota</label>
                                <select id="id_kabkota" class="form-control">
                                    <option value="">-- Pilih Kab/Kota --</option>
                                    <option value="1501">Kerinci</option>
                                    <option value="1502">Merangin</option>
                                    <option value="1503">Sarolangun</option>
                                    <option value="1504">Batanghari</option>
                                    <option value="1505">Muaro Jambi</option>
                                    <option value="1506">Tanjung Jabung Timur</option>
                                    <option value="1507">Tanjung Jabung Barat</option>
                                    <option value="1508">Tebo</option>
                                    <option value="1509">Bungo</option>
                                    <option value="1571">Kota Jambi</option>
                                    <option value="1572">Kota Sungai Penuh</option>
                                </select>
                            </div>
                            <div style="margin-top: 16px;">
                                <button type="submit" class="btn-submit">Simpan User</button>
                                <button type="button" class="btn-secondary" onclick="hideForm()">Batal</button>
                                <span id="user-msg" style="margin-left: 12px; font-weight: 600;"></span>
                            </div>
                        </form>
                    </div>

                    <!-- User Table -->
                    <div style="overflow-x: auto;">
                        <table class="progress-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Wilayah / Tim</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="user-tbody">
                                <tr><td colspan="5" style="text-align: center;">Memuat data...</td></tr>
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
        const roleUser = localStorage.getItem('user_role');
        const namaUser = localStorage.getItem('user_nama');
        const myUserId = localStorage.getItem('user_id'); // If stored, to prevent self delete visually

        if (!token) window.location.href = 'login.html';

        document.getElementById('admin-name').innerText = namaUser || 'Admin';

        // Allow all roles to access this page
        // if (roleUser !== 'admin_prov') {
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
        let usersData = [];

        // Load Sub Tim Dropdown
        async function loadSubTim() {
            try {
                const res = await fetch('/api/subtim');
                const data = await res.json();
                const sel = document.getElementById('id_sub_tim');
                sel.innerHTML = '<option value="">-- Pilih Sub Tim --</option>';
                data.forEach(st => {
                    sel.innerHTML += `<option value="${st.id_sub_tim}">${st.nama_sub_tim}</option>`;
                });
            } catch (e) { console.error(e); }
        }
        loadSubTim();

        // Handle Role Change
        document.getElementById('role').addEventListener('change', function() {
            document.getElementById('div-kabkota').style.display = 'none';
            document.getElementById('div-subtim').style.display = 'none';

            if(this.value === 'operator_kabkota') {
                document.getElementById('div-kabkota').style.display = 'block';
            } else if(this.value === 'admin_sub_tim') {
                document.getElementById('div-subtim').style.display = 'block';
            }
        });

        // Fetch Users Table
        async function fetchUsers() {
            try {
                const res = await fetch('/api/user', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                usersData = await res.json();
                const tbody = document.getElementById('user-tbody');
                tbody.innerHTML = '';
                
                usersData.forEach(u => {
                    let ket = '-';
                    if (u.role === 'operator_kabkota' && u.nama_kabkota) ket = `Operator: ${u.nama_kabkota}`;
                    else if (u.role === 'admin_sub_tim' && u.nama_sub_tim) ket = `Admin Sub: ${u.nama_sub_tim}`;
                    else if (u.role === 'admin_prov') ket = 'Provinsi';

                    tbody.innerHTML += `
                        <tr>
                            <td>${u.nip}</td>
                            <td>${u.nama_user}</td>
                            <td>${u.role}</td>
                            <td>${ket}</td>
                            <td>
                                <button class="btn-sm btn-edit" onclick="editUser(${u.id_user})">Edit</button>
                                <button class="btn-sm btn-delete" onclick="deleteUser(${u.id_user})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
            } catch (e) { console.error(e); }
        }

        function showForm(mode, id = null) {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('user-form').reset();
            document.getElementById('div-kabkota').style.display = 'none';
            document.getElementById('div-subtim').style.display = 'none';
            document.getElementById('user-msg').innerText = '';

            if (mode === 'add') {
                isEditMode = false;
                document.getElementById('form-title').innerText = 'Tambah User Baru';
                document.getElementById('password').required = true;
                document.getElementById('password-hint').style.display = 'none';
                document.getElementById('edit_id_user').value = '';
            } else if (mode === 'edit') {
                isEditMode = true;
                document.getElementById('form-title').innerText = 'Edit User';
                document.getElementById('password').required = false;
                document.getElementById('password-hint').style.display = 'inline';
                
                const user = usersData.find(u => u.id_user === id);
                if (user) {
                    document.getElementById('edit_id_user').value = user.id_user;
                    document.getElementById('nip').value = user.nip;
                    document.getElementById('nama_user').value = user.nama_user;
                    document.getElementById('role').value = user.role;
                    
                    if (user.role === 'operator_kabkota') {
                        document.getElementById('div-kabkota').style.display = 'block';
                        document.getElementById('id_kabkota').value = user.id_kabkota || '';
                    } else if (user.role === 'admin_sub_tim') {
                        document.getElementById('div-subtim').style.display = 'block';
                        document.getElementById('id_sub_tim').value = user.id_sub_tim || '';
                    }
                }
            }
        }

        function hideForm() {
            document.getElementById('form-container').style.display = 'none';
        }

        function editUser(id) {
            showForm('edit', id);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        async function deleteUser(id) {
            const confirmResult = await Swal.fire({
                title: 'Hapus User?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!'
            });
            
            if (!confirmResult.isConfirmed) return;
            
            try {
                const res = await fetch(`/api/user/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (res.ok) {
                    Swal.fire('Terhapus!', 'User berhasil dihapus.', 'success');
                    fetchUsers();
                } else {
                    const data = await res.json();
                    Swal.fire('Gagal!', data.error, 'error');
                }
            } catch (e) { Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error'); }
        }

        document.getElementById('user-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const payload = {
                nama_user: document.getElementById('nama_user').value,
                nip: document.getElementById('nip').value,
                password: document.getElementById('password').value,
                role: document.getElementById('role').value,
                id_kabkota: document.getElementById('role').value === 'operator_kabkota' ? document.getElementById('id_kabkota').value : null,
                id_sub_tim: document.getElementById('role').value === 'admin_sub_tim' ? document.getElementById('id_sub_tim').value : null
            };

            const url = isEditMode ? `/api/user/${document.getElementById('edit_id_user').value}` : '/api/user';
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
                        text: isEditMode ? 'Data user diperbarui.' : 'User baru ditambahkan.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    document.getElementById('user-msg').innerText = '';
                    fetchUsers();
                    setTimeout(() => { hideForm(); }, 1500);
                } else {
                    const data = await res.json();
                    Swal.fire('Gagal!', data.error, 'error');
                }
            } catch (e) { console.error(e); }
        });

        // Initialize table
        fetchUsers();
    </script>
</body>
</html>
