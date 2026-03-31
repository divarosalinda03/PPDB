<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../views/login.php');
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Pegawai.php';

$pdo = Database::getConnection();
$pegawaiModel = new Pegawai($pdo);

// Ambil input dari form
$data = [
    'nama_pegawai' => $_POST['nama_pegawai'] ?? '',
    'username_pegawai' => $_POST['username_pegawai'] ?? '',
    'password_pegawai' => $_POST['password_pegawai'] ?? '',
    'role_pegawai' => $_POST['role_pegawai'] ?? '',
];

// Validasi input sederhana
if (in_array('', $data, true)) {
    header('Location: ../views/tambah_pegawai.php?error=Semua kolom wajib diisi');
    exit();
}

// Cek apakah username sudah digunakan
if ($pegawaiModel->getByUsernamePegawai($data['username_pegawai'])) {
    header('Location: ../views/tambah_pegawai.php?error=Username sudah digunakan');
    exit();
}

// Simpan data (password otomatis di-hash di model)
try {
    $pegawaiModel->register($data);
    header('Location: ../views/tambah_pegawai.php?success=1');
} catch (Exception $e) {
    header('Location: ../views/tambah_pegawai.php?error=Gagal menyimpan data');
}
exit();
