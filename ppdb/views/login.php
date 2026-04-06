<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login PPDB</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>
    <main class="login-container">
        <h2>Login PPDB</h2>

        <?php if (isset($_GET['login_error'])): ?>
            <p class="error-message">Username atau Password salah!</p>
        <?php endif; ?>
        <?php if (isset($_GET['register_success'])): ?>
            <p class="success-message">Pendaftaran berhasil, silakan buat akun login.</p>
        <?php endif; ?>
        <?php if (isset($_GET['akun_created'])): ?>
            <p class="success-message">Akun berhasil dibuat, silakan login.</p>
        <?php endif; ?>

        <form action="../controllers/auth.php" method="post" class="login-form" novalidate>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autocomplete="username" />

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required autocomplete="current-password" />

            <button type="submit" class="btn-primary">Login</button>
        </form>

        <p class="register-text">Belum punya akun? <a href="register_akun.php">Buat Akun Wali Siswa di sini</a></p>
    </main>
</body>
</html>

