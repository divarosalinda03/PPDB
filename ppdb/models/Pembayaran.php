<?php
require_once __DIR__ . '/../config/database.php';

class Pembayaran
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Insert pembayaran
    public function insert($data)
    {
        $sql = "INSERT INTO pembayaran (id_biaya, id_wali, tanggal_pembayaran, nominal_dibayar, status_pembayaran, metode_pembayaran, keterangan_pembayaran)
                VALUES (:id_biaya, :id_wali, :tanggal_pembayaran, :nominal_dibayar, :status_pembayaran, :metode_pembayaran, :keterangan_pembayaran)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_biaya' => $data['id_biaya'],
            ':id_wali' => $data['id_wali'],
            ':tanggal_pembayaran' => $data['tanggal_pembayaran'],
            ':nominal_dibayar' => $data['nominal_dibayar'],
            ':status_pembayaran' => $data['status_pembayaran'],
            ':metode_pembayaran' => $data['metode_pembayaran'],
            ':keterangan_pembayaran' => $data['keterangan_pembayaran']
        ]);
    }

    // Riwayat pembayaran Admin
    public function getAll()
    {
        $sql = "SELECT p.*, t.bulan_tagihan, t.nominal_tagihan, w.nama_wali
                FROM pembayaran p
                JOIN tagihan t ON p.id_biaya = t.id_biaya
                JOIN wali_siswa w ON p.id_wali = w.id_wali
                ORDER BY p.tanggal_pembayaran DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Riwayat pembayaran Wali
    public function getByWaliId($id_wali)
    {
        $sql = "SELECT p.*, t.bulan_tagihan, t.nominal_tagihan
                FROM pembayaran p
                JOIN tagihan t ON p.id_biaya = t.id_biaya
                WHERE p.id_wali = :id_wali
                ORDER BY p.tanggal_pembayaran DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_wali' => $id_wali]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hapus pembayaran
    public function delete($id_pembayaran)
    {
        $sql = "DELETE FROM pembayaran WHERE id_pembayaran = :id_pembayaran";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_pembayaran' => $id_pembayaran]);
    }

    // Ubah status pembayaran
    public function updateStatus($id_pembayaran, $status)
    {
        $sql = "UPDATE pembayaran SET status_pembayaran = :status_pembayaran WHERE id_pembayaran = :id_pembayaran";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status_pembayaran' => $status,
            ':id_pembayaran' => $id_pembayaran
        ]);
    }
    
}
?>
