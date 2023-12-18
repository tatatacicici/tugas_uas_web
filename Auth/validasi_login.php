<?php
    include "../Database/config.php";
    $db = new Database();

    $email = $_POST['email'];
    $password = $_POST['password'];

    foreach ($db->login($email, $password) as $result) {
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $pass = $result['password'];
        $roles = $result['roles'];
        if ($roles == 'admin')
            header('Location: ../Admin/data_member.php');
        else if ($roles == 'user')
            header('Location: ../Profil/profil.php');
        else {
            echo '<script>
                 alert("Password Salah");
                 document.location="login.php";
                </script>';
        }
}
?>
