<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (!isset($_SESSION['bpmsaid']) || strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php'); 
    exit();
}

if (isset($_GET['editid']) && !empty($_GET['editid'])) {
    $editid = mysqli_real_escape_string($con, $_GET['editid']);
} else {
    header('location:manage-services.php');
    exit();
}

if (isset($_POST['submit'])) {
    $sername = mysqli_real_escape_string($con, $_POST['sername']);
    $serdesc = mysqli_real_escape_string($con, $_POST['serdesc']);
    $cost = mysqli_real_escape_string($con, $_POST['cost']);
    
    // Image Upload Logic
    $image = $_FILES["serviceimage"]["name"];
    
    if(!empty($image)) {
        // If a new image is uploaded
        $extension = substr($image, strlen($image)-4, strlen($image));
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
        
        if(!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            // Rename image to prevent overwriting
            $newimage = md5($image.time()).$extension;
            move_uploaded_file($_FILES["serviceimage"]["tmp_name"], "images/".$newimage);
            
            $query = mysqli_query($con, "UPDATE services SET service_name='$sername', service_desc='$serdesc', cost='$cost', image='$newimage' WHERE id='$editid'");
        }
    } else {
        // If no new image is selected, keep the old one
        $query = mysqli_query($con, "UPDATE services SET service_name='$sername', service_desc='$serdesc', cost='$cost' WHERE id='$editid'");
    }

    if ($query) {
        echo "<script>alert('Service has been updated successfully.');</script>";
        echo "<script>window.location.href = 'manage-services.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Service | BPMS Admin</title>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; box-sizing: border-box; }
        .main-content { padding: 40px; margin-left: 250px; background: #f4f7f6; min-height: 100vh; width: calc(100% - 250px); box-sizing: border-box; }
        .main-content .container { max-width: 800px; margin: 0 auto; }
        .card-box { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #444; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-primary { background: #6467c2; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .page-title { text-align: center; color: #333; margin-bottom: 30px; }
        .current-img { width: 150px; border-radius: 5px; margin-bottom: 10px; display: block; border: 1px solid #ddd; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <div class="container">
        <h2 class="page-title">Update Service Details</h2>
        <div class="card-box">
            <?php
            $ret = mysqli_query($con, "SELECT * FROM services WHERE id='$editid'");
            while ($row = mysqli_fetch_array($ret)) {
            ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Service Name</label>
                    <input type="text" name="sername" class="form-control" value="<?php echo $row['service_name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Service Description</label>
                    <textarea name="serdesc" class="form-control" rows="4" required><?php echo $row['service_desc']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Cost</label>
                    <input type="number" name="cost" class="form-control" value="<?php echo $row['cost']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Current Service Image</label>
                    <img src="images/<?php echo $row['image']; ?>" class="current-img" alt="Service Image">
                    <label>Upload New Image (Leave blank to keep current)</label>
                    <input type="file" name="serviceimage" class="form-control">
                </div>

                <div class="action-buttons">
                    <button type="submit" name="submit" class="btn-primary">Update Service</button>
                    <a href="manage-services.php" style="margin-left:15px; color: #e94e02; text-decoration: none; font-weight: bold;">Cancel</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>