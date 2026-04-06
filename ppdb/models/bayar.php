<?php
require_once __DIR__ . '/models/Pembayaran.php';
require_once __DIR__ . '/models/Tagihan.php';
require_once __DIR__ . '/config/database.php';

$pembayaranModel = new Pembayaran($pdo);
$tagihanModel = new Tagihan($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_biaya' => $_POST['id_biaya'],
        'id_wali' => $_POST['id_wali'],
        'tanggal_pembayaran' => date('Y-m-d'),
        'nominal_dibayar' => $_POST['nominal_dibayar'],
        'status_pembayaran' => 'Lunas',
        'metode_pembayaran' => $_POST['metode_pembayaran'],
        'keterangan_pembayaran' => $_POST['keterangan_pembayaran']
    ];

    // Insert ke pembayaran
    $pembayaranModel->insert($data);

    // Update tagihan menjadi Lunas
    $tagihanModel->updateStatus($_POST['id_biaya'], 'Lunas');

    header("Location: dashboard_wali.php?id_wali=" . $_POST['id_wali']);
    exit;
}
?>
