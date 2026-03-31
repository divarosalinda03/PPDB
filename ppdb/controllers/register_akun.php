<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/WaliSiswa.php';

$pdo = Database::getConnection();
$waliSiswaModel = new WaliSiswa($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_wali = trim($_POST['nama_wali'] ?? '');
    $nik_wali = trim($_POST['nik_wali'] ?? '');
    $jenis_kelamin_wali = trim($_POST['jenis_kelamin_wali'] ?? '');
    $alamat_wali = trim($_POST['alamat_wali'] ?? '');
    $username_login = trim($_POST['username_login'] ?? '');
    $password_login = $_POST['password_login'] ?? '';

    if (empty($nama_wali) || empty($nik_wali) || empty($jenis_kelamin_wali) || empty($alamat_wali) || empty($username_login) || empty($password_login)) {
        header('Location: ../views/register_akun.php?error=Semua kolom harus diisi');
        exit();
    }

    // Cek apakah username sudah dipakai
    $existingUser = $waliSiswaModel->getByUsername($username_login);
    if ($existingUser) {
        // Username sudah ada
        header('Location: ../views/register_akun.php?error=Username sudah dipakai, silakan pilih yang lain');
        exit();
    }

    $data_wali = [
        'nama_wali' => $nama_wali,
        'nik_wali' => $nik_wali,
        'hubungan_wali' => null,
        'jenis_kelamin_wali' => $jenis_kelamin_wali,
        'alamat_wali' => $alamat_wali,
        'username_login' => $username_login,
        'password_login' => $password_login,
    ];

    $waliSiswaModel->register($data_wali);

    header('Location: ../views/login.php?akun_created=1');
    exit();
} else {
    header('Location: ../views/register_akun.php');
    exit();
}
?>
