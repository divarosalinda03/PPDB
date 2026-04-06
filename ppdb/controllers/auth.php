<?php
// login.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/WaliSiswa.php';
require_once __DIR__ . '/../models/Pegawai.php';

$pdo = Database::getConnection();
$waliSiswaModel = new WaliSiswa($pdo);
$pegawaiModel = new Pegawai($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // 1. Cek login sebagai PEGAWAI terlebih dahulu
    $pegawai = $pegawaiModel->getByUsernamePegawai($username);
    if ($pegawai && password_verify($password, $pegawai['password_pegawai'])) {
        $_SESSION['login_pegawai'] = true;
        $_SESSION['user'] = [
            'id_pegawai' => $pegawai['id_pegawai'],
            'nama_pegawai' => $pegawai['nama_pegawai'],
            'role' => $pegawai['role_pegawai']
        ];
        header('Location: ../views/dashboard_admin.php');
        exit();
    }

    // 2. Jika bukan pegawai, cek sebagai WALI SISWA
    $wali = $waliSiswaModel->getByUsername($username);
    if ($wali && password_verify($password, $wali['password_login'])) {
        $_SESSION['login_wali'] = true;
        $_SESSION['id_wali'] = $wali['id_wali'];
        $_SESSION['nama_wali'] = $wali['nama_wali'];
        header('Location: ../views/dashboard_wali.php');
        exit();
    }

    // 3. Gagal login
    header('Location: ../views/login.php?login_error=1');
    exit();
} else {
    header('Location: ../views/login.php');
    exit();
}
