<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password']; 
    $selectedRole = mysqli_real_escape_string($con, $_POST['role']); 

    if ($selectedRole == 'admin') {
        $allowedAdmins = ['admin1@gmail.com', 'admin2@gmail.com']; 
        if (!in_array($email, $allowedAdmins)) {
            echo "<script>alert('Access Denied! Your email is not authorized as an administrator.');</script>";
            echo "<script>window.location.href='login.php'</script>";
            exit();
        }
    }

    $query = mysqli_query($con, "SELECT * FROM tblusers WHERE email='$email' AND role='$selectedRole'");
    $row = mysqli_fetch_array($query);
    if ($row && md5($password) == $row['password']) {

        session_regenerate_id();

        $_SESSION['bpmsaid'] = $row['id']; 
        $_SESSION['uid'] = $row['id'];
        $_SESSION['role'] = $row['role']; 
        $_SESSION['fullname'] = $row['FullName'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
            exit();
        } else if ($_SESSION['role'] === 'user') {
            header("Location: ../user/dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid role assigned to this account.');</script>";
        }
    } else {
        echo "<script>alert('Invalid Details! Please check your credentials and selected role.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPMS | Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div id="login-container">
    <div class="side-img">
        <div class="logo">
            <h1>Beauty Parlour<br>Management System</h1>
        </div>
    </div>

    <div class="login-form-wrapper">
        <form method="POST" action="">
            <h2>Welcome Back</h2>
            <p>Please login to your account to continue</p>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <i class="fa fa-eye toggle-password" id="eyeIcon" onclick="togglePassword()"></i>
            </div>

            <div class="role-based">
                <label>Login As</label>
                <select name="role" id="role" required>
                    <option value="user">User</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div class="forgot-password-link">
                <a href="forgot-password.php">Forgot Password?</a>
            </div>

            <button type="submit" name="login" class="btn-login">Login Now</button>

            <div class="links">
                <a href="signup.php">New User? Register</a>
                <a href="../Home/index.php">Back to Home</a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
</script>

</body>
</html>