<?php
    include "../Database/config.php";
    $db = new Database();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $db->login($email, $password);

    if (!empty($result)) {
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header('Location: ../Profil/profil.php');
        } else {
            echo '<script>
                 alert("Password Salah");
                 document.location="login.php";
                </script>';
        }
?>
