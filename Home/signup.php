<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle database connection path
if(file_exists('includes/dbconnection.php')){
    include('includes/dbconnection.php');
} else {
    include('include/dbconnection.php'); 
}

if (isset($_POST['submit'])) {
    $fname    = mysqli_real_escape_string($con, $_POST['fullname']); 
    $mobile   = mysqli_real_escape_string($con, $_POST['mobilenumber']); 
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $role     = "user"; 
    $status   = "active";

    // Server-side validation
    if(strlen($fname) < 2) {
        echo "<script>alert('Name must be at least 2 characters');</script>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email Format');</script>";
    } elseif(!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo "<script>alert('Phone number must be exactly 10 digits');</script>";
    } elseif(strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');</script>";
    } else {
        $hashed_password = md5($password);
        $check = mysqli_query($con, "SELECT id FROM tblusers WHERE email='$email' OR MobileNumber='$mobile'");

        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('Email or Mobile already exists');</script>";
        } else {
            $query = mysqli_query($con, "INSERT INTO tblusers (FullName, MobileNumber, email, password, role, status) 
                                         VALUES ('$fname', '$mobile', '$email', '$hashed_password', '$role', '$status')");
            if ($query) {
                echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
            } else {
                echo "<script>alert('Error. Please try again.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | BPMS</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error { color: #e74c3c; font-size: 12px; margin-top: 3px; display: block; font-weight: bold;}
    </style>
</head>
<body>
<div id="signup">
    <div class="img">
        <div class="logo">
            <h1>Beauty Parlour<br>Management System</h1>
        </div>
    </div>
    <div id="form-wrapper">
        <form method="POST" id="signupForm" onsubmit="return validateForm()">
            <h1 class="title">Sign Up</h1>
            
            <div class="input-field">
                <label>Full Name</label>
                <input type="text" name="fullname" id="fullname" placeholder="Anjana Shrestha" required 
                       onkeypress="return restrictToLetters(event)" onkeyup="validateName()">
                <small id="nameError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="eg. anjana@gmail.com" required onkeyup="validateEmail()">
                <small id="emailError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Phone Number</label>
                <input type="tel" name="mobilenumber" id="mobilenumber" placeholder="Enter 10 digits" required 
                       onkeypress="return restrictToNumbers(event)" onkeyup="validatePhone()">    
                <small id="phoneError" class="error"></small>
            </div>

            <div class="input-field" style="position: relative;">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required onkeyup="validatePass()">
                <i class="fa fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 38px; cursor: pointer;"></i>
                <small id="passError" class="error"></small>
            </div>

            <div class="btn-sign">
                <button type="submit" name="submit">Create Account</button>
            </div>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>

<script src="js/validation.js"></script>
</body>
</html>