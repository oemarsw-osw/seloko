<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Seloko Produksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 120px);
            padding: 24px 0;
        }
        .login-split {
            display: flex;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            box-shadow: var(--shadow-sm);
        }
        .login-branding {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), #059669);
            color: white;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-branding h1 {
            font-size: 32px;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        .login-branding p {
            font-size: 15px;
            opacity: 0.9;
            line-height: 1.6;
        }
        .login-form-side {
            flex: 1;
            padding: 48px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        @media (max-width: 768px) {
            .login-split {
                flex-direction: column;
                max-width: 450px;
            }
            .login-branding {
                padding: 32px;
                text-align: center;
            }
            .login-form-side {
                padding: 32px;
            }
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group label {
            font-size: 14px;
            font-weight: 600;
        }
        .form-control {
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        .login-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .login-btn:hover {
            background-color: var(--primary-container);
        }
    </style>
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
                <a href="tentang.html">Tentang</a>
                <a href="login.html" class="active">Login</a>
            </div>
        </nav>

        <div class="login-wrapper">
            <div class="login-split">
                <div class="login-branding">
                    <img src="logo.png" alt="Logo" style="width: 80px; height: auto; margin-bottom: 24px; filter: brightness(0) invert(1);">
                    <h1>BPS Jambi<br>Seloko Produksi</h1>
                    <p>Sistem manajemen monitoring statistik produksi. Kelola tim, perbarui capaian, dan pantau penyelesaian survei dengan lebih cepat dan terpusat.</p>
                </div>
                
                <div class="login-form-side">
                    <div style="margin-bottom: 24px; text-align: center;">
                        <i data-lucide="user-circle" style="width: 48px; height: 48px; color: var(--primary);"></i>
                        <h2 style="font-family: var(--font-head); margin-top: 12px; font-size: 24px;">Login</h2>
                    </div>
                    
                    <div id="login-error" style="color: var(--error); background: var(--error-container); padding: 12px; border-radius: 8px; font-size: 13px; display: none; margin-bottom: 16px;"></div>

                    <form id="login-form">
                        <div class="form-group">
                            <label for="nip">Username</label>
                            <input type="text" id="nip" class="form-control" placeholder="Masukkan Username" required>
                        </div>
                        <div class="form-group" style="margin-top: 12px;">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>
                        <button type="submit" class="login-btn" style="margin-top: 24px; width: 100%;">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Jika sudah login, langsung ke admin panel
        if (localStorage.getItem('token')) {
            window.location.href = 'admin_monitoring.html';
        }

        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const nip = document.getElementById('nip').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('login-error');

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nip, password })
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('token', data.token);
                    localStorage.setItem('user_role', data.role);
                    localStorage.setItem('user_nama', data.nama);
                    
                    Swal.fire({
                        title: 'Login Berhasil!',
                        text: `Selamat datang, ${data.nama}`,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'admin_monitoring.html';
                    });
                } else {
                    Swal.fire('Login Gagal', data.error, 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'Koneksi ke server gagal.', 'error');
            }
        });
    </script>
</body>
</html>
