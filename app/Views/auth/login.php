<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: #ffffff;
            border: 1px solid #dadce0;
            border-radius: 8px;
        }
        .login-title {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #202124;
            text-align: center;
        }
        .login-subtitle {
            font-size: 16px;
            color: #5f6368;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            border: 1px solid #dadce0;
            padding: 10px 15px;
            height: auto;
        }
        .form-control:focus {
            border-color: #1a73e8;
            box-shadow: none;
        }
        /* Style untuk container password dan ikon mata */
        .password-group {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 38px;
            cursor: pointer;
            color: #5f6368;
            z-index: 10;
        }
        .btn-login {
            background-color: #1a73e8;
            color: white;
            font-weight: 500;
            padding: 10px;
            border-radius: 4px;
            border: none;
            width: 100%;
            margin-top: 10px;
        }
        .btn-login:hover {
            background-color: #1765cc;
        }
        .error-msg {
            font-size: 14px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2 class="login-title">E-Pinjam</h2>
    <p class="login-subtitle">Gunakan Akun Anda</p>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger error-msg py-2 mb-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="/proses-login" method="post">
        <?= csrf_field(); ?>
        
        <div class="mb-3">
            <label for="username" class="form-label small fw-medium">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required autofocus>
        </div>

        <div class="mb-4 password-group">
            <label for="password" class="form-label small fw-medium">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
            <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
        </div>

        <button type="submit" class="btn btn-login shadow-sm">Login</button>
    </form>
    
    <div class="mt-5 text-center">
        <small class="text-muted">Aplikasi Peminjaman Alat &copy; 2026</small>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // Toggle tipe input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle ikon mata
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>