<?php
session_start();
error_reporting(E_ALL);
include('include/dbconnection.php');

if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking History</title>
    <link rel="stylesheet" href="style5.css">
    <link rel="stylesheet" href="include/header.css">
    <link rel="stylesheet" href="include/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<?php include('include/header.php');?>

    <section class="page-banner">
        <div class="banner-overlay">
            <h1>Booking History</h1>
            <p>Track your salon appointments and their current status.</p>
        </div>
    </section>

    <div class="breadcrumb">
        <a href="dashboard.php">Home</a>
        <span>›</span>
        <span class="active">Booking History</span>
    </div>

    <section class="content">
        <h2 class="section-title">Your Appointment History</h2>

        <div class="table-container">
            <table width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Apt Number</th>
                        <th>Apt Date</th>
                        <th>Apt Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $userid = $_SESSION['uid'];
                // User ko appointments naya pahile (DESC) dekhaune
                $query = mysqli_query($con, "SELECT * FROM tblappointment WHERE UserID='$userid' ORDER BY ID DESC");
                $cnt = 1;
                
                if(mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $cnt;?></td>
                        <td><?php echo $row['AppointmentNumber'];?></td>
                        <td><?php echo $row['AptDate'];?></td>
                        <td><?php echo $row['AptTime'];?></td>
                        <td>
                            <?php 
                                $status = $row['Status'];
                                if($status == "Pending" || $status == "") { 
                                    echo '<span style="color:orange; font-weight:bold;">Pending</span>'; 
                                } elseif($status == "Accepted") {
                                    echo '<span style="color:green; font-weight:bold;">Accepted</span>';
                                } elseif($status == "Rejected") {
                                    echo '<span style="color:red; font-weight:bold;">Rejected</span>';
                                } else {
                                    echo $status;
                                }
                            ?>
                        </td>
                        <td>
                            <a href="appointment-detail.php?viewid=<?php echo $row['ID'];?>" class="view-btn" style="text-decoration:none; padding: 5px 10px; background: #007bff; color: white; border-radius: 4px; font-size:12px;">View Detail</a>
                        </td>
                    </tr>
                <?php 
                    $cnt++; 
                    } 
                } else { 
                ?>
                    <tr>
                        <td colspan="6" style="color:red; text-align:center; padding:20px;">
                            You haven't booked any appointments yet!
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

<?php include('include/footer.php');?>
</body>
</html>
<?php } ?>