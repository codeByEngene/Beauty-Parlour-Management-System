<?php
session_start();
// Security: If they aren't logged in at all, send them to login
if(!isset($_SESSION['role'])){
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval | BPMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        body {
            background-color: #ede3d9;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            background: #f6f3ec;
            padding: 50px;
            border-radius: 30px;
            box-shadow: 15px 15px 15px #8f7463;
            text-align: center;
            max-width: 500px;
        }
        .icon {
            font-size: 60px;
            color: #e86a8d;
            margin-bottom: 20px;
        }
        h1 { color: #8f7463; font-size: 24px; }
        p { color: #666; line-height: 1.6; }
        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 30px;
            background-color: #8f7463;
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-back:hover { background-color: #e86a8d; }
    </style>
</head>
<body>

<div class="container">
    <div class="icon">
        <i class="fa fa-user-clock"></i>
    </div>
    <h1>Account Pending Approval</h1>
    <p>Hello <strong><?php echo $_SESSION['fullname']; ?></strong>,</p>
    <p>Your Admin account has been created successfully. However, for security reasons, a Super Admin must manually verify and approve your access before you can enter the dashboard.</p>
    <p>Please check back later or contact the system owner.</p>
    
    <a href="logout.php" class="btn-back">Logout & Exit</a>
</div>

</body>
</html>