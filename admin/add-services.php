<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include 'includes/dbconnection.php';

// --- AJAX CHECK LOGIC (Must stay at the very top) ---
if (isset($_POST['check_service_name'])) {
    $service_name = mysqli_real_escape_string($con, $_POST['check_service_name']);
    $query = mysqli_query($con, "SELECT service_name FROM services WHERE service_name = '$service_name'");
    if (mysqli_num_rows($query) > 0) {
        echo "exists";
    } else {
        echo "available";
    }
    exit(); 
}

// --- ORIGINAL FORM SUBMISSION LOGIC ---
if(isset($_POST['submit']))
{
    $service_name = mysqli_real_escape_string($con, $_POST['service_name']);
    $service_desc = mysqli_real_escape_string($con, $_POST['service_desc']);
    $cost = $_POST['cost'];

    if($cost <= 0) {
        echo "<script>alert('Error: Price must be a positive number greater than zero.');</script>";
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
        .status-msg{
            font-size: 12px;
            margin-top: 5px;
            display: block;
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
                        <input type="text" name="service_name" id="service_name" class="form-control" placeholder="Enter Service Name" required oninput="handleServiceName()">
                        <span id="availability-status" style="font-size:12px; margin-top:5px; display:block;"></span>
                    </div>
                    <div class="form-group">
                        <label>Service Description</label>
                        <textarea name="service_desc" id="service_desc" class="form-control" rows="4" maxlength="300" placeholder="Enter Service Description" required oninput="updateCounter()"></textarea>
                        <span class="char-count" id="char_counter">0 / 300 characters</span>
                    </div>
                    <div class="form-group">
                        <label>Cost (Rs.)</label>
                        <input type="number" name="cost" id="service_cost" class="form-control" min="1" step="0.01" placeholder="Enter Cost" required onkeydown="blockMinus(event)" oninput="validateCost()" onchange="validateCost()">

                        <span id="cost-status" class="status-msg"></span>
                    </div>
                    <div class="form-group">
                        <label>Service Image</label>
                        <input type="file" name="service_image" class="form-control" required>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" name="submit" class="btn-primary" id="submitBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script>
        const serviceDescription = {
            "Haircut": "Our expert barbers provide precision haircuts tailored to your style. Whether you prefer a classic cut or a modern look, we ensure you leave with confidence and satisfaction.",
            "Shaving": "Experience a traditional shaving service with our skilled barbers. We use high-quality products to give you a smooth and refreshing shave, leaving your skin feeling rejuvenated.",
            "Facial": "Indulge in our rejuvenating facial treatments designed to cleanse, exfoliate, and nourish your skin. Our facials are tailored to your skin type, leaving you with a radiant and refreshed complexion.",
            "Hair Coloring": "Transform your look with our professional hair coloring services. Whether you want a subtle change or a bold new color, our expert stylists will help you achieve the perfect shade that complements your style.",
            "Beard Trim": "Keep your beard looking sharp and well-groomed with our beard trimming service. Our barbers will shape and style your beard to enhance your facial features, giving you a polished and refined appearance.",
            "Hair Spa": "Relax and rejuvenate with our hair spa treatments. Our nourishing hair spa services help to restore moisture, improve scalp health, and leave your hair feeling soft, silky, and revitalized.",
            "Head Massage": "Experience ultimate relaxation with our head massage service. Our skilled therapists use soothing techniques to relieve tension, improve blood circulation, and promote overall well-being, leaving you feeling refreshed and revitalized.",
            "Hot Towel Shave": "Indulge in the luxury of a hot towel shave. Our barbers will wrap your face in warm towels to open up your pores, followed by a close and comfortable shave that leaves your skin feeling smooth and refreshed.",
            "Hair Styling": "Get the perfect look for any occasion with our hair styling services. Whether you want a sleek and polished style or a trendy and voluminous look, our expert stylists will create a hairstyle that suits your personality and enhances your features.",
            "Scalp Treatment": "Revitalize your scalp with our specialized scalp treatments. Our treatments are designed to address various scalp concerns, such as dandruff, dryness, and itchiness, promoting a healthy scalp environment for optimal hair growth.",
            "Makeup Application": "Enhance your natural beauty with our professional makeup application services. Whether you need a subtle everyday look or a bold statement for a special occasion, our skilled makeup artists will create a flawless finish that complements your features.",
            "Eyebrow Shaping": "Define and shape your eyebrows with our expert eyebrow shaping services. Our skilled technicians will analyze your facial features and create a customized eyebrow shape that enhances your natural beauty and frames your face perfectly.",
            "Massage Therapy": "Relax and unwind with our therapeutic massage services. Our skilled therapists use a variety of techniques to relieve muscle tension, reduce stress, and promote overall well-being, leaving you feeling rejuvenated and refreshed."
        };

        function handleServiceName(){
            checkAvailability(); 
            autoFillDescription();
        }

        function autoFillDescription(){
            var nameInput = document.getElementById('service_name').value.trim();
            var descArea = document.getElementById('service_desc');

            // Find matching key case-insensitively
            let match = Object.keys(serviceDescription).find(key => key.toLowerCase() === nameInput.toLowerCase());

            if(match) {
                descArea.value = serviceDescription[match];
                updateCounter();
            }
        }

        function checkAvailability() {
            var serviceName = document.getElementById('service_name').value;
            var statusSpan = document.getElementById('availability-status');
            var submitBtn = document.getElementById('submitBtn');

            if(serviceName.trim().length > 2) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'add-services.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if(xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        if(response === 'exists') {
                            statusSpan.innerHTML = '<i class="fa fa-times-circle"></i> Service name already taken.';
                            statusSpan.style.color = '#e74c3c';
                            submitBtn.disabled = true;
                        } else {
                            statusSpan.innerHTML = '<i class="fa fa-check-circle"></i> Service name available.';
                            statusSpan.style.color = '#27ae60';
                            submitBtn.disabled = false;
                        }
                    }
                };
                xhr.send('check_service_name=' + encodeURIComponent(serviceName));
            } else {
                statusSpan.innerHTML = '';
            }
        }


        function blockMinus(event) {
        // 189 is the minus key on top row, 109 is the minus key on numpad
            if (event.keyCode === 189 || event.keyCode === 109 || event.key === '-') {
                event.preventDefault(); 
                
                var costStatus = document.getElementById('cost-status');
                costStatus.innerHTML = '<i class="fa fa-times-circle"></i> Negative numbers are not allowed.';
                costStatus.style.color = '#e74c3c';

                alert("The minus sign (-) is blocked. Price must be a positive number.");
                return false;
            }
        }
        function validateCost() {
            var costField = document.getElementById('service_cost');
            var costStatus = document.getElementById('cost-status');
            var submitBtn = document.getElementById('submitBtn');
            var val = parseFloat(costField.value);

            if (costField.value !== '' && val < 1) {
                costField.value = ''; 
                costStatus.innerHTML = '<i class="fa fa-times-circle"></i> Price must be greater than zero.';
                costStatus.style.color = '#e74c3c';
                alert("The price cannot be negative or zero.");
                submitBtn.disabled = true;
            } else {
                costStatus.innerHTML = '';
                submitBtn.disabled = false;
            }
        }

        function updateCounter() {
            var descField = document.getElementById('service_desc');
            var counter = document.getElementById('char_counter');
            var maxLength = descField.getAttribute("maxlength");
            var currentLength = descField.value.length;

            counter.innerHTML = currentLength + " / " + maxLength + " characters";

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