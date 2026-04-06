<?php
// views/form_tambah_tagihan.php
session_start();

// Cek login admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/WaliSiswa.php';

$pdo = Database::getConnection();

$waliModel = new WaliSiswa($pdo);
$waliList  = $waliModel->getAll();

$stmt      = $pdo->query("SELECT * FROM rincian_biaya ORDER BY nama_biaya ASC");
$biayaList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Tagihan</title>
</head>
<body>

<h2>Tambah Tagihan Baru</h2>

<?php if (isset($_SESSION['pesan_error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['pesan_error']) ?></p>
    <?php unset($_SESSION['pesan_error']); ?>
<?php endif; ?>

<!-- FIX: form diarahkan ke controller tagihan.php, bukan ke diri sendiri -->
<form method="POST" action="../controllers/tagihan.php">
    <!-- FIX: tambahkan hidden input action agar controller tahu ini aksi 'tambah' -->
    <input type="hidden" name="action" value="tambah">

    <label>Wali Siswa:</label>
    <select name="id_wali" required>
        <option value="">-- Pilih Wali --</option>
        <?php foreach ($waliList as $wali): ?>
            <option value="<?= $wali['id_wali'] ?>">
                <?= htmlspecialchars($wali['nama_wali']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Jenis Biaya:</label>
    <select name="id_biaya" id="id_biaya" required onchange="updateNominal()">
        <option value="">-- Pilih Biaya --</option>
        <?php foreach ($biayaList as $biaya): ?>
            <option value="<?= $biaya['id_biaya'] ?>"
                    data-nominal="<?= $biaya['nominal_biaya'] ?>"
                    data-tipe="<?= $biaya['tipe_biaya'] ?>">
                <?= htmlspecialchars($biaya['nama_biaya']) ?> (<?= $biaya['tipe_biaya'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Jumlah Tagihan:</label>
    <!-- readonly hanya untuk tampilan, nilai sebenarnya diambil dari rincian_biaya di model -->
    <input type="number" step="0.01" name="nominal_tagihan" id="nominal_tagihan" readonly>
    <br><br>

    <label>Bulan Tagihan:</label>
    <input type="month" name="bulan_tagihan" required>
    <br><br>

    <label>Tanggal Jatuh Tempo:</label>
    <input type="date" name="tanggal_jatuh_tempo" required>
    <br><br>

    <button type="submit">Simpan Tagihan</button>
    <a href="dashboard_admin.php">Batal</a>
</form>

<script>
function updateNominal() {
    const select       = document.getElementById('id_biaya');
    const nominalInput = document.getElementById('nominal_tagihan');
    const selected     = select.options[select.selectedIndex];
    nominalInput.value = selected.getAttribute('data-nominal') || '';
}
</script>

</body>
</html>