<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $newpassword = md5($_POST['newpassword']);

    // 1. First, find if the account exists and check its role
    $checkUser = mysqli_query($con, "SELECT role FROM tblusers WHERE email='$email' AND MobileNumber='$mobile'");
    
    if(mysqli_num_rows($checkUser) > 0) {
        $row = mysqli_fetch_array($checkUser);
        
        // 2. The logic you requested: If admin clicks the button, show this message
        if($row['role'] == 'admin') {
            echo "<script>alert('Access Denied! Administrators are not allowed to reset passwords using the client-side portal.');</script>";
        } else {
            // 3. If it is a regular user, proceed with the update
            $update = mysqli_query($con, "UPDATE tblusers SET password='$newpassword' WHERE email='$email' AND MobileNumber='$mobile' AND role='user'");
            
            if($update) {
                echo "<script>alert('Password updated successfully! Please login.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    } else {
        // Message if the email/mobile combination doesn't exist at all
        echo "<script>alert('No account found with these details. Please check your Email and Mobile Number.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .reset-box { background: #f6f3ec; padding: 40px; border-radius: 30px; box-shadow: 0 10px 20px #8f7463; width: 400px; }
        .btn-reset { background: #8f7463; color: white; width: 100%; padding: 12px; border: none; border-radius: 20px; cursor: pointer; font-weight: 700; margin-top: 15px; }
        .btn-reset:hover { background: #e86a8d; }
        .input-field { margin-bottom: 15px; }
        .input-field label { display: block; margin-bottom: 5px; color: #8f7463; font-weight: 600; }
        .input-field input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 10px; box-sizing: border-box; }
    </style>
</head>
<body style="background-color: #ede3d9; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Poppins', sans-serif;">
    <div class="reset-box">
        <h2 style="color: #e86a8d; text-align: center; margin-bottom: 20px;">Reset Password</h2>
        <form method="POST">
            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="Enter registered email">
            </div>
            <div class="input-field">
                <label>Mobile Number</label>
                <input type="text" name="mobile" required placeholder="Enter registered mobile">
            </div>
            <div class="input-field">
                <label>New Password</label>
                <input type="password" name="newpassword" required placeholder="Enter new password">
            </div>
            <button type="submit" name="submit" class="btn-reset">Update Password</button>
            <p style="text-align: center; margin-top: 15px;"><a href="login.php" style="color: #408de4; text-decoration: none;">Back to Login</a></p>
        </form>
    </div>
</body>
</html>