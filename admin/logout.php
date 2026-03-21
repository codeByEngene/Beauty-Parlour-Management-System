<?php
session_start();
unset($_SESSION['bpmsaid']);
unset($_SESSION['uid']);
unset($_SESSION['role']);
unset($_SESSION['fullname']);
session_unset();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
header('location:../Home/index.php'); 
exit();
?>