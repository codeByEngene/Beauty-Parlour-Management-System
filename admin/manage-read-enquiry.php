<?php 
session_start(); 
error_reporting(0);
include('includes/dbconnection.php');

// CRITICAL: Session check must happen before any HTML to prevent auto-logout
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
    exit(); 
} else {
    // Delete Logic
    if(isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $query = mysqli_query($con, "DELETE FROM tblcontact WHERE ID='$rid'");
        if($query) {
            echo "<script>alert('Read enquiry deleted successfully.');</script>";
            echo "<script>window.location.href='manage-read-enquiry.php'</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Read Enquiry - BPMS Admin</title>
    <link rel="stylesheet" href="css/readenq.css">
    <style>
        /* Modernized Button UI: High contrast and professional */
        .view-btn {
            background-color: #4e73df; /* Professional Blue */
            color: white;
            padding: 7px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            margin-right: 8px;
            display: inline-block;
            transition: 0.3s;
        }
        .delete-btn {
            background-color: #e74a3b; /* Pleasant Red */
            color: white;
            padding: 7px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
            transition: 0.3s;
        }
        .view-btn:hover { background-color: #2e59d9; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .delete-btn:hover { background-color: #be2617; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        
        .action-buttons { display: flex; align-items: center; }
        .enquiry-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        .enquiry-table th { background-color: #f8f9fc; color: #4e73df; font-weight: bold; }
        .enquiry-table th, .enquiry-table td { padding: 12px; border: 1px solid #e3e6f0; text-align: left; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <div class="container">
        <h1 class="title">Manage Read Enquiry</h1>
        <div class="box">
            <h3 class="subtitle">History of Read Messages:</h3>
            <table class="enquiry-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Enquiry Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Selecting records where IsRead = 1
                $ret = mysqli_query($con, "SELECT * FROM tblcontact WHERE IsRead=1 ORDER BY ID DESC");
                $cnt = 1;
                
                if(mysqli_num_rows($ret) > 0) {
                    while ($row = mysqli_fetch_array($ret)) {
                ?>
                    <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo date("d-M-Y h:i A", strtotime($row['PostingDate'])); ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="view-enquiry.php?viewid=<?php echo $row['ID']; ?>" class="view-btn">View Details</a>
                                <a href="manage-read-enquiry.php?delid=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this historical record?');">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php 
                    $cnt++; 
                    } 
                } else { ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#e74a3b; padding:40px; font-weight: bold;">
                            No read enquiries found in the database.
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>
<?php } ?>