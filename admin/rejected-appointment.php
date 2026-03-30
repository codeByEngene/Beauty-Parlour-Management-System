<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Admin login check - fixed to prevent auto-logout
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rejected Appointment - BPMS Admin</title>
    <link rel="stylesheet" href="css/rejected-appointment.css">
    <style>
        /* Modern, consistent button style */
        .view-btn {
            background-color: #4e73df;
            color: white;
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
            transition: background 0.3s;
        }
        .view-btn:hover {
            background-color: #2e59d9;
        }
        .status-rejected {
            color: #e74a3b;
            font-weight: bold;
        }
        .appointment-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .appointment-table th, .appointment-table td { padding: 12px; border: 1px solid #eee; text-align: left; }
        .appointment-table thead tr { background-color: #f8f9fc; }
    </style>
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
                    <th>Time</th> <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Added AptTime to the SELECT query so we can display it
            $ret = mysqli_query($con, "SELECT tblappointment.ID, tblappointment.AppointmentNumber, tblappointment.AptDate, tblappointment.AptTime, tblusers.FullName, tblusers.MobileNumber 
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
                    <td><?php echo date("d-M-Y", strtotime($row['AptDate']));?></td>
                    <td><?php echo date("h:i A", strtotime($row['AptTime']));?></td>
                    <td><span class="status-rejected">Rejected</span></td>
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
                    <td colspan="8" style="text-align:center; color:red; padding:20px;">No rejected appointments found.</td>
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