<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Siswa.php';

$pdo = Database::getConnection();
$siswaModel = new Siswa($pdo);

$id_siswa = intval($_GET['id'] ?? 0);
$type = $_GET['type'] ?? '';

$siswa = $siswaModel->getById($id_siswa);
if (!$siswa) {
    http_response_code(404);
    exit('File tidak ditemukan');
}

switch ($type) {
    case 'foto':
        header('Content-Type: ' . $siswa['foto_mime']);
        echo $siswa['foto_siswa'];
        break;
    case 'kk':
        header('Content-Type: ' . $siswa['kk_mime']);
        echo $siswa['kk_siswa'];
        break;
    case 'akta':
        header('Content-Type: ' . $siswa['akta_kelahiran_mime']);
        echo $siswa['akta_kelahiran_siswa'];
        break;
    default:
        http_response_code(400);
        exit('Tipe file tidak valid');
}
