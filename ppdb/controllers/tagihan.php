<?php
// controllers/tagihan.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Tagihan.php';
require_once __DIR__ . '/../models/WaliSiswa.php';

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

// Cek apakah role user adalah admin
if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: ../views/unauthorized.php');
    exit();
}

// Dapatkan koneksi database
$pdo = Database::getConnection();
$tagihanModel = new Tagihan($pdo);
$waliModel = new WaliSiswa($pdo);

// Tangani berbagai aksi
try {
    // Untuk aksi GET (seperti hapus)
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'hapus':
                if (isset($_GET['id'])) {
                    $tagihanModel->delete($_GET['id']);
                    $_SESSION['pesan_sukses'] = 'Tagihan berhasil dihapus';
                }
                break;
        }
    }
    // Untuk aksi POST (seperti tambah/edit)
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'tambah':
                $data = [
                    'id_wali'            => filter_input(INPUT_POST, 'id_wali', FILTER_VALIDATE_INT),
                    'id_biaya'           => filter_input(INPUT_POST, 'id_biaya', FILTER_VALIDATE_INT), // FIX: tambahkan id_biaya
                    'bulan_tagihan'      => htmlspecialchars($_POST['bulan_tagihan']),
                    'tanggal_jatuh_tempo'=> htmlspecialchars($_POST['tanggal_jatuh_tempo'])
                    // status_tagihan dan nominal_tagihan tidak perlu dikirim,
                    // sudah dihandle otomatis di model Tagihan
                ];

                // Validasi data
                if ($data['id_wali'] === false || $data['id_biaya'] === false) {
                    throw new Exception("Data tidak valid");
                }

                $tagihanModel->insert($data);
                $_SESSION['pesan_sukses'] = 'Tagihan berhasil ditambahkan';
                break;

            case 'edit':
                $data = [
                    'id_biaya'           => filter_input(INPUT_POST, 'id_biaya', FILTER_VALIDATE_INT),
                    'bulan_tagihan'      => htmlspecialchars($_POST['bulan_tagihan']),
                    'status_tagihan'     => htmlspecialchars($_POST['status_tagihan']),
                    'nominal_tagihan'    => filter_input(INPUT_POST, 'nominal_tagihan', FILTER_VALIDATE_FLOAT),
                    'tanggal_jatuh_tempo'=> htmlspecialchars($_POST['tanggal_jatuh_tempo'])
                ];

                if ($data['id_biaya'] === false || $data['nominal_tagihan'] === false) {
                    throw new Exception("Data tidak valid");
                }

                $tagihanModel->perbarui($data);
                $_SESSION['pesan_sukses'] = 'Tagihan berhasil diperbarui';
                break;
        }
    }
} catch (Exception $e) {
    $_SESSION['pesan_error'] = $e->getMessage();
}

// Redirect ke halaman admin
header('Location: ../views/dashboard_admin.php');
exit();