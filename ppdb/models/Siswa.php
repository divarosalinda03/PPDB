<?php
// models/Siswa.php
require_once __DIR__ . '/../config/database.php';

class Siswa
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Simpan data siswa ke database
    public function register(array $data): int {
        $sql = "INSERT INTO siswa 
            (id_wali, nama_siswa, nik_siswa, jenis_kelamin_siswa, umur_siswa, alamat_siswa, 
            foto_siswa, kk_siswa, akta_kelahiran_siswa)
            VALUES 
            (:id_wali, :nama_siswa, :nik_siswa, :jenis_kelamin_siswa, :umur_siswa, :alamat_siswa,
            :foto_siswa, :kk_siswa, :akta_kelahiran_siswa)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':id_wali', $data['id_wali']);
        $stmt->bindParam(':nama_siswa', $data['nama_siswa']);
        $stmt->bindParam(':nik_siswa', $data['nik_siswa']);
        $stmt->bindParam(':jenis_kelamin_siswa', $data['jenis_kelamin_siswa']);
        $stmt->bindParam(':umur_siswa', $data['umur_siswa'], PDO::PARAM_INT);
        $stmt->bindParam(':alamat_siswa', $data['alamat_siswa']);
        $stmt->bindParam(':foto_siswa', $data['foto_siswa']);
        $stmt->bindParam(':kk_siswa', $data['kk_siswa']);
        $stmt->bindParam(':akta_kelahiran_siswa', $data['akta_kelahiran_siswa']);
        
        $stmt->execute();

        return (int)$this->pdo->lastInsertId();
    }

    // Ambil data siswa berdasar id_siswa
    public function getById(int $id_siswa): ?array
    {
        $sql = "SELECT * FROM siswa WHERE id_siswa = :id_siswa";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_siswa' => $id_siswa]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Ambil data siswa pertama berdasar id_wali
    public function getByWaliId(int $id_wali): ?array
    {
        $sql = "SELECT * FROM siswa WHERE id_wali = :id_wali LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_wali' => $id_wali]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Ambil semua data siswa
    public function getAll(): array
    {
        $sql = "SELECT * FROM siswa";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil list data siswa berdasar id_wali
    public function getListByWaliId(int $id_wali): array
    {
        $sql = "SELECT * FROM siswa WHERE id_wali = :id_wali";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_wali' => $id_wali]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Memperbarui data siswa di database
    public function update(array $data): bool
    {
        $sql = "UPDATE siswa SET 
                id_wali = :id_wali, 
                nama_siswa = :nama_siswa, 
                nik_siswa = :nik_siswa, 
                jenis_kelamin_siswa = :jenis_kelamin_siswa, 
                umur_siswa = :umur_siswa, 
                alamat_siswa = :alamat_siswa, 
                foto_siswa = :foto_siswa, 
                kk_siswa = :kk_siswa, 
                akta_kelahiran_siswa = :akta_kelahiran_siswa 
                WHERE id_siswa = :id_siswa";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':id_wali', $data['id_wali']);
        $stmt->bindParam(':nama_siswa', $data['nama_siswa']);
        $stmt->bindParam(':nik_siswa', $data['nik_siswa']);
        $stmt->bindParam(':jenis_kelamin_siswa', $data['jenis_kelamin_siswa']);
        $stmt->bindParam(':umur_siswa', $data['umur_siswa'], PDO::PARAM_INT);
        $stmt->bindParam(':alamat_siswa', $data['alamat_siswa']);
        $stmt->bindParam(':foto_siswa', $data['foto_siswa']);
        $stmt->bindParam(':kk_siswa', $data['kk_siswa']);
        $stmt->bindParam(':akta_kelahiran_siswa', $data['akta_kelahiran_siswa']);
        $stmt->bindParam(':id_siswa', $data['id_siswa'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Menghapus data siswa dari database
    public function delete(int $id_siswa): bool
    {
        $sql = "DELETE FROM siswa WHERE id_siswa = :id_siswa";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_siswa', $id_siswa, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
