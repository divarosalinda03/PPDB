<?php
require_once __DIR__ . '/../config/database.php';

class Tagihan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Insert tagihan baru
    public function insert($data)
    {
        // Ambil nominal dari rincian_biaya berdasarkan id_biaya
        $sqlNominal = "SELECT nominal_biaya FROM rincian_biaya WHERE id_biaya = :id_biaya";
        $stmtNominal = $this->pdo->prepare($sqlNominal);
        $stmtNominal->execute([':id_biaya' => $data['id_biaya']]);
        $nominal = $stmtNominal->fetchColumn();

        if ($nominal === false) {
            throw new Exception("Biaya dengan id {$data['id_biaya']} tidak ditemukan.");
        }

        $sql = "INSERT INTO tagihan (id_wali, bulan_tagihan, status_tagihan, nominal_tagihan, tanggal_jatuh_tempo)
                VALUES (:id_wali, :bulan_tagihan, :status_tagihan, :nominal_tagihan, :tanggal_jatuh_tempo)";
        $stmt = $this->pdo->prepare($sql);

        // FIX: tambahkan return agar hasil execute() (true/false) dikembalikan ke pemanggil
        return $stmt->execute([
            ':id_wali'             => $data['id_wali'],
            ':bulan_tagihan'       => $data['bulan_tagihan'],
            ':status_tagihan'      => $data['status_tagihan'] ?? 'Belum Lunas', // FIX: default value jika tidak dikirim dari form
            ':nominal_tagihan'     => $nominal, // pake nominal dari rincian_biaya
            ':tanggal_jatuh_tempo' => $data['tanggal_jatuh_tempo']
        ]);
    }

    // Ambil tagihan aktif untuk wali
    public function getByWaliId($id_wali)
    {
        $sql = "SELECT t.*, w.nama_wali
                FROM tagihan t
                JOIN wali_siswa w ON t.id_wali = w.id_wali
                WHERE t.id_wali = :id_wali AND t.status_tagihan != 'Lunas'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_wali' => $id_wali]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil semua tagihan (admin)
    public function getAll()
    {
        $sql = "SELECT t.*, w.nama_wali
                FROM tagihan t
                JOIN wali_siswa w ON t.id_wali = w.id_wali";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hapus tagihan
    public function delete($id_biaya)
    {
        $sql = "DELETE FROM tagihan WHERE id_biaya = :id_biaya";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_biaya' => $id_biaya]);
    }

    // Update status tagihan (umum)
    public function updateStatus($id_biaya, $status)
    {
        $sql = "UPDATE tagihan SET status_tagihan = :status_tagihan WHERE id_biaya = :id_biaya";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status_tagihan' => $status,
            ':id_biaya'       => $id_biaya
        ]);
    }

    // Ambil satu tagihan by id_biaya
    public function getById($id_biaya)
    {
        $sql = "SELECT * FROM tagihan WHERE id_biaya = :id_biaya";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_biaya' => $id_biaya]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Set tagihan menjadi LUNAS
    public function setLunas($id_biaya)
    {
        $this->updateStatus($id_biaya, 'Lunas');
    }
}
?>