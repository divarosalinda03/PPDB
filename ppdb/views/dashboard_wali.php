<?php
session_start();
if (!isset($_SESSION['login_wali'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['anak'])) {
    $_SESSION['anak_aktif'] = intval($_GET['anak']);
}
$anak_aktif = $_SESSION['anak_aktif'] ?? 0;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/HasilSeleksi.php';
require_once __DIR__ . '/../models/Tagihan.php';
require_once __DIR__ . '/../models/Pembayaran.php';

// Dapatkan koneksi database
$pdo = Database::getConnection();

$id_wali = $_SESSION['id_wali'];

$siswaModel = new Siswa($pdo);
$hasilSeleksiModel = new HasilSeleksi($pdo);
$tagihanModel = new Tagihan($pdo);
$pembayaranModel = new Pembayaran($pdo);

// Ambil data
$siswaList = $siswaModel->getListByWaliId($id_wali);
$selectedSiswa = $siswaList[$anak_aktif] ?? null;
$hasilSeleksi = $selectedSiswa ? $hasilSeleksiModel->getBySiswaId($selectedSiswa['id_siswa']) : null;
$tagihanList = $tagihanModel->getByWaliId($id_wali);
$pembayaranList = $pembayaranModel->getByWaliId($id_wali);

// FIX: tambahkan '../' karena file ini ada di folder views/
//      sehingga path ke uploads harus naik satu level dulu
$defaultImage = '../uploads/default_profile.png';

function fileUrl($filename, $type = 'foto') {
    if (empty($filename)) return null;

    // FIX: tambahkan '../' di semua path
    switch ($type) {
        case 'kk':
            return '../uploads/kk/' . $filename;
        case 'akta':
            return '../uploads/akta/' . $filename;
        default:
            return '../uploads/foto/' . $filename;
    }
}

$foto_siswa = $selectedSiswa && !empty($selectedSiswa['foto_siswa'])
              ? fileUrl($selectedSiswa['foto_siswa'], 'foto')
              : $defaultImage;

$kk_siswa = $selectedSiswa && !empty($selectedSiswa['kk_siswa'])
            ? fileUrl($selectedSiswa['kk_siswa'], 'kk')
            : null;

$akta_siswa = $selectedSiswa && !empty($selectedSiswa['akta_kelahiran_siswa'])
              ? fileUrl($selectedSiswa['akta_kelahiran_siswa'], 'akta')
              : null;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Wali Siswa</title>
    <link rel="stylesheet" href="../assets/css/dashboard_wali.css" />
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <h1>Halo, <?= htmlspecialchars($_SESSION['nama_wali']); ?>!</h1>
            <div class="hamburger" onclick="toggleMenu()">&#9776;</div>
            <nav class="menu-bar" id="menuBar">
                <a href="register.php" class="btn-primary">Pendaftaran</a>
                <a href="form_pembayaran.php" class="btn-primary">Pembayaran</a>
                <a href="#riwayat-pendaftaran-section" class="btn-primary">Riwayat Pendaftaran</a>
                <a href="#riwayat-pembayaran-section" class="btn-primary">Riwayat Pembayaran</a>
                <a href="../controllers/logout.php" class="btn-logout">Logout</a>
            </nav>
        </div>
    </header>

    <?php if (count($siswaList) > 1): ?>
        <div style="margin: 20px;" class="pilih-profil-anak">
            <label for="pilih_anak">Pilih Profil Anak:</label>
            <select id="pilih_anak" class="dropdown-anak" onchange="window.location='dashboard_wali.php?anak=' + this.value">
                <?php foreach ($siswaList as $index => $anak): ?>
                    <option value="<?= $index ?>" <?= ($index === $anak_aktif ? 'selected' : '') ?>>
                        <?= htmlspecialchars($anak['nama_siswa']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <main class="container">
        <section class="profile-section">
            <table class="profile-table">
                <tr>
                    <td class="anak-photo-cell">
                        <a href="<?= $foto_siswa ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?= $foto_siswa ?>" alt="Foto Anak" class="anak-photo">
                        </a>
                    </td>
                    <td class="profile-data-cell">
                        <h2>Data Wali & Anak</h2>
                        <table class="data-table">
                            <tr><th>Nama Wali</th><td><?= htmlspecialchars($_SESSION['nama_wali']) ?></td></tr>
                            <?php if ($selectedSiswa): ?>
                                <tr><th>Nama Anak</th><td><?= htmlspecialchars($selectedSiswa['nama_siswa']) ?></td></tr>
                                <tr><th>NIK Anak</th><td><?= htmlspecialchars($selectedSiswa['nik_siswa']) ?></td></tr>
                                <tr><th>Jenis Kelamin</th><td><?= htmlspecialchars($selectedSiswa['jenis_kelamin_siswa']) ?></td></tr>
                                <tr><th>Umur</th><td><?= htmlspecialchars($selectedSiswa['umur_siswa']) ?></td></tr>
                                <tr><th>Alamat</th><td><?= htmlspecialchars($selectedSiswa['alamat_siswa']) ?></td></tr>
                                <tr>
                                    <th>Akta</th>
                                    <td>
                                        <?php if ($akta_siswa): ?>
                                            <a href="<?= $akta_siswa ?>" target="_blank" rel="noopener noreferrer">Lihat Akta</a>
                                        <?php else: ?>
                                            Tidak ada file
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>KK</th>
                                    <td>
                                        <?php if ($kk_siswa): ?>
                                            <a href="<?= $kk_siswa ?>" target="_blank" rel="noopener noreferrer">Lihat KK</a>
                                        <?php else: ?>
                                            Tidak ada file
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="2">Data anak belum tersedia.</td></tr>
                            <?php endif; ?>
                        </table>

                        <div class="status-pendaftaran">
                            <h3>Status Pendaftaran</h3>
                            <?php if ($hasilSeleksi): ?>
                                <p class="<?= $hasilSeleksi['status_pendaftaran'] === 'Diterima' ? 'status-diterima' : 'status-ditolak'; ?>">
                                    <?= htmlspecialchars($hasilSeleksi['status_pendaftaran']) ?>
                                </p>
                                <p><?= htmlspecialchars($hasilSeleksi['keterangan_seleksi']) ?></p>
                            <?php else: ?>
                                <p>Belum ada status pendaftaran.</p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </section>

        <!-- Bagian Tagihan -->
        <section class="billing-section">
            <h2>Tagihan</h2>
            <?php if (count($tagihanList) > 0): ?>
                <table class="billing-table">
                    <thead>
                        <tr><th>Bulan</th><th>Nominal</th><th>Jatuh Tempo</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tagihanList as $tagihan): ?>
                            <tr>
                                <td><?= htmlspecialchars($tagihan['bulan_tagihan']) ?></td>
                                <td><?= number_format($tagihan['nominal_tagihan'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($tagihan['tanggal_jatuh_tempo']) ?></td>
                                <td><?= htmlspecialchars($tagihan['status_tagihan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada tagihan aktif.</p>
            <?php endif; ?>
        </section>

        <!-- Riwayat Pendaftaran -->
        <section id="riwayat-pendaftaran-section" class="history-section">
            <h2>Riwayat Pendaftaran</h2>
            <?php if ($hasilSeleksi): ?>
                <table class="history-table">
                    <tr><th>Status</th><td><?= htmlspecialchars($hasilSeleksi['status_pendaftaran']) ?></td></tr>
                    <tr><th>Keterangan</th><td><?= htmlspecialchars($hasilSeleksi['keterangan_seleksi']) ?></td></tr>
                </table>
            <?php else: ?>
                <p>Belum ada riwayat pendaftaran.</p>
            <?php endif; ?>
        </section>

        <!-- Riwayat Pembayaran -->
        <section id="riwayat-pembayaran-section" class="payment-history">
            <h2>Riwayat Pembayaran</h2>
            <?php if (count($pembayaranList) > 0): ?>
                <table class="payment-table">
                    <thead>
                        <tr><th>Bulan</th><th>Tagihan</th><th>Tanggal Bayar</th><th>Dibayar</th><th>Metode</th><th>Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembayaranList as $pembayaran): ?>
                            <tr>
                                <td><?= htmlspecialchars($pembayaran['bulan_tagihan']) ?></td>
                                <td><?= number_format($pembayaran['nominal_tagihan'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($pembayaran['tanggal_pembayaran']) ?></td>
                                <td><?= number_format($pembayaran['nominal_dibayar'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($pembayaran['metode_pembayaran']) ?></td>
                                <td><?= htmlspecialchars($pembayaran['keterangan_pembayaran']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada riwayat pembayaran.</p>
            <?php endif; ?>
        </section>
    </main>

    <script>
        const menuBar = document.getElementById('menuBar');
        const hamburger = document.querySelector('.hamburger');

        function toggleMenu() {
            menuBar.classList.toggle('active');
        }

        document.querySelectorAll('#menuBar a').forEach(link => {
            link.addEventListener('click', () => menuBar.classList.remove('active'));
        });

        document.addEventListener('click', (event) => {
            if (!menuBar.contains(event.target) && !hamburger.contains(event.target)) {
                menuBar.classList.remove('active');
            }
        });
    </script>
</body>
</html>