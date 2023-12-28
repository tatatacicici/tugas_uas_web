<?php
    include "../Database/config.php";
    $db = new Database();

    $email = $_POST['email'];
    $password = $_POST['password'];

$result = $db->login($email, $password);
if(!empty($result)){
    foreach ($result as $auth) {
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $roles = $auth['roles'];
        $pass = $auth['password'];
        if (($roles == 'admin') AND ($password == $pass)) {
            header('Location: ../Admin/data_member.php');
        }else if (($roles == 'user')  AND ($password == $pass)) {
            header('Location: ../Profil/profil.php');
        }
    }
}
else{
    echo '<script>
                 alert("Password Salah");
                 document.location="login.php";
                </script>';
}
?>
