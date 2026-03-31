<?php
// models/WaliSiswa.php
require_once __DIR__ . '/../config/database.php';

// models/WaliSiswa.php
class WaliSiswa
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // Register wali siswa baru
    public function register($data)
    {
        $sql = "INSERT INTO wali_siswa (nama_wali, nik_wali, hubungan_wali, jenis_kelamin_wali, alamat_wali, username_login, password_login)
                VALUES (:nama_wali, :nik_wali, :hubungan_wali, :jenis_kelamin_wali, :alamat_wali, :username_login, :password_login)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nama_wali' => $data['nama_wali'],
            ':nik_wali' => $data['nik_wali'],
            ':hubungan_wali' => $data['hubungan_wali'],
            ':jenis_kelamin_wali' => $data['jenis_kelamin_wali'],
            ':alamat_wali' => $data['alamat_wali'],
            ':username_login' => $data['username_login'],
            ':password_login' => password_hash($data['password_login'], PASSWORD_DEFAULT)
        ]);
        return $this->pdo->lastInsertId();
    }

    // Login wali siswa
    public function login($username, $password)
    {
        $sql = "SELECT * FROM wali_siswa WHERE username_login = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $wali = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($wali && password_verify($password, $wali['password_login'])) {
            return $wali;
        }
        return false;
    }

    public function getById($id_wali)
    {
        $sql = "SELECT * FROM wali_siswa WHERE id_wali = :id_wali";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_wali' => $id_wali]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLogin($id_wali, $username, $password)
    {
        $sql = "UPDATE wali_siswa SET username_login = :username, password_login = :password WHERE id_wali = :id_wali";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT), // Hash password
            ':id_wali' => $id_wali
        ]);
    }

    public function getByUsername($username)
    {
        $sql = "SELECT * FROM wali_siswa WHERE username_login = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM wali_siswa";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Memperbarui data wali siswa di database
    public function update(array $data): bool
    {
        $sql = "UPDATE wali_siswa SET 
                nama_wali = :nama_wali, 
                nik_wali = :nik_wali, 
                hubungan_wali = :hubungan_wali, 
                jenis_kelamin_wali = :jenis_kelamin_wali, 
                alamat_wali = :alamat_wali 
                WHERE id_wali = :id_wali";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':nama_wali', $data['nama_wali']);
        $stmt->bindParam(':nik_wali', $data['nik_wali']);
        $stmt->bindParam(':hubungan_wali', $data['hubungan_wali']);
        $stmt->bindParam(':jenis_kelamin_wali', $data['jenis_kelamin_wali']);
        $stmt->bindParam(':alamat_wali', $data['alamat_wali']);
        $stmt->bindParam(':id_wali', $data['id_wali'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Menghapus data wali siswa dari database
    public function delete(int $id_wali): bool
    {
        $sql = "DELETE FROM wali_siswa WHERE id_wali = :id_wali";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_wali', $id_wali, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
