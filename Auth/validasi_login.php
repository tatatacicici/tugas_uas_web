<?php
/**
 * Validasi Login — Paws & Whiskers Care
 * Secure login with password_hash verification
 */
session_start();

include "../Database/config.php";
$db = new Database();

// Validasi input
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['email']) || empty($_POST['password'])) {
    header('Location: login.php');
    exit();
}

$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Ambil user berdasarkan email
$result = $db->getUserByEmail($email);

if (!empty($result)) {
    $user = $result[0];

    // Verifikasi password dengan hash
    if (password_verify($password, $user['password'])) {
        // Regenerate session ID untuk keamanan
        session_regenerate_id(true);

        $_SESSION['email'] = $user['email'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['roles'] = $user['roles'];

        if ($user['roles'] === 'admin') {
            header('Location: ../Admin/data_member.php');
        } else {
            header('Location: ../Profil/profil.php');
        }
        exit();
    }
}

// Login gagal
echo '<script>
    alert("Email atau kata sandi salah.");
    document.location = "login.php";
</script>';
exit();
?>
