<?php
session_start();
if (!isset($_SESSION['login_wali'])) {
    header('Location: login.php');
    exit();
}

// Ambil ID wali dari session
$id_wali = $_SESSION['id_wali'];

// Ambil data wali dari database
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/WaliSiswa.php';

$pdo = Database::getConnection();
$waliSiswaModel = new WaliSiswa($pdo);
$waliData = $waliSiswaModel->getById($id_wali);

if (!$waliData) {
    header('Location: ../views/login.php?error=Wali tidak ditemukan.');
    exit();
}

// Ambil data wali
$nama_wali = $waliData['nama_wali'] ?? '';
$nik_wali = $waliData['nik_wali'] ?? '';
$jenis_kelamin_wali = $waliData['jenis_kelamin_wali'] ?? '';
$alamat_wali = $waliData['alamat_wali'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Pendaftaran Siswa</title>
    <link rel="stylesheet" href="../assets/css/register.css" />
</head>
<body>
    <main class="container register-container">
        <h2>Form Pendaftaran Anak</h2>

        <section class="data-wali-info">
            <label for="nama_wali">Nama Wali</label>
            <input type="text" name="nama_wali" id="nama_wali" value="<?= htmlspecialchars($nama_wali); ?>" readonly>

            <label for="nik_wali">NIK Wali</label>
            <input type="text" name="nik_wali" id="nik_wali" value="<?= htmlspecialchars($nik_wali); ?>" readonly>

            <label for="jenis_kelamin_wali">Jenis Kelamin Wali</label>
            <input type="text" name="jenis_kelamin_wali" id="jenis_kelamin_wali" value="<?= htmlspecialchars($jenis_kelamin_wali); ?>" readonly>

            <label for="alamat_wali">Alamat Wali</label>
            <textarea name="alamat_wali" id="alamat_wali" readonly><?= htmlspecialchars($alamat_wali); ?></textarea>
        </section>

        <form action="../controllers/pendaftaran.php" method="post" enctype="multipart/form-data" class="register-form" novalidate>
            <label for="hubungan_wali">Hubungan Wali dengan Anak</label>
            <select name="hubungan_wali" id="hubungan_wali" required>
                <option value="">-- Pilih Hubungan --</option>
                <option value="Ibu Kandung">Ibu Kandung</option>
                <option value="Bapak Kandung">Bapak Kandung</option>
                <option value="Kakak Kandung">Kakak Kandung</option>
                <option value="Adik Kandung">Adik Kandung</option>
                <option value="Keluarga dari Ayah (Bibi/Paman)">Keluarga dari Ayah (Bibi/Paman)</option>
                <option value="Keluarga dari Ibu (Bibi/Paman)">Keluarga dari Ibu (Bibi/Paman)</option>
            </select>

            <label for="nama_siswa">Nama Siswa</label>
            <input type="text" name="nama_siswa" id="nama_siswa" required>

            <label for="nik_siswa">NIK Siswa</label>
            <input type="text" name="nik_siswa" id="nik_siswa" required>

            <label for="jenis_kelamin_siswa">Jenis Kelamin Siswa</label>
            <select name="jenis_kelamin_siswa" id="jenis_kelamin_siswa" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <label for="umur_siswa">Umur Siswa (Tahun)</label>
            <input type="number" name="umur_siswa" id="umur_siswa" min="1" required>

            <label for="alamat_siswa">Alamat Siswa</label>
            <textarea name="alamat_siswa" id="alamat_siswa" required></textarea>

            <label for="foto_siswa">Upload Foto Siswa (jpg/png)</label>
            <input type="file" name="foto_siswa" id="foto_siswa" accept=".jpg,.jpeg,.png" required>

            <label for="akta_kelahiran">Upload Akta Kelahiran (pdf/jpg/png)</label>
            <input type="file" name="akta_kelahiran" id="akta_kelahiran" accept=".pdf, .jpg, .jpeg, .png" required>

            <label for="kk">Upload Kartu Keluarga (pdf/jpg/png)</label>
            <input type="file" name="kk" id="kk" accept=".pdf, .jpg, .jpeg, .png" required>

            <button type="submit" class="btn-primary">Daftar</button>
        </form>

        <p><a href="dashboard_wali.php">← Kembali ke Dashboard</a></p>
    </main>
</body>
</html>
