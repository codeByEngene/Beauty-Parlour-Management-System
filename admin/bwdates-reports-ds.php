<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Between Dates Reports | BPMS Admin</title>
    <link rel="stylesheet" href="css/bwdates-reports-ds.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <div class="container">
        <h2 class="title">Between Dates Reports</h2>

        <div class="card">
            <div class="card-header">
                <h3>Select Date Range</h3>
            </div>
            
            <form action="bwdates-reports-details.php" method="post" name="bwdatesreport">
                <div class="form-group">
                    <label for="fromdate">From Date</label>
                    <input type="date" name="fromdate" id="fromdate" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="todate">To Date</label>
                    <input type="date" name="todate" id="todate" class="form-control" required="true">
                </div>

                <div class="button-row">
                    <button type="submit" name="submit" class="btn-submit">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>