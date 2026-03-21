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

    $query = mysqli_query($con, "UPDATE services SET service_name='$sername', service_desc='$serdesc', cost='$cost' WHERE id='$editid'");

    if ($query) {
        echo "<script>alert('Service has been updated.');</script>";
        echo "<script>window.location.href = 'manage-services.php'</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
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
        .main-content { padding: 40px; margin-left: 300px; background: #f4f7f6; min-height: 100vh; }
        .card-box { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 700px; margin: 0 auto; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #444; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-primary { background: #6467c2; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-primary:hover { background: #4e51a9; }
        .page-title { text-align: center; color: #333; margin-bottom: 30px; }
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
            $num = mysqli_num_rows($ret);
            if($num > 0) {
                while ($row = mysqli_fetch_array($ret)) {
            ?>
            <form method="post">
                <div class="form-group">
                    <label>Service Name</label>
                    <input type="text" name="sername" class="form-control" value="<?php echo $row['service_name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Service Description</label>
                    <textarea name="serdesc" class="form-control" rows="5" required><?php echo $row['service_desc']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Cost</label>
                    <input type="number" name="cost" class="form-control" value="<?php echo $row['cost']; ?>" required>
                </div>

                <div class="action-buttons">
                    <button type="submit" name="submit" class="btn-primary">Update Service</button>
                    <a href="manage-services.php" style="margin-left:15px; color: #e94e02; text-decoration: none; font-weight: bold;">Cancel</a>
                </div>
            </form>
            <?php 
                } 
            } else {
                echo "<p style='color:red; text-align:center;'>Service not found.</p>";
            }
            ?>
        </div>
    </div>
</main>

</body>
</html>