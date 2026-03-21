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
    <title>Sales Reports | Admin Dashboard</title>
    <link rel="stylesheet" href="css/sales-reports.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <div class="main-container">
        <h2 class="page-title">Sales Reports</h2>

        <div class="report-box">
            <div class="box-header">Generate Sales Report</div>
            <div class="box-body">
                <form action="sales-reports-detail.php" method="post">
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" name="fromdate" class="input-field" required="true">
                    </div>

                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="todate" class="input-field" required="true">
                    </div>

                    <div class="form-group">
                        <label>Request Type</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="type" value="month" checked> Month wise
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="type" value="year"> Year wise
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="btn-submit">Generate Report</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>