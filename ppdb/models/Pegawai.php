<?php
// models/Pegawai.php
require_once __DIR__ . '/../config/database.php';

class Pegawai
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Mendaftarkan pegawai baru ke database
     */
    public function register(array $data): int
        {
            $sql = "INSERT INTO pegawai (nama_pegawai, username_pegawai, password_pegawai, role_pegawai)
                    VALUES (:nama_pegawai, :username_pegawai, :password_pegawai, :role_pegawai)";

            $stmt = $this->pdo->prepare($sql);

            $hashed_password = password_hash($data['password_pegawai'], PASSWORD_DEFAULT);

            $stmt->bindParam(':nama_pegawai', $data['nama_pegawai']);
            $stmt->bindParam(':username_pegawai', $data['username_pegawai']);
            $stmt->bindParam(':password_pegawai', $hashed_password);
            $stmt->bindParam(':role_pegawai', $data['role_pegawai']);

            $stmt->execute();

            return (int) $this->pdo->lastInsertId();
        }

    /**
     * Mengambil data pegawai berdasarkan ID
     */
    public function getById(int $id_pegawai): ?array
    {
        $sql = "SELECT * FROM pegawai WHERE id_pegawai = :id_pegawai";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_pegawai' => $id_pegawai]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Mengambil data pegawai berdasarkan username
     */
    public function getByUsernamePegawai(string $username): ?array
    {
        $sql = "SELECT * FROM pegawai WHERE username_pegawai = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Mengambil semua data pegawai
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM pegawai";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update data pegawai (dengan atau tanpa password)
     */
    public function update(array $data): bool
    {
        if (!empty($data['password_pegawai'])) {
            // Update dengan password
            $sql = "UPDATE pegawai SET 
                        nama_pegawai = :nama_pegawai, 
                        username_pegawai = :username_pegawai, 
                        password_pegawai = :password_pegawai,
                        role_pegawai = :role_pegawai 
                    WHERE id_pegawai = :id_pegawai";

            $stmt = $this->pdo->prepare($sql);
            $hashed_password = password_hash($data['password_pegawai'], PASSWORD_DEFAULT);
            return $stmt->execute([
                ':nama_pegawai' => $data['nama_pegawai'],
                ':username_pegawai' => $data['username_pegawai'],
                ':password_pegawai' => $hashed_password,
                ':role_pegawai' => $data['role_pegawai'],
                ':id_pegawai' => $data['id_pegawai']
            ]);
        } else {
            // Update tanpa password
            $sql = "UPDATE pegawai SET 
                        nama_pegawai = :nama_pegawai, 
                        username_pegawai = :username_pegawai, 
                        role_pegawai = :role_pegawai 
                    WHERE id_pegawai = :id_pegawai";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':nama_pegawai' => $data['nama_pegawai'],
                ':username_pegawai' => $data['username_pegawai'],
                ':role_pegawai' => $data['role_pegawai'],
                ':id_pegawai' => $data['id_pegawai']
            ]);
        }
    }

    /**
     * Menghapus data pegawai berdasarkan ID
     */
    public function delete(int $id_pegawai): bool
    {
        $sql = "DELETE FROM pegawai WHERE id_pegawai = :id_pegawai";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_pegawai' => $id_pegawai]);
    }
}
