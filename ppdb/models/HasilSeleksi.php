<?php
// models/HasilSeleksi.php
require_once __DIR__ . '/../config/database.php';

class HasilSeleksi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert($data)
    {
        $sql = "INSERT INTO hasil_seleksi (id_siswa, id_wali, status_pendaftaran, keterangan_seleksi)
                VALUES (:id_siswa, :id_wali, :status_pendaftaran, :keterangan_seleksi)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_siswa' => $data['id_siswa'],
            ':id_wali' => $data['id_wali'],
            ':status_pendaftaran' => $data['status_pendaftaran'],
            ':keterangan_seleksi' => $data['keterangan_seleksi']
        ]);
    }
    public function getByWaliId($id_wali)
{
    $sql = "SELECT * FROM hasil_seleksi WHERE id_wali = :id_wali";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id_wali' => $id_wali]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getBySiswaId($id_siswa)
    {
        $sql = "SELECT * FROM hasil_seleksi WHERE id_siswa = :id_siswa";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_siswa' => $id_siswa]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
