<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Admin login check
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {

if(isset($_GET['delid'])) {
    $sid = intval($_GET['delid']);
    $query = mysqli_query($con, "DELETE FROM tblappointment WHERE ID ='$sid'");
    if($query) {
        echo "<script>alert('Appointment Deleted Successfully');</script>";
        echo "<script>window.location.href='all-appointment.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Appointment - BPMS Admin</title>
    <link rel="stylesheet" href="css/all-appointment.css">
    <style>
   
        .main-content { padding: 20px; margin-left: 250px; background: #f4f7f6; min-height: 100vh; }
        .appointment-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .appointment-table th, .appointment-table td { border: 1px solid #eee; padding: 12px; text-align: left; }
        .appointment-table th { background-color: #f8f9fa; color: #333; }
        .status-pending { color: orange; font-weight: bold; }
        .status-accepted { color: green; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }
        .view-btn { padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 3px; font-size: 13px; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2 class="title">All Appointment</h2>

    <div class="container">
        <h3 class="subtitle">Complete Appointment List:</h3>

        <table class="appointment-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Apt Number</th>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Apt Date</th>
                    <th>Apt Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php
       
            $ret = mysqli_query($con, "SELECT tblappointment.ID, tblappointment.AppointmentNumber, tblappointment.AptDate, tblappointment.AptTime, tblappointment.Status, tblusers.FullName, tblusers.MobileNumber 
                                       FROM tblappointment 
                                       JOIN tblusers ON tblusers.id = tblappointment.UserID 
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
                    <td><?php echo $row['AptTime'];?></td>
                    <td>
                        <?php 
                        $status = $row['Status'];
                        if($status == "Pending" || $status == "" || $status == "0") {
                            echo '<span class="status-pending">Pending</span>';
                        } elseif($status == "Accepted") {
                            echo '<span class="status-accepted">Accepted</span>';
                        } else {
                            echo '<span class="status-rejected">Rejected</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="view-appointment.php?viewid=<?php echo $row['ID'];?>" class="view-btn">View</a>
                        </div>
                    </td>
                </tr>
            <?php 
                $cnt++; 
                } 
            } else { ?>
                <tr>
                    <td colspan="8" style="text-align:center; color:red; padding:20px;">No appointments found in database.</td>
                </tr>
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