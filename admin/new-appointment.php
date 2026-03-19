<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Appointment</title>
    <link rel="stylesheet" href="css/new-appointment.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2 class="title">New Appointment</h2>
    <div class="container">
        <table class="appointment-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Appointment Number</th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Sirf Pending status bhayeko data tanne
            $ret = mysqli_query($con, "SELECT tblappointment.ID, tblappointment.AppointmentNumber, tblappointment.AptDate, tblappointment.AptTime, tblappointment.Status, tblusers.FullName, tblusers.MobileNumber 
                                       FROM tblappointment 
                                       JOIN tblusers ON tblusers.id = tblappointment.UserID 
                                       WHERE tblappointment.Status='Pending' OR tblappointment.Status=''");
            $cnt = 1;
            if(mysqli_num_rows($ret) > 0) {
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row['AppointmentNumber'];?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['MobileNumber'];?></td>
                    <td><?php echo $row['AptDate'];?></td>
                    <td><?php echo $row['AptTime'];?></td>
                    <td><span style="color:orange">Pending</span></td>
                    <td>
                        <a href="view-appointment.php?viewid=<?php echo $row['ID'];?>" style="background:#007bff; color:white; padding:5px 10px; text-decoration:none; border-radius:4px;">View / Process</a>
                    </td>
                </tr>
            <?php $cnt++; } } else { ?>
                <tr><td colspan="8" style="text-align:center; color:red;">No New Appointments.</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>