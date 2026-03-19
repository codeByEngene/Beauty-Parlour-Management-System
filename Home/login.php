<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']); 
    $role = $_POST['role']; 

    $query = mysqli_query($con, "SELECT * FROM tblusers WHERE Email='$email' AND Password='$password' AND Role='$role'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        
        $_SESSION['bpmsaid'] = $row['id']; 
        $_SESSION['uid'] = $row['id'];
        $_SESSION['role'] = $row['Role'];
        $_SESSION['fullname'] = $row['FullName'];

        if (strtolower($row['role']) == 'admin') {
            echo "<script>window.location.href='/parlour/admin/dashboard.php'</script>";
            exit();
        } else if ($role == "user") {
            header("Location:/parlour/user/dashboard.php"); 
            exit();
        }
    } else {
        echo "<script>alert('Invalid Details!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BPMS | Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.error {
    color: red;
    font-size: 13px;
    margin-top: 5px;
}

.error-border {
    border: 1px solid red !important;
}
</style>

</head>

<body>

<div id="login-container">
    <div class="side-img">
        <div class="logo">
            <h1>Beauty Parlour Management System</h1>
            <p>Style that speaks for itself.</p>
        </div>
    </div>

    <div class="login-form-wrapper">
        <form method="POST" action="" id="loginForm">

            <h2>Welcome Back</h2>
            <p>Please login to your account to continue</p>

            <!-- EMAIL -->
            <div class="input-field">
                <label><i class="fa fa-envelope"></i> Email Address</label>
                <input type="text" name="email" id="email" placeholder="Enter your email">
                <small class="error" id="emailError"></small>
            </div>

            <!-- PASSWORD -->
            <div class="input-field">
                <label><i class="fa fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password">
                <small class="error" id="passwordError"></small>
            </div>

            <!-- ROLE -->
            <div class="role-based">
                <label><i class="fa fa-user-shield"></i> Select Role</label>
                <select name="role" id="role">
                    <option value="" disabled selected>Choose your role</option>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                </select>
                <small class="error" id="roleError"></small>
            </div>

            <button type="submit" name="login" class="btn-login">Login Now</button>

            <div class="links">
                <a href="signup.php">New User? Register here</a>
                <a href="index.php">Back to Home</a>
            </div>

        </form>
    </div>
</div>

<!-- ================= VALIDATION ONLY (NO PHP CHANGE) ================= -->
<script>

const email = document.getElementById("email");
const password = document.getElementById("password");
const role = document.getElementById("role");

const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");
const roleError = document.getElementById("roleError");

// EMAIL VALIDATION
email.addEventListener("input", function () {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email.value.trim() === "") {
        emailError.textContent = "Email is required";
        email.classList.add("error-border");
    } else if (!pattern.test(email.value)) {
        emailError.textContent = "Invalid email format";
        email.classList.add("error-border");
    } else {
        emailError.textContent = "";
        email.classList.remove("error-border");
    }
});

// PASSWORD VALIDATION
password.addEventListener("input", function () {
    if (password.value.trim() === "") {
        passwordError.textContent = "Password is required";
        password.classList.add("error-border");
    } else if (password.value.length < 6) {
        passwordError.textContent = "Minimum 6 characters required";
        password.classList.add("error-border");
    } else {
        passwordError.textContent = "";
        password.classList.remove("error-border");
    }
});

// ROLE VALIDATION
role.addEventListener("change", function () {
    if (role.value === "") {
        roleError.textContent = "Please select role";
        role.classList.add("error-border");
    } else {
        roleError.textContent = "";
        role.classList.remove("error-border");
    }
});

// FINAL CHECK BEFORE SUBMIT (extra safety only)
document.getElementById("loginForm").addEventListener("submit", function (e) {

    let valid = true;

    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!pattern.test(email.value)) {
        emailError.textContent = "Enter valid email";
        valid = false;
    }

    if (password.value.length < 6) {
        passwordError.textContent = "Password too short";
        valid = false;
    }

    if (role.value === "") {
        roleError.textContent = "Select role";
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});

</script>

</body>
</html>