<?php
session_start();

// Hapus semua session yang berkaitan dengan login wali
session_unset();
session_destroy();

// Redirect ke halaman login setelah logout
header('Location: ../views/login.php');
exit();
?>

