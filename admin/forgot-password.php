<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $newpassword = md5($_POST['newpassword']);

    $query = mysqli_query($con, "SELECT ID FROM tblusers WHERE Email='$email' AND MobileNumber='$mobile'");
    $ret = mysqli_fetch_array($query);

    if($ret > 0) {
        $query1 = mysqli_query($con, "UPDATE tblusers SET Password='$newpassword' WHERE Email='$email' AND MobileNumber='$mobile'");
        if($query1) {
            echo "<script>alert('Password successfully reset. You can now login.');</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
    } else {
        echo "<script>alert('Invalid Details. Please check your Email and Mobile Number.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password | BPMS</title>
    <link rel="stylesheet" href="login.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .reset-box { max-width: 450px; margin: 80px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
        .btn-reset { background: #6467c2; color: white; width: 100%; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-reset:hover { background: #e94e02; }
    </style>
</head>
<body>



<div class="reset-box">
    <h2 style="text-align:center; color:#6467c2;">Reset Password</h2>
    <p style="text-align:center; color:#777; font-size:14px; margin-bottom:20px;">Enter your registered email and mobile to reset.</p>
    
    <form method="post" onsubmit="return checkpass();" name="changepass">
        <div class="input-field" style="margin-bottom:15px;">
            <label><i class="fa fa-envelope"></i> Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required style="width:100%; padding:10px; border:1px solid #ddd;">
        </div>

        <div class="input-field" style="margin-bottom:15px;">
            <label><i class="fa fa-phone"></i> Registered Mobile</label>
            <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required style="width:100%; padding:10px; border:1px solid #ddd;">
        </div>

        <div class="input-field" style="margin-bottom:15px;">
            <label><i class="fa fa-key"></i> New Password</label>
            <input type="password" name="newpassword" id="newpass" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd;">
        </div>

        <div class="input-field" style="margin-bottom:20px;">
            <label><i class="fa fa-check-double"></i> Confirm Password</label>
            <input type="password" name="confirmpassword" id="confirmpass" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd;">
        </div>

        <button type="submit" name="submit" class="btn-reset">Reset My Password</button>
        
        <p style="text-align:center; margin-top:15px;">
            <a href="login.php" style="color:#6467c2; text-decoration:none;">Back to Login</a>
        </p>
    </form>
</div>

<script>
function checkpass() {
    if(document.changepass.newpassword.value != document.changepass.confirmpassword.value) {
        alert('Passwords do not match!');
        document.changepass.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>