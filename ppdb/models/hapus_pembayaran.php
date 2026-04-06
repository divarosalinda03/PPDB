<?php
require_once __DIR__ . '/models/Pembayaran.php';
require_once __DIR__ . '/config/database.php';

$pembayaranModel = new Pembayaran($pdo);

$id_pembayaran = $_GET['id_pembayaran'];
$pembayaranModel->delete($id_pembayaran);

header("Location: dashboard_admin.php");
exit;
?>
