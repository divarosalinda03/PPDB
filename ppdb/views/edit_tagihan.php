<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Tagihan.php';

session_start();

// Cek admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$tagihanModel = new Tagihan($pdo);
$tagihan = $tagihanModel->getById($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tagihan</title>
</head>
<body>
    <h2>Edit Tagihan</h2>
    <form action="../controllers/tagihan.php" method="post">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id_tagihan" value="<?= $tagihan['id_tagihan'] ?>">

        Nama Tagihan: <input type="text" name="nama_tagihan" value="<?= htmlspecialchars($tagihan['nama_tagihan']) ?>" required><br>
        Jumlah Tagihan: <input type="number" name="jumlah_tagihan" value="<?= htmlspecialchars($tagihan['jumlah_tagihan']) ?>" required><br>
        Tanggal Tagihan: <input type="date" name="tanggal_tagihan" value="<?= htmlspecialchars($tagihan['tanggal_tagihan']) ?>" required><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
