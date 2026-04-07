<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include('includes/dbconnection.php');

// 1. REAL-TIME AJAX VALIDATION (Background)

if (isset($_POST['check_email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    $checkQuery = mysqli_query($con, "SELECT id FROM tblusers WHERE email='$email' AND role='$role'");
    
    if (mysqli_num_rows($checkQuery) > 0) {
        echo "exists";
    } else {
        echo "not_found";
    }
    exit(); // Always exit after an AJAX response
}

// 2. MAIN LOGIN FORM SUBMISSION
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password']; 
    $selectedRole = mysqli_real_escape_string($con, $_POST['role']); 

    // --- Admin Authorization Guard ---
    if ($selectedRole == 'admin') {
        $allowedAdmins = ['admin1@gmail.com', 'admin2@gmail.com']; 
        if (!in_array($email, $allowedAdmins)) {
            echo "<script>alert('Access Denied! Your email is not authorized as an administrator.');</script>";
            echo "<script>window.location.href='login.php'</script>";
            exit();
        }
    }

    // --- Query Database ---
    $query = mysqli_query($con, "SELECT * FROM tblusers WHERE email='$email' AND role='$selectedRole'");
    $row = mysqli_fetch_array($query);

    // --- Password & Role Verification ---
    if ($row && md5($password) == $row['password']) {
        session_regenerate_id();

        $_SESSION['bpmsaid'] = $row['id']; 
        $_SESSION['uid'] = $row['id'];
        $_SESSION['role'] = $row['role']; 
        $_SESSION['fullname'] = $row['FullName'];

        // --- Redirection Logic ---
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
            exit();
        } 
        else if ($_SESSION['role'] === 'user') {
            // Check for redirect source (e.g., from the home page booking button)
            if (isset($_GET['redirect']) && $_GET['redirect'] == 'appointment') {
                header("Location: ../user/get-appointment.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
            exit();
        } 
        else {
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
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . (isset($_GET['redirect']) ? '?redirect='.$_GET['redirect'] : ''); ?>">
            <h2>Welcome Back</h2>
            <p>Please login to your account to continue</p>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required oninput="validateEmailFormat()" onblur="checkEmailRealTime()">
                
                <span id="format-warn" style="color: #e74c3c; font-size: 12px; display: none; margin-top: 5px;">
                    <i class="fa fa-envelope"></i> Please enter a valid email address (e.g., anjana@gmail.com).
                </span>
            
                <span id="email-warn" style="color: #e74c3c; font-size: 12px; display: none; margin-top: 5px;">
                    <i class="fa fa-exclamation-circle"></i> This email is not registered as a <span id="role-text">user</span>.
                </span>
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
 // Part 1: Check if the email looks like a real email address
function validateEmailFormat() {
    const email = document.getElementById('email').value;
    const formatWarn = document.getElementById('format-warn');
    const dbWarn = document.getElementById('email-warn');
    const loginBtn = document.querySelector('.btn-login');

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === "") {
        formatWarn.style.display = "none";
        return;
    }

    if (!emailPattern.test(email)) {
        formatWarn.style.display = "block";
        dbWarn.style.display = "none"; 
        loginBtn.disabled = true;
        loginBtn.style.opacity = "0.5";
    } else {
        formatWarn.style.display = "none";
        loginBtn.disabled = false;
        loginBtn.style.opacity = "1";
    }
}

// Part 2: Check if the email exists in your database
function checkEmailRealTime() {
    const email = document.getElementById('email').value;
    const role = document.getElementById('role').value;
    const dbWarn = document.getElementById('email-warn');
    const formatWarn = document.getElementById('format-warn');
    const roleText = document.getElementById('role-text');

    // Only check DB if the format is already correct
    if (email !== "" && formatWarn.style.display === "none") {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const response = this.responseText.trim();
                
                if (response === "not_found") {
                    roleText.innerText = role;
                    dbWarn.style.display = "block";
                } else {
                    dbWarn.style.display = "none";
                }
            }
        };
        xhr.send("check_email=1&email=" + email + "&role=" + role);
    }
}

document.getElementById('role').addEventListener('change', checkEmailRealTime);
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