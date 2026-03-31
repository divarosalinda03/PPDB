<?php
require_once __DIR__ . '/../config/database.php';
// Dapatkan koneksi database
$pdo = Database::getConnection();
// Tambah data
if (isset($_POST['tambah'])) {
    $stmt = $pdo->prepare("INSERT INTO rincian_biaya (nama_biaya, tipe_biaya, nominal_biaya) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['nama_biaya'], $_POST['tipe_biaya'], $_POST['nominal_biaya']]);
    header("Location: rincian_biaya.php");
    exit;
}

// Update data
if (isset($_POST['edit'])) {
    $stmt = $pdo->prepare("UPDATE rincian_biaya SET nama_biaya = ?, tipe_biaya = ?, nominal_biaya = ? WHERE id_biaya = ?");
    $stmt->execute([$_POST['nama_biaya'], $_POST['tipe_biaya'], $_POST['nominal_biaya'], $_POST['id_biaya']]);
    header("Location: rincian_biaya.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM rincian_biaya WHERE id_biaya = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: rincian_biaya.php");
    exit;
}

// Ambil semua data
$stmt = $pdo->query("SELECT * FROM rincian_biaya ORDER BY id_biaya ASC");
$biayaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Jika mode edit
$editMode = false;
$editData = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $stmt = $pdo->prepare("SELECT * FROM rincian_biaya WHERE id_biaya = ?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<h2><?= $editMode ? 'Edit' : 'Tambah' ?> Rincian Biaya</h2>
<form method="POST">
    <input type="hidden" name="id_biaya" value="<?= $editData['id_biaya'] ?? '' ?>">
    
    <label>Nama Biaya:</label><br>
    <input type="text" name="nama_biaya" required value="<?= $editData['nama_biaya'] ?? '' ?>"><br><br>

    <label>Tipe Biaya:</label><br>
    <select name="tipe_biaya" required>
        <option value="">-- Pilih Tipe --</option>
        <option value="Sekali" <?= (isset($editData['tipe_biaya']) && $editData['tipe_biaya'] === 'Sekali') ? 'selected' : '' ?>>Sekali</option>
        <option value="Bulanan" <?= (isset($editData['tipe_biaya']) && $editData['tipe_biaya'] === 'Bulanan') ? 'selected' : '' ?>>Bulanan</option>
    </select><br><br>

    <label>Nominal:</label><br>
    <input type="number" name="nominal_biaya" required value="<?= $editData['nominal_biaya'] ?? '' ?>"><br><br>

    <button type="submit" name="<?= $editMode ? 'edit' : 'tambah' ?>">
        <?= $editMode ? 'Simpan Perubahan' : 'Tambah Data' ?>
    </button>
    <?php if ($editMode): ?>
        <a href="rincian_biaya.php">Batal</a>
    <?php endif; ?>
    <br><br>
    <a href="dashboard_admin.php">Kembali ke Dashboard</a>
</form>

<hr>

<h2>Daftar Rincian Biaya</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Biaya</th>
            <th>Tipe</th>
            <th>Nominal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($biayaList as $biaya): ?>
        <tr>
            <td><?= $biaya['id_biaya'] ?></td>
            <td><?= htmlspecialchars($biaya['nama_biaya']) ?></td>
            <td><?= $biaya['tipe_biaya'] ?></td>
            <td><?= number_format($biaya['nominal_biaya'], 0, ',', '.') ?></td>
            <td>
                <a href="rincian_biaya.php?edit=<?= $biaya['id_biaya'] ?>">Edit</a> |
                <a href="rincian_biaya.php?hapus=<?= $biaya['id_biaya'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
