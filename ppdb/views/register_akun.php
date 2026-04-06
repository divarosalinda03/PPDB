<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Akun Wali Siswa</title>
    <link rel="stylesheet" href="../assets/css/register_akun.css" />
</head>

<body>
    <main class="login-container">
        <img src="../uploads/logo.png" alt="Logo PPDB Assalam" class="logo" />
        <h2>Daftar Akun Wali Siswa</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>


        <form action="../controllers/register_akun.php" method="post" class="login-form" novalidate>
            <label for="nama_wali">Nama Wali</label>
            <input type="text" id="nama_wali" name="nama_wali" required />

            <label for="nik_wali">NIK Wali</label>
            <input type="text" id="nik_wali" name="nik_wali" required />

            <label for="jenis_kelamin_wali">Jenis Kelamin Wali</label>
            <select id="jenis_kelamin_wali" name="jenis_kelamin_wali" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <label for="alamat_wali">Alamat Wali</label>
            <textarea id="alamat_wali" name="alamat_wali" required></textarea>

            <label for="username_login">Username Login</label>
            <input type="text" id="username_login" name="username_login" required />

            <label for="password_login">Password Login</label>
            <input type="password" id="password_login" name="password_login" required />

            <button type="submit" class="btn-primary">Buat Akun</button>
        </form>

        <p class="register-text">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </p>
    </main>
</body>
</html>
