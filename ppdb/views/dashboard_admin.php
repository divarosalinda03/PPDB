<?php
session_start();
if (!isset($_SESSION['login_pegawai'])) {
    header('Location: login.php');
    exit();
}

$role = $_SESSION['user']['role'];

echo "<h1>Selamat Datang, " . htmlspecialchars($_SESSION['user']['nama_pegawai']) . "</h1>";
echo "<p>Role Anda: <strong>" . htmlspecialchars($role) . "</strong></p>";

// Bisa bikin tampilan beda berdasarkan role
if ($role === 'admin') {
    echo "<p>Ini halaman untuk admin.</p>";
} elseif ($role === 'bendahara') {
    echo "<p>Ini halaman untuk bendahara.</p>";
} elseif ($role === 'staf') {
    echo "<p>Ini halaman untuk staf biasa.</p>";
}
?>

<?php
// Tambahkan ini di bagian atas file dashboard_admin.php
require_once __DIR__ . '/../config/database.php'; // Pastikan ini ada untuk mengimpor koneksi database

// Dapatkan koneksi database
$pdo = Database::getConnection(); // Inisialisasi koneksi database

require_once __DIR__ . '/../models/Tagihan.php';
$tagihanModel = new Tagihan($pdo);
$tagihanList = $tagihanModel->getAll();

require_once __DIR__ . '/../models/WaliSiswa.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/Pembayaran.php';

$waliModel = new WaliSiswa($pdo);
$selectedSiswaModel = new Siswa($pdo);
$pembayaranModel = new Pembayaran($pdo);

// Fetch data
$waliList = $waliModel->getAll();
$selectedSiswaList = $selectedSiswaModel->getAll();
$pembayaranList = $pembayaranModel->getAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/dashboard_admin.css" />
    <script src="../assets/js/dashboard_admin.js" defer></script>
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <h1>Dashboard Admin</h1>
            <div class="hamburger" onclick="toggleMenu()">&#9776;</div>
            <nav class="menu-bar" id="menuBar">
                <a href="form_tambah_tagihan.php">Tagihan Baru</a>
                <a href="form_pembayaran.php">Tambah Pembayaran Baru</a>
                <a href="rincian_biaya.php">Kelola Rincian Biaya</a>
                <a href="register.php">Daftar Wali + Siswa Baru</a>
                <a href="form_tambah_pegawai.php">Tambah Akun Pegawai Baru</a>
                <a href="tambah_akun_wali.php">Tambah Akun Wali Siswa Baru</a>
                <a href="manage_siswa_wali.php">Kelola Data Siswa</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <h3>Data Wali Siswa</h3>
    <table border="1">
        <tr>
            <th>Nama Wali</th>
            <th>NIK</th>
            <th>Hubungan</th>
            <th>Alamat</th>
        </tr>
        <?php foreach ($waliList as $wali): ?>
            <tr>
                <td><?= htmlspecialchars($wali['nama_wali']) ?></td>
                <td><?= htmlspecialchars($wali['nik_wali']) ?></td>
                <td><?= htmlspecialchars($wali['hubungan_wali']) ?></td>
                <td><?= htmlspecialchars($wali['alamat_wali']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Data Siswa</h3>
    <table border="1">
        <tr>
            <th>Nama Siswa</th>
            <th>NIK</th>
            <th>Jenis Kelamin</th>
            <th>Umur</th>
            <th>Alamat</th>
        </tr>
        <?php foreach ($selectedSiswaList as $selectedSiswa): ?>
            <tr>
                <td><?= htmlspecialchars($selectedSiswa['nama_siswa']) ?></td>
                <td><?= htmlspecialchars($selectedSiswa['nik_siswa']) ?></td>
                <td><?= htmlspecialchars($selectedSiswa['jenis_kelamin_siswa']) ?></td>
                <td><?= htmlspecialchars($selectedSiswa['umur_siswa']) ?></td>
                <td><?= htmlspecialchars($selectedSiswa['alamat_siswa']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Data Tagihan</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Wali</th>
            <th>Bulan Tagihan</th>
            <th>Nominal</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
        </tr>
        <?php foreach ($tagihanList as $tagihan): ?>
            <tr>
                <td><?= htmlspecialchars($tagihan['nama_wali']) ?></td>
                <td><?= htmlspecialchars($tagihan['bulan_tagihan']) ?></td>
                <td><?= number_format($tagihan['nominal_tagihan'], 2) ?></td>
                <td><?= htmlspecialchars($tagihan['tanggal_jatuh_tempo']) ?></td>
                <td><?= htmlspecialchars($tagihan['status_tagihan']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Riwayat Pembayaran</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Wali</th>
            <th>Bulan Tagihan</th>
            <th>Nominal Tagihan</th>
            <th>Tanggal Bayar</th>
            <th>Nominal Dibayar</th>
            <th>Metode</th>
            <th>Keterangan</th>
        </tr>
        <?php foreach ($pembayaranList as $pembayaran): ?>
            <tr>
                <td><?= htmlspecialchars($pembayaran['nama_wali']) ?></td>
                <td><?= htmlspecialchars($pembayaran['bulan_tagihan']) ?></td>
                <td><?= number_format($pembayaran['nominal_tagihan'], 2) ?></td>
                <td><?= htmlspecialchars($pembayaran['tanggal_pembayaran']) ?></td>
                <td><?= number_format($pembayaran['nominal_dibayar'], 2) ?></td>
                <td><?= htmlspecialchars($pembayaran['metode_pembayaran']) ?></td>
                <td><?= htmlspecialchars($pembayaran['keterangan_pembayaran']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard_admin.php">← Kembali ke Dashboard Admin</a>
</body>
</html>
