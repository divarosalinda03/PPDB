<?php
// controllers/walisiswa.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/HasilSeleksi.php';

session_start();
if (!isset($_SESSION['id_wali'])) {
    header('Location: login.php');
    exit();
}

$siswaModel = new Siswa($pdo);
$hasilSeleksiModel = new HasilSeleksi($pdo);

// Ambil data siswa & hasil seleksi
$id_wali = $_SESSION['id_wali'];
$siswa = $siswaModel->getByWaliId($id_wali);
$hasilSeleksi = $hasilSeleksiModel->getByWaliId($id_wali);
?>
