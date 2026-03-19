<?php
session_start();
session_unset();
session_destroy();
header('location:index.php'); // Admin login page मा फिर्ता पठाउँछ
exit();
?>