<?php
require_once __DIR__ . '/models/Pembayaran.php';
require_once __DIR__ . '/config/database.php';

$pembayaranModel = new Pembayaran($pdo);

$id_pembayaran = $_GET['id_pembayaran'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status_pembayaran'];
    $pembayaranModel->updateStatus($id_pembayaran, $status);
    header("Location: dashboard_admin.php");
    exit;
}

// Get detail pembayaran
$sql = "SELECT * FROM pembayaran WHERE id_pembayaran = :id_pembayaran";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_pembayaran' => $id_pembayaran]);
$pembayaran = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2>Ubah Status Pembayaran</h2>
<form method="POST">
    <label>Status:</label>
    <select name="status_pembayaran">
        <option value="Pending" <?= $pembayaran['status_pembayaran'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Lunas" <?= $pembayaran['status_pembayaran'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
        <option value="Ditolak" <?= $pembayaran['status_pembayaran'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
    </select>
    <br><br>
    <button type="submit">Simpan</button>
</form>
