<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {

    $fname   = $_POST['fname'];
    $mobile  = $_POST['phone'];
    $email   = $_POST['email'];
    $role    = $_POST['role'];
    $password = md5($_POST['password']); // for learning purpose

    // Check duplicate email or mobile
    $check = mysqli_query($con,
        "SELECT ID FROM tblusers 
         WHERE Email='$email' OR MobileNumber='$mobile'"
    );

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email or Mobile already exists');</script>";
    } else {

        $query = mysqli_query($con,
            "INSERT INTO tblusers (FullName, MobileNumber, Email, Password, Role)
             VALUES ('$fname', '$mobile', '$email', '$password', '$role')"
        );

        if ($query) {
            echo "<script>alert('Registration Successful');</script>";
            echo "<script>window.location='login.php';</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
</head>
<body>

<div id="signup">

    <!-- Image Section -->
    <div class="img">
        <div class="logo">
            <h1>Beauty Parlour<br>Management System</h1>
        </div>
    </div>

    <!-- Form Section -->
    <div id="form-wrapper">
        <form method="POST">

            <h1 class="title">Sign Up</h1>

            <div class="input-field">
                <label>Full Name</label>
                <input type="text" name="fname" required>
            </div>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-field">
                <label>Phone Number</label>
                <input type="tel" name="phone" required>
            </div>

            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="role-based">
                <label>Role</label>
                <select name="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="btn-sign">
                <button type="submit" name="submit">Create Account</button>
            </div>

            <p class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </p>

        </form>
    </div>
</div>

</body>
</html>
