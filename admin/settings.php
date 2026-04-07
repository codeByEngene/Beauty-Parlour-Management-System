<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:../login.php');
    exit();
} else {
    if(isset($_POST['submit'])) {
        $adminid = $_SESSION['bpmsaid'];
        $cpass = md5($_POST['currentpassword']); 
        $newpass = md5($_POST['newpassword']);   

        $query = mysqli_query($con, "SELECT id FROM tblusers WHERE id='$adminid' AND password='$cpass'");
        $row = mysqli_fetch_array($query);

        if($row > 0) {
            $ret = mysqli_query($con, "UPDATE tblusers SET password='$newpass' WHERE id='$adminid'");
            if($ret) {
                echo "<script>alert('Password Changed Successfully!');</script>";
                echo "<script>window.location.href='settings.php'</script>";
            }
        } else {
            echo "<script>alert('Your Current Password is wrong!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Settings | BPMS Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="includes/header.css">
    <link rel="stylesheet" href="includes/sidebar.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; margin: 0; }

        /* --- Force Sidebar to stay open --- */
        .sidebar {
            left: 0 !important; /* Overrides the -280px in your CSS */
            display: block !important;
        }

        /* --- Shift the content to the right --- */
        .main-content { 
            padding: 40px; 
            margin-left: 280px; /* Matches your sidebar width */
            margin-top: 11vh;   /* Matches your header height */
            min-height: 89vh; 
            box-sizing: border-box;
        }

        /* --- Settings Card UI --- */
        .settings-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            max-width: 500px; 
            margin: 0 auto; 
        }
        .page-title { color: #6467c2; font-size: 28px; margin-bottom: 30px; text-align: center; }
        .form-group { margin-bottom: 25px; position: relative; }
        .form-group label { display: block; margin-bottom: 10px; font-weight: 600; color: #444; font-size: 14px; }
        .form-control { 
            width: 100%; padding: 12px 40px 12px 15px; 
            border: 2px solid #ddd; border-radius: 6px; 
            box-sizing: border-box; font-size: 15px; transition: 0.3s; 
        }
        .match { border-color: #2ecc71 !important; }
        .mismatch { border-color: #e74c3c !important; }
        .toggle-password { position: absolute; right: 15px; top: 42px; cursor: pointer; color: #aaa; z-index: 10; }
        .btn-save { 
            background: #e94e02; color: white; border: none; padding: 14px; 
            border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; 
            width: 100%; margin-top: 10px;
        }
        .error-text { color: #e74c3c; font-size: 12px; margin-top: 5px; display: none; }

        /* Responsive Fix for Mobile */
        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 20px; }
            .sidebar { left: -280px !important; } /* Hide on mobile unless toggled */
        }
    </style>
</head>
<body>

<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>

<main class="main-content">
    <div class="settings-card">
        <h2 class="page-title"><i class="fa fa-shield-alt"></i> Security Settings</h2>
        
        <form method="post" name="changepassword" onsubmit="return validateFinal();">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="currentpassword" id="current" class="form-control" required>
                <i class="fa fa-eye toggle-password" onclick="togglePass('current', this)"></i>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="newpassword" id="newpass" class="form-control" required onkeyup="checkMatch()">
                <i class="fa fa-eye toggle-password" onclick="togglePass('newpass', this)"></i>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirmpassword" id="confirmpass" class="form-control" required onkeyup="checkMatch()">
                <i class="fa fa-eye toggle-password" onclick="togglePass('confirmpass', this)"></i>
                <small id="msg" class="error-text">Passwords do not match!</small>
            </div>

            <button type="submit" name="submit" class="btn-save">Update Password</button>
        </form>
    </div>
</main>

<script src="js/script.js"></script>

<script>
// --- Handle Sidebar Submenus on Click ---
document.addEventListener('DOMContentLoaded', function() {
    const menus = document.querySelectorAll('.sidebar .menu > a');
    menus.forEach(menu => {
        menu.addEventListener('click', function(e) {
            const parent = this.parentElement;
            // Toggle the 'active' class which your CSS uses to show the submenu
            if (parent.classList.contains('active')) {
                parent.classList.remove('active');
            } else {
                // Close other open menus first (optional)
                document.querySelectorAll('.sidebar li.menu').forEach(m => m.classList.remove('active'));
                parent.classList.add('active');
            }
        });
    });
});

// --- Password Visibility Toggle ---
function togglePass(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

// --- Live Password Match Check ---
function checkMatch() {
    const p1 = document.getElementById('newpass');
    const p2 = document.getElementById('confirmpass');
    const msg = document.getElementById('msg');

    if (p2.value.length > 0) {
        if (p1.value === p2.value) {
            p2.classList.remove('mismatch');
            p2.classList.add('match');
            msg.style.display = "none";
        } else {
            p2.classList.remove('match');
            p2.classList.add('mismatch');
            msg.style.display = "block";
        }
    }
}

// --- Final Validation ---
function validateFinal() {
    const p1 = document.getElementById('newpass').value;
    const p2 = document.getElementById('confirmpass').value;
    if (p1 !== p2) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
<?php } ?>