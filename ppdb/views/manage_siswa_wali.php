<?php
session_start();
if (!isset($_SESSION['login_admin'])) {
    header('Location: ../views/login.php');
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/WaliSiswa.php';
require_once __DIR__ . '/../models/Siswa.php';

$pdo = Database::getConnection();
$waliModel = new WaliSiswa($pdo);
$siswaModel = new Siswa($pdo);

$action = $_GET['action'] ?? '';
$id_siswa = $_GET['id_siswa'] ?? null;
$id_wali = $_GET['id_wali'] ?? null;
$error = null;
$success = null;

// Inisialisasi variabel
$editSiswa = null;
$editWali = null;
$waliList = [];
$siswaList = [];

// Handle delete action
if ($action === 'delete' && $id_siswa) {
    try {
        $siswaModel->delete((int)$id_siswa);
        $success = "Data siswa berhasil dihapus.";
    } catch (Exception $e) {
        $error = "Gagal menghapus data siswa: " . $e->getMessage();
    }
}

if ($action === 'delete_wali' && $id_wali) {
    try {
        $waliModel->delete((int)$id_wali);
        $success = "Data wali siswa berhasil dihapus.";
    } catch (Exception $e) {
        $error = "Gagal menghapus data wali siswa: " . $e->getMessage();
    }
}

// Handle update siswa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_siswa'])) {
    $data = [
        'id_siswa' => $_POST['id_siswa'],
        'nama_siswa' => $_POST['nama_siswa'],
        'nik_siswa' => $_POST['nik_siswa'],
        'jenis_kelamin_siswa' => $_POST['jenis_kelamin_siswa'],
        'umur_siswa' => (int)$_POST['umur_siswa'],
        'alamat_siswa' => $_POST['alamat_siswa'],
    ];
    try {
        $siswaModel->update($data);
        $success = "Data siswa berhasil diperbarui.";
    } catch (Exception $e) {
        $error = "Gagal memperbarui data siswa: " . $e->getMessage();
    }
}

// Handle update wali
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_wali'])) {
    $data = [
        'id_wali' => $_POST['id_wali'],
        'nama_wali' => $_POST['nama_wali'],
        'nik_wali' => $_POST['nik_wali'],
        'hubungan_wali' => $_POST['hubungan_wali'],
        'alamat_wali' => $_POST['alamat_wali'],
    ];
    try {
        $waliModel->update($data);
        $success = "Data wali siswa berhasil diperbarui.";
    } catch (Exception $e) {
        $error = "Gagal memperbarui data wali siswa: " . $e->getMessage();
    }
}

// Get all data
$waliList = $waliModel->getAll();
$siswaList = $siswaModel->getAll();

// Get data for editing if id is set
if ($action === 'edit' && $id_siswa) {
    $editSiswa = $siswaModel->getById((int)$id_siswa);
}
if ($action === 'edit_wali' && $id_wali) {
    $editWali = $waliModel->getById((int)$id_wali);
}

// Include view and pass variables
include __DIR__ . '/../views/manage_siswa_wali.php';
