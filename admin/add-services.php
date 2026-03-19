<?php
include 'includes/dbconnection.php';

if(isset($_POST['submit']))
{
    // Corrected function names below
    $service_name = mysqli_real_escape_string($con, $_POST['service_name']);
    $service_desc = mysqli_real_escape_string($con, $_POST['service_desc']);
    $cost = $_POST['cost'];

    // Handle Image Upload
    $image = $_FILES['service_image']['name'];
    $tmp = $_FILES['service_image']['tmp_name'];
    
    // It is safer to give the image a unique name to avoid overwriting files
    $extension = pathinfo($image, PATHINFO_EXTENSION);
    $new_img_name = md5($image . time()) . "." . $extension;

    if(move_uploaded_file($tmp, "images/".$new_img_name)) {
        // Use $new_img_name in the query
        $query = "INSERT INTO services(service_name, service_desc, cost, image) 
                  VALUES('$service_name', '$service_desc', '$cost', '$new_img_name')";

        $result = mysqli_query($con, $query);

        if($result) {
            echo "<script>alert('Service added successfully'); window.location.href='manage-services.php';</script>";
        } else {
            echo "<script>alert('Database Error: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload image. Check if the images folder exists.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>BPMS Admin Panel - Add Service</title>
    <link rel="stylesheet" href="css/add-services.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="includes/sidebar.css">
    <link rel="stylesheet" href="includes/footer.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="container">
            <h2 class="page-title">Add Services</h2>
            <div class="card-box">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Service Name</label>
                        <input type="text" name="service_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Service Description</label>
                        <textarea name="service_desc" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input type="number" name="cost" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <input type="file" name="service_image" class="form-control" required>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" name="submit" class="btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>