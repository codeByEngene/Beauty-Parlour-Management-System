<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include 'includes/dbconnection.php';

if(isset($_POST['submit']))
{
    $service_name = mysqli_real_escape_string($con, $_POST['service_name']);
    $service_desc = mysqli_real_escape_string($con, $_POST['service_desc']);
    $cost = $_POST['cost'];

    if($cost < 0) {
        echo "<script>alert('Error: You cannot enter a negative number for the price.');</script>";
    } elseif($cost == 0) {
        echo "<script>alert('Price cannot be zero.');</script>";
    } else {
        $check_service = mysqli_query($con, "SELECT service_name FROM services WHERE service_name = '$service_name'");
        
        if(mysqli_num_rows($check_service) > 0) {
            echo "<script>alert('This service name already exists. Please use a unique name.');</script>";
        } else {
            $image = $_FILES['service_image']['name'];
            $tmp = $_FILES['service_image']['tmp_name'];
            
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $new_img_name = md5($image . time()) . "." . $extension;

            if(move_uploaded_file($tmp, "images/".$new_img_name)) {
                $query = "INSERT INTO services(service_name, service_desc, cost, image) 
                          VALUES('$service_name', '$service_desc', '$cost', '$new_img_name')";

                $result = mysqli_query($con, $query);

                if($result) {
                    echo "<script>alert('Service added successfully'); window.location.href='manage-services.php';</script>";
                } else {
                    echo "<script>alert('Database Error: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Failed to upload image. Please check folder permissions.');</script>";
            }
        }
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
    <style>
        /* New style for the counter - keeping UI clean */
        .char-count {
            font-size: 12px;
            color: #666;
            text-align: right;
            margin-top: 5px;
            display: block;
        }
        .limit-reached {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main id="main-content" class="main-content">
        <div class="container">
            <h2 class="page-title">Add Services</h2>
            <div class="card-box">
                <form method="post" enctype="multipart/form-data" id="serviceForm">
                    <div class="form-group">
                        <label>Service Name</label>
                        <input type="text" name="service_name" class="form-control" placeholder="Enter Service Name" required>
                    </div>
                    <div class="form-group">
                        <label>Service Description</label>
                        <textarea name="service_desc" id="service_desc" class="form-control" rows="4" maxlength="300" placeholder="Enter Service Description" required oninput="updateCounter()"></textarea>
                        <span class="char-count" id="char_counter">0 / 300 characters</span>
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input type="number" name="cost" id="service_cost" class="form-control" min="1" placeholder="Enter Cost" required oninput="checkPrice()">
                    </div>
                    <div class="form-group">
                        <label>Service Image</label>
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
    
    <script>
    // Price Guard
    function checkPrice() {
        var costField = document.getElementById('service_cost');
        if (costField.value < 0) {
            alert('You cannot enter a negative number.');
            costField.value = "";
        }
    }

    // New Character Counter Logic
    function updateCounter() {
        var descField = document.getElementById('service_desc');
        var counter = document.getElementById('char_counter');
        var maxLength = descField.getAttribute("maxlength");
        var currentLength = descField.value.length;

        counter.innerHTML = currentLength + " / " + maxLength + " characters";

        // Turn red when 90% full
        if (currentLength >= (maxLength * 0.9)) {
            counter.classList.add("limit-reached");
        } else {
            counter.classList.remove("limit-reached");
        }
    }
    </script>
    <script src="js/script.js"></script>
</body>
</html>