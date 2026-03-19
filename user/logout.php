<?php
session_start();
session_unset();
session_destroy();
header('location:/parlour/Home/index.php'); 
exit();
?>