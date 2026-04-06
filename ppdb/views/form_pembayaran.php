<?php
require_once __DIR__ . '/../models/Pembayaran.php';
require_once __DIR__ . '/../models/Tagihan.php';
require_once __DIR__ . '/../config/database.php';

session_start();

// Pastikan pengguna sudah login dan dari sesi
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'wali') {
    header('Location: login.php');
    exit;
}

// Ambil id_wali dari session jika sesuai
$id_wali = $_SESSION['user']['id_wali']; // Sesuaikan dengan struktur session Anda
$pdo = Database::getConnection();
$tagihanModel = new Tagihan($pdo);
$pembayaranModel = new Pembayaran($pdo);

$tagihanList = $tagihanModel->getByWaliId($id_wali);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan sanitasi input
    $id_biaya = filter_input(INPUT_POST, 'id_biaya', FILTER_VALIDATE_INT);
    $nominal_dibayar = filter_input(INPUT_POST, 'nominal_dibayar', FILTER_VALIDATE_FLOAT);
    $metode_pembayaran = filter_input(INPUT_POST, 'metode_pembayaran', FILTER_SANITIZE_STRING);
    $keterangan_pembayaran = filter_input(INPUT_POST, 'keterangan_pembayaran', FILTER_SANITIZE_STRING);

    $errors = [];
    if ($id_biaya === false || !$metode_pembayaran) {
        $errors[] = "Data tidak lengkap atau tidak valid.";
    }
    if ($nominal_dibayar === false) {
        $errors[] = "Nominal pembayaran tidak valid.";
    }

    if (empty($errors)) {
        $data = [
            'id_biaya' => $id_biaya,
            'id_wali' => $id_wali,
            'tanggal_pembayaran' => date('Y-m-d'),
            'nominal_dibayar' => $nominal_dibayar,
            'status_pembayaran' => 'Lunas',
            'metode_pembayaran' => $metode_pembayaran,
            'keterangan_pembayaran' => $keterangan_pembayaran
        ];

        try {
            $pembayaranModel->insert($data);
            $_SESSION['pesan_sukses'] = "Pembayaran berhasil dilakukan.";
            header("Location: dashboard_wali.php");
            exit;
        } catch (Exception $e) {
            $errors[] = "Terjadi kesalahan: " . $e->getMessage();
        }
    } else {
        // Tampilkan error jika ada
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<h2>Form Pembayaran Tagihan</h2>
<form method="POST">
    <label>Pilih Tagihan:</label>
    <select name="id_biaya" required>
        <?php foreach ($tagihanList as $tagihan): ?>
            <?php if ($tagihan['status_tagihan'] !== 'Lunas'): ?>
                <option value="<?= htmlspecialchars($tagihan['id_biaya']) ?>">
                    <?= htmlspecialchars($tagihan['bulan_tagihan']) ?> - Rp <?= number_format($tagihan['nominal_tagihan'], 2, ',', '.') ?>
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Nominal Dibayar:</label>
    <input type="number" step="0.01" name="nominal_dibayar" required>
    <br><br>

    <label>Metode Pembayaran:</label>
    <input type="text" name="metode_pembayaran" placeholder="Contoh: Transfer, Tunai" required>
    <br><br>

    <label>Keterangan Pembayaran:</label>
    <textarea name="keterangan_pembayaran" placeholder="Opsional"></textarea>
    <br><br>

    <button type="submit">Bayar</button>
</form>