<?php
require_once __DIR__ . '/../config/database.php'; // Ensure this file returns the PDO instance

// Initialize the database connection
$pdo = Database::getConnection(); // Adjust this line according to how your DB connection is returned

require_once __DIR__ . '/../models/Pembayaran.php';
require_once __DIR__ . '/../models/Tagihan.php';

$pembayaranModel = new Pembayaran($pdo);
$tagihanModel = new Tagihan($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your existing logic
}
?>
