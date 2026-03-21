<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    // 1. Sanitize and Encrypt Input
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    // This creates a 32-character hash. 
    // If your DB has "12345" instead of "827ccb0eea8a706c4c34a16891f84e7b", it will fail.
    $password = md5($_POST['password']); 
    $selectedRole = mysqli_real_escape_string($con, $_POST['role']); 

    // 2. Find the user in the database
    $query = mysqli_query($con, "SELECT * FROM tblusers WHERE email='$email' AND password='$password' AND role='$selectedRole'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query); 
        $userEmail = $row['email'];

        // 3. THE 2-ADMIN RESTRICTION (Email Whitelist)
        if ($selectedRole == 'admin') {
            $allowedAdmins = ['fireio224327@gmail.com', 'shresthaanjana694@gmail.com']; 

            if (!in_array($userEmail, $allowedAdmins)) {
                echo "<script>alert('Access Denied! Only authorized administrators can login.');</script>";
                echo "<script>window.location.href='login.php'</script>";
                exit();
            }
        }

        // 4. Set Sessions
        $_SESSION['bpmsaid'] = $row['id']; 
        $_SESSION['uid'] = $row['id'];
        $_SESSION['role'] = $row['role']; 
        $_SESSION['fullname'] = $row['FullName'];

        // 5. Redirect based on role
        if ($row['role'] == 'admin') {
            echo "<script>window.location.href='../admin/dashboard.php'</script>";
            exit();
        } else {
            echo "<script>window.location.href='../user/dashboard.php'</script>";
            exit();
        }
    } else {
        // DEBUG TIP: If you are sure the password is correct, 
        // go to phpMyAdmin and manually change the password field to: 827ccb0eea8a706c4c34a16891f84e7b
        // That will reset your password to "12345" in MD5 format.
        echo "<script>alert('Invalid Details! Please check your credentials.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

            <div class="forgot-password-link">
                <a href="forgot-password.php">Forgot Password?</a>
            </div>

            <div class="role-based">
                <label>Select Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Choose your role</option>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                </select>
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