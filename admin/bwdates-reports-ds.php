<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$firstDayOfMonth = date('Y-m-01'); 
$today = date('Y-m-d');

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
                    <input type="date" name="fromdate" id="fromdate" class="form-control" required="true" max="<?php echo $today; ?>">
                </div>

                <div class="form-group">
                    <label for="todate">To Date</label>
                    <input type="date" name="todate" id="todate" class="form-control" required="true" max="<?php echo $today; ?>">
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

<script>
    document.getElementById('fromdate').addEventListener('change', function() {
        var fromDateValue = this.value;
        var toDateInput = document.getElementById('todate');
        
        // Set the minimum selectable date for the 'To Date' input
        toDateInput.setAttribute('min', fromDateValue);
        
        // Optional: If the user already selected a 'To Date' that is now invalid, clear it
        if (toDateInput.value && toDateInput.value < fromDateValue) {
            toDateInput.value = '';
        }
    });
</script>
</body>
</html>
<?php ?>