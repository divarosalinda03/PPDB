<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Pegawai.php'; // pastikan model Pegawai sudah ada dan benar

// Pastikan pengguna sudah login sebagai admin atau sesuai aturan
if (!isset($_SESSION['login_admin'])) {
    header('Location: ../views/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ['nama_pegawai', 'username_pegawai', 'password_pegawai', 'role_pegawai'];
    foreach ($requiredFields as $field) {
        if (empty(trim($_POST[$field] ?? ''))) {
            header('Location: ../views/form_tambah_pegawai.php?error=' . urlencode("Field $field wajib diisi"));
            exit();
        }
    }

    $pdo = Database::getConnection();
    $pegawaiModel = new Pegawai($pdo);

    // Cek username sudah digunakan atau belum
    $existingUser = $pegawaiModel->getByUsernamePegawai($_POST['username_pegawai']);
    if ($existingUser) {
        header('Location: ../views/form_tambah_pegawai.php?error=' . urlencode("Username sudah digunakan"));
        exit();
    }

    $data = [
        'nama_pegawai' => $_POST['nama_pegawai'],
        'username_pegawai' => $_POST['username_pegawai'],
        'password_pegawai' => $_POST['password_pegawai'], // password akan di-hash di model
        'role_pegawai' => $_POST['role_pegawai'],
    ];

    try {
        $pegawaiModel->register($data);
        header('Location: ../views/dashboard_admin.php?success=' . urlencode('Akun pegawai berhasil dibuat'));
        exit();
    } catch (Exception $e) {
        header('Location: ../views/form_tambah_pegawai.php?error=' . urlencode('Gagal membuat akun pegawai: ' . $e->getMessage()));
        exit();
    }
}
?>
