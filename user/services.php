<?php include('../admin/includes/dbconnection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Services</title>
    <link rel="stylesheet" href="style22.css">
    <link rel="stylesheet" href="include/header.css">
    <link rel="stylesheet" href="include/footer.css">
</head>
<body>
    <?php include('include/header.php');?>
    
    <main class="service-grid">
    <?php
    $query = mysqli_query($con, "SELECT * FROM services");
    while ($row = mysqli_fetch_array($query)) {
    ?>
    <div class="service-card">
        <img src="../admin/images/<?php echo $row['image']; ?>" alt="Service Image">
        <h2><?php echo $row['service_name']; ?></h2>
        <p><?php echo $row['service_desc']; ?></p>
        <p class="price">Cost of Service: Rs.<?php echo $row['cost']; ?></p>
        <a href="get-appointment.php?serviceid=<?php echo $row['id']; ?>" class="btn">Get Appointment</a>
    </div>
    <?php } ?>
    </main>

    <?php include ('include/footer.php');?>
</body>
</html>