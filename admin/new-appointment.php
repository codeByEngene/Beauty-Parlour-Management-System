<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Admin login check - ensure session exists before loading content
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
    exit(); // Always exit after a header redirect
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Appointment | Admin Panel</title>
    <link rel="stylesheet" href="css/new-appointment.css">
    <style>
        .service-tag {
            color: #d4a373;
            font-weight: bold;
            font-size: 0.9em;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        /* Pleasant, consistent button style */
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
        /* Highlight for the newest row */
        .appointment-table tbody tr:first-child {
            background-color: #fff9f0;
        }
        .appointment-table { width: 100%; border-collapse: collapse; }
        .appointment-table th, .appointment-table td { padding: 12px; border: 1px solid #eee; text-align: left; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <h2 class="title">New Pending Appointments</h2>
    <div class="container">
        <table class="appointment-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Appt. No.</th>
                    <th>Customer Name</th>
                    <th>Selected Service</th>
                    <th>Mobile Number</th>
                    <th>Appt. Date</th>
                    <th>Appt. Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Logic: Sort by ID DESC so the newest appears first
            $ret = mysqli_query($con, "SELECT 
                tblappointment.ID, 
                tblappointment.AppointmentNumber, 
                tblappointment.AptDate, 
                tblappointment.AptTime, 
                tblappointment.Status, 
                tblusers.FullName, 
                tblusers.MobileNumber,
                services.service_name 
                FROM tblappointment 
                JOIN tblusers ON tblusers.id = tblappointment.UserID 
                LEFT JOIN services ON services.id = tblappointment.ServiceId 
                WHERE tblappointment.Status='Pending' OR tblappointment.Status='' OR tblappointment.Status='0'
                ORDER BY tblappointment.ID DESC"); 
            
            $cnt = 1;
            if(mysqli_num_rows($ret) > 0) {
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row['AppointmentNumber'];?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td class="service-tag"><?php echo ($row['service_name'] != "") ? $row['service_name'] : "Not Specified"; ?></td>
                    <td><?php echo $row['MobileNumber'];?></td>
                    <td><?php echo date("d-M-Y", strtotime($row['AptDate']));?></td>
                    <td><?php echo date("h:i A", strtotime($row['AptTime']));?></td>
                    <td><span class="status-pending">Pending</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="view-appointment.php?viewid=<?php echo $row['ID'];?>" class="view-btn">View / Process</a>
                        </div>
                    </td>
                </tr>
            <?php 
                $cnt++; 
                } 
            } else { ?>
                <tr>
                    <td colspan="9" style="text-align:center; color:red; padding:20px;">No New Pending Appointments found.</td>
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