<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Set default dates for the admin's convenience
$firstDayOfMonth = date('Y-m-01');
$today = date('Y-m-d');
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
                        <input type="date" name="fromdate" id="fromdate" class="input-field" value="<?php echo $firstDayOfMonth; ?>" max="<?php echo $today; ?>" required="true">
                    </div>

                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="todate" id="todate" class="input-field" value="<?php echo $today; ?>" max="<?php echo $today; ?>" required="true">
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

<script>
    const fromDate = document.getElementById('fromdate');
    const toDate = document.getElementById('todate');

    function validateDates() {
        // Set the minimum selectable date for 'To Date' based on 'From Date'
        toDate.setAttribute('min', fromDate.value);

        // If 'To Date' is now earlier than 'From Date' because of a change, reset it
        if (toDate.value && toDate.value < fromDate.value) {
            toDate.value = fromDate.value;
        }
    }

    // Run whenever 'From Date' changes
    fromDate.addEventListener('change', validateDates);

    // Run on page load to ensure initial values are valid
    window.onload = validateDates;
</script>
<script src="js/script.js"></script>

</body>
</html>