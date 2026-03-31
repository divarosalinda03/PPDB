<?php
require_once __DIR__ . '/../config/database.php'; // Pastikan file ini ada dan benar untuk koneksi database

// Mendapatkan koneksi database
$pdo = Database::getConnection(); // Inisialisasi koneksi database

require_once __DIR__ . '/../models/Tagihan.php';
require_once __DIR__ . '/../models/WaliSiswa.php';

$waliModel = new WaliSiswa($pdo);
$waliList = $waliModel->getAll();

$stmt = $pdo->query("SELECT * FROM rincian_biaya ORDER BY nama_biaya ASC");
$biayaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tagihanModel = new Tagihan($pdo);

        $id_biaya = $_POST['id_biaya'];
        $id_wali = $_POST['id_wali'];
        $bulan_tagihan = $_POST['bulan_tagihan'];
        $nominal_tagihan = $_POST['nominal_tagihan'];
        $tanggal_jatuh_tempo = $_POST['tanggal_jatuh_tempo'];

        // Validasi input
        if (empty($id_biaya) || empty($id_wali) || empty($bulan_tagihan) || 
            empty($nominal_tagihan) || empty($tanggal_jatuh_tempo)) {
            throw new Exception('Semua kolom harus diisi.');
        }

        // Validasi apakah id_biaya ada
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rincian_biaya WHERE id_biaya = :id_biaya");
        $stmt->execute([':id_biaya' => $id_biaya]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception('ID biaya tidak valid.');
        }

        $data = [
            'id_wali' => $id_wali,
            'id_biaya' => $id_biaya,
            'bulan_tagihan' => $bulan_tagihan,
            'nominal_tagihan' => $nominal_tagihan,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo
        ];

        $inserted = $tagihanModel->insert($data);
        if (!$inserted) {
            throw new Exception('Gagal menyimpan data tagihan.');
        }

        echo "<script>
                alert('Data tagihan berhasil disimpan!');
                window.location.href = 'dashboard_admin.php';
              </script>";
    } catch (Exception $e) {
        echo "<script>
                alert('Error: {$e->getMessage()}');
                window.history.back();
              </script>";
    }
}
?>

<h2>Tambah Tagihan Baru</h2>
<form method="POST">
    <label>Wali Siswa:</label>
    <select name="id_wali" required>
        <option value="">-- Pilih Wali --</option>
        <?php foreach ($waliList as $wali): ?>
            <option value="<?= $wali['id_wali'] ?>"><?= htmlspecialchars($wali['nama_wali']) ?></option>
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
    <input type="number" step="0.01" name="nominal_tagihan" id="nominal_tagihan" readonly>
    <br><br>

    <label>Bulan Tagihan:</label>
    <input type="month" name="bulan_tagihan" required>
    <br><br>

    <label>Tanggal Jatuh Tempo:</label>
    <input type="date" name="tanggal_jatuh_tempo" required>
    <br><br>

    <button type="submit">Simpan Tagihan</button>
</form>

<script>
function updateNominal() {
    const select = document.getElementById('id_biaya');
    const nominalInput = document.getElementById('nominal_tagihan');
    const selected = select.options[select.selectedIndex];
    nominalInput.value = selected.getAttribute('data-nominal') || '';
}
</script>