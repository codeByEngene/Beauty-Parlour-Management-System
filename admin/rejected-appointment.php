<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rejected Appointment</title>
    <link rel="stylesheet" href="css/rejected-appointment.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2 class="title">Rejected Appointment</h2>
    <div class="container">
        <table class="appointment-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Appointment Number</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $ret = mysqli_query($con, "SELECT tblappointment.ID, tblappointment.AppointmentNumber, tblappointment.AptDate, tblusers.FullName, tblusers.MobileNumber 
                                       FROM tblappointment 
                                       JOIN tblusers ON tblusers.id = tblappointment.UserID 
                                       WHERE tblappointment.Status='Rejected'");
            $cnt = 1;
            while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row['AppointmentNumber'];?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['MobileNumber'];?></td>
                    <td><?php echo $row['AptDate'];?></td>
                    <td><span style="color:red">Rejected</span></td>
                    <td><a href="view-appointment.php?viewid=<?php echo $row['ID'];?>" style="background:#007bff; color:white; padding:5px; text-decoration:none;">View</a></td>
                </tr>
            <?php $cnt++; } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>