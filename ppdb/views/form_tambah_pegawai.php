<?php
// session_start();

// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Akun Pegawai</title>
    <style>
        /* ... CSS seperti sebelumnya tetap dipertahankan ... */
    </style>
</head>
<body>

<h2>Tambah Akun Pegawai Baru</h2>

<?php if (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php elseif (isset($_GET['success'])): ?>
    <p style="color:green;">Akun pegawai berhasil dibuat.</p>
<?php endif; ?>

<form method="POST" action="../controllers/proses_tambah_pegawai.php">
    <label>Nama Pegawai</label>
    <input type="text" name="nama_pegawai" required />

    <label>Username</label>
    <input type="text" name="username_pegawai" required />

    <label>Password</label>
    <input type="password" name="password_pegawai" required />

    <label>Role</label>
    <select name="role_pegawai" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="bendahara">Bendahara</option>
        <option value="kepala_sekolah">Kepala Sekolah</option>
    </select>

    <button type="submit">Simpan Akun</button>
</form>

<a href="dashboard_admin.php">← Kembali ke Dashboard Admin</a>

</body>
</html>
