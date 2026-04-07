<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (!isset($_SESSION['bpmsaid']) || strlen($_SESSION['bpmsaid']) == 0) {
    header('location:../Home/index.php');
    exit();
} else {
    $adminid = $_SESSION['bpmsaid'];

    // --- 1. HANDLE IMAGE REMOVAL ---
    if(isset($_POST['remove_img'])) {
        $res = mysqli_query($con, "SELECT Image FROM tblusers WHERE id='$adminid'");
        $row = mysqli_fetch_array($res);
        $oldimage = $row['Image'];
        
        if(!empty($oldimage)) {
            $path = "images/".$oldimage;
            if(file_exists($path)) { unlink($path); } 
        }
        
        $query = mysqli_query($con, "UPDATE tblusers SET Image='' WHERE id='$adminid'");
        if($query) {
            echo "<script>alert('Profile photo removed.'); window.location.href='admin-profile.php';</script>";
        }
    }

    // --- 2. HANDLE PROFILE & IMAGE UPDATE ---
    if(isset($_POST['submit'])) {
        $aname = mysqli_real_escape_string($con, $_POST['adminname']);
        $mobno = mysqli_real_escape_string($con, $_POST['mobilenumber']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        
        $imgfile = $_FILES["profilepic"]["name"];
        if(!empty($imgfile)) {
            $extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            
            if(!in_array($extension, $allowed_extensions)) {
                echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif allowed');</script>";
            } else {
                $newimgfile = md5($imgfile . time()) . "." . $extension;
                move_uploaded_file($_FILES["profilepic"]["tmp_name"], "images/" . $newimgfile);
                $query = mysqli_query($con, "UPDATE tblusers SET FullName='$aname', MobileNumber='$mobno', email='$email', Image='$newimgfile' WHERE id='$adminid'");
            }
        } else {
            $query = mysqli_query($con, "UPDATE tblusers SET FullName='$aname', MobileNumber='$mobno', email='$email' WHERE id='$adminid'");
        }

        if ($query) {
            $_SESSION['fullname'] = $aname;
            echo "<script>alert('Profile updated successfully.'); window.location.href='admin-profile.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile | BPMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="includes/header.css">
    <link rel="stylesheet" href="includes/sidebar.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; margin: 0; }
        
        /* --- CONSTANT SIDEBAR FIX --- */
        .sidebar {
            left: 0 !important;
            display: block !important;
            position: fixed !important;
        }

        .main-content { 
            padding: 40px; 
            margin-left: 280px; /* Matches Sidebar Width */
            margin-top: 11vh;   /* Matches Header Height */
            min-height: 89vh; 
            box-sizing: border-box;
        }

        /* --- PROFILE CARD STYLING --- */
        .profile-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            max-width: 650px; 
            margin: 0 auto; 
        }
        
        .avatar-container { position: relative; width: 120px; height: 120px; margin: 0 auto 30px; }
        .profile-avatar { 
            width: 120px; height: 120px; border-radius: 50%; object-fit: cover;
            background: linear-gradient(135deg, #6467c2, #4834d4);
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 50px; font-weight: bold; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .upload-btn-wrapper { position: absolute; bottom: 0; right: 0; }
        .cam-icon { background: #e94e02; color: white; padding: 10px; border-radius: 50%; cursor: pointer; font-size: 14px; border: 2px solid #fff; display: block; }
        .remove-img-btn { 
            position: absolute; top: 0; right: 0; background: #ff4d4d; color: white; 
            border: 2px solid #fff; border-radius: 50%; width: 30px; height: 30px; 
            cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px;
        }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full-width { grid-column: span 2; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 13px; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-update { background: #e94e02; color: white; border: none; padding: 15px; border-radius: 8px; width: 100%; cursor: pointer; font-weight: bold; margin-top: 20px; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 20px; }
            .sidebar { left: -280px !important; }
        }
    </style>
</head>
<body>

<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>

<main class="main-content">
    <div class="profile-card">
        <?php
        $ret = mysqli_query($con, "SELECT * FROM tblusers WHERE id='$adminid'");
        while ($row = mysqli_fetch_array($ret)) {
            $initial = strtoupper(substr($row['FullName'], 0, 1));
            $userImg = $row['Image'];
        ?>
        
        <form id="removePhotoForm" method="post" style="display:none;">
            <input type="hidden" name="remove_img" value="1">
        </form>

        <form method="post" enctype="multipart/form-data">
            <div class="avatar-container">
                <?php if(empty($userImg)): ?>
                    <div class="profile-avatar"><?php echo $initial; ?></div>
                <?php else: ?>
                    <img src="images/<?php echo $userImg; ?>" class="profile-avatar">
                    <button type="button" class="remove-img-btn" title="Remove Photo" onclick="if(confirm('Remove profile photo?')) document.getElementById('removePhotoForm').submit();">
                        <i class="fa fa-times"></i>
                    </button>
                <?php endif; ?>
                
                <div class="upload-btn-wrapper">
                    <label class="cam-icon" title="Change Photo">
                        <i class="fa fa-camera"></i>
                        <input type="file" name="profilepic" accept="image/*" style="display:none;" onchange="this.form.submit();">
                    </label>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="adminname" value="<?php echo $row['FullName'];?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>" required>
                </div>
                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control" name="mobilenumber" value="<?php echo $row['MobileNumber'];?>" required maxlength="10">
                </div>
            </div>

            <button type="submit" name="submit" class="btn-update">Update Profile Information</button>
        </form>
        <?php } ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>

<script>
// Logic to handle sidebar submenu clicks
document.addEventListener('DOMContentLoaded', function() {
    const menus = document.querySelectorAll('.sidebar .menu > a');
    menus.forEach(menu => {
        menu.addEventListener('click', function(e) {
            const parent = this.parentElement;
            if (parent.classList.contains('active')) {
                parent.classList.remove('active');
            } else {
                document.querySelectorAll('.sidebar li.menu').forEach(m => m.classList.remove('active'));
                parent.classList.add('active');
            }
        });
    });
});
</script>
</body>
</html>
<?php } ?>