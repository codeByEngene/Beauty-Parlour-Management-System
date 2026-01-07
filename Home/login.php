<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $query = mysqli_query($con,
        "SELECT * FROM tblusers 
         WHERE Email='$email' AND Password='$password' AND Role='$role'"
    );

    if (mysqli_num_rows($query) == 1) {

        $row = mysqli_fetch_assoc($query);
        $_SESSION['uid'] = $row['id'];
        $_SESSION['fullname']=$row['FullName'];
        $_SESSION['role'] = $row['role'];

        if ($role == 'admin') {
          return  header("Location: parlour/Admin/dashboard.php");
        } 
        if($role=="user"){
            return header ("Location:/parlour/user/dashboard.php"); 
               } else {
        echo "<script>alert('Invalid login details');</script>";
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div id="login-container">

    <!-- Left Image Section -->
    <div class="side-img">
        <div class="logo">
            <h1>Beauty Parlour Management System</h1>
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-form-wrapper">
        <form method="POST" action="">
            <h2>Welcome Back</h2>
            <p>Please login to your account</p>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Email or Username" required>
            </div>

            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="role-based">
                <label>Select Role</label>
                <select name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <button type="submit" name="login" class="btn-login">Login</button>

            <div class="links">
                <a href="#">Forgot Password?</a>
                <a href="signup.php">Create New Account</a>
            </div>
        </form>
    </div>

</div>

</body>
</html>
