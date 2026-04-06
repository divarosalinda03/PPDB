<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/WaliSiswa.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/HasilSeleksi.php';

if (!isset($_SESSION['login_wali'])) {
    header('Location: ../views/login.php');
    exit();
}

$pdo = Database::getConnection();
$waliSiswaModel = new WaliSiswa($pdo);
$siswaModel = new Siswa($pdo);
$hasilSeleksiModel = new HasilSeleksi($pdo);

$id_wali = $_SESSION['id_wali'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi form
    $requiredFields = ['nama_siswa', 'nik_siswa', 'jenis_kelamin_siswa', 'umur_siswa', 'alamat_siswa'];
    foreach ($requiredFields as $field) {
        if (empty(trim($_POST[$field] ?? ''))) {
            header("Location: ../views/register.php?error=Field $field wajib diisi");
            exit();
        }
    }

    // Validasi file upload
    $requiredFiles = ['akta_kelahiran', 'kk', 'foto_siswa'];
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    foreach ($requiredFiles as $fileKey) {
        if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
            header("Location: ../views/register.php?error=File $fileKey wajib diupload.");
            exit();
        }
        if (!in_array($_FILES[$fileKey]['type'], $allowedTypes)) {
            header("Location: ../views/register.php?error=File $fileKey harus bertipe JPG, PNG, atau PDF.");
            exit();
        }
    }

    // Sanitize nama siswa
    $nama_siswa_clean = strtolower(preg_replace('/[^a-z0-9]/', '_', $_POST['nama_siswa']));

    // Tentukan ekstensi file
    $ext_foto = pathinfo($_FILES['foto_siswa']['name'], PATHINFO_EXTENSION);
    $ext_kk = pathinfo($_FILES['kk']['name'], PATHINFO_EXTENSION);
    $ext_akta = pathinfo($_FILES['akta_kelahiran']['name'], PATHINFO_EXTENSION);

    // Buat nama file
    $foto_file_name = $nama_siswa_clean . '.' . $ext_foto;
    $kk_file_name = $nama_siswa_clean . '.' . $ext_kk;
    $akta_file_name = $nama_siswa_clean . '.' . $ext_akta;

    // Path penyimpanan file
    $baseUpload = __DIR__ . '/../uploads/';
    $foto_path = $baseUpload . 'foto/' . $foto_file_name;
    $kk_path = $baseUpload . 'kk/' . $kk_file_name;
    $akta_path = $baseUpload . 'akta/' . $akta_file_name;

    // Buat folder jika belum ada
    foreach (['foto', 'kk', 'akta'] as $folder) {
        $folderPath = $baseUpload . $folder;
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
    }

    // Upload file
    if (!move_uploaded_file($_FILES['foto_siswa']['tmp_name'], $foto_path)) {
        echo "Error uploading foto.";
        exit();
    }
    if (!move_uploaded_file($_FILES['kk']['tmp_name'], $kk_path)) {
        echo "Error uploading KK.";
        exit();
    }
    if (!move_uploaded_file($_FILES['akta_kelahiran']['tmp_name'], $akta_path)) {
        echo "Error uploading Akta.";
        exit();
    }

    // Simpan ke database (hanya nama file saja)
    $data_siswa = [
        'id_wali' => $id_wali,
        'nama_siswa' => $_POST['nama_siswa'],
        'nik_siswa' => $_POST['nik_siswa'],
        'jenis_kelamin_siswa' => $_POST['jenis_kelamin_siswa'],
        'umur_siswa' => (int) $_POST['umur_siswa'],
        'alamat_siswa' => $_POST['alamat_siswa'],
        'foto_siswa' => $foto_file_name,
        'kk_siswa' => $kk_file_name,
        'akta_kelahiran_siswa' => $akta_file_name,
    ];

    $id_siswa = $siswaModel->register($data_siswa);

    // Seleksi otomatis
    $status = ($_POST['umur_siswa'] >= 4) ? 'Diterima' : 'Tidak Diterima';
    $keterangan = ($status === 'Diterima') ? 'Usia memenuhi syarat' : 'Umur tidak memenuhi syarat';

    $hasilSeleksiModel->insert([
        'id_siswa' => $id_siswa,
        'id_wali' => $id_wali,
        'status_pendaftaran' => $status,
        'keterangan_seleksi' => $keterangan,
    ]);

    header('Location: ../views/dashboard_wali.php?register_success=1');
    exit();
}
?>
