<?php 
session_start(); // CRITICAL: This must be the very first line
error_reporting(0);
include('includes/dbconnection.php');

// Check if the admin is logged in
if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
    exit();
} else {
    // Process the Enquiry View
    if(isset($_GET['viewid'])) {
        $vid = intval($_GET['viewid']); // Sanitize with intval

        // Mark as read automatically when viewed
        mysqli_query($con, "UPDATE tblcontact SET IsRead=1 WHERE id='$vid'");

        $ret = mysqli_query($con, "SELECT * FROM tblcontact WHERE id='$vid'");
        $row = mysqli_fetch_array($ret);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Enquiry Detail | BPMS Admin</title>
    <link rel="stylesheet" href="css/view-enquiry.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content" id="main-content">
    <div class="page-wrapper">
        <h1 class="title">View Enquiry Details</h1>
        <div class="container">
            <table class="enquiry-table" width="100%" border="1" style="border-collapse: collapse;">
                <tr>
                    <th style="padding:10px; background:#f4f4f4; width:20%;">Name</th>
                    <td style="padding:10px;"><?php echo $row['Name']; ?></td>
                    <th style="padding:10px; background:#f4f4f4; width:20%;">Email</th>
                    <td style="padding:10px;"><?php echo $row['Email']; ?></td>
                </tr>
                <tr>
                    <th style="padding:10px; background:#f4f4f4;">Contact No.</th>
                    <td style="padding:10px;"><?php echo $row['Phone']; ?></td>
                    <th style="padding:10px; background:#f4f4f4;">Query Date</th>
                    <td style="padding:10px;"><?php echo date("d-M-Y H:i", strtotime($row['PostingDate'])); ?></td>
                </tr>
                <tr class="message-row">
                    <th style="padding:10px; background:#f4f4f4;">Message</th>
                    <td colspan="3" style="padding:15px; vertical-align: top; height: 100px;">
                        <?php echo nl2br($row['Message']); ?>
                    </td>
                </tr>
            </table>
            <br>
            <div style="text-align: left;">
                <button onclick="window.location.href='manage-read-enquiry.php'" style="padding:10px 25px; background:#4e73df; color:white; border:none; cursor:pointer; border-radius:4px; font-weight:bold;">
                    <i class="fa fa-arrow-left"></i> Back to List
                </button>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>