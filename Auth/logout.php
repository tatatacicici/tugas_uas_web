<?php
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login (gantilah login.php dengan halaman login yang sesuai)
header("Location: ../index.html");
exit();
?>
