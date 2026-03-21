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
    <title>Rejected Appointment - BPMS Admin</title>
    <link rel="stylesheet" href="css/rejected-appointment.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <h2 class="title">Rejected Appointment</h2>
    <div class="container">
        <h3 class="subtitle">List of Declined Bookings:</h3>
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
                                       WHERE tblappointment.Status='Rejected'
                                       ORDER BY tblappointment.ID DESC");
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
                    <td><span style="color:red; font-weight:bold;">Rejected</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="view-appointment.php?viewid=<?php echo $row['ID'];?>" class="view-btn">View</a>
                        </div>
                    </td>
                </tr>
            <?php $cnt++; } } else { ?>
                <tr>
                    <td colspan="7" style="text-align:center; color:red; padding:20px;">No rejected appointments found.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>