<?php
session_start();
include('includes/dbconnection.php');

// Security Check
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    $fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
    $todate   = isset($_POST['todate']) ? $_POST['todate'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Details | BPMS</title>
    <link rel="stylesheet" href="css/bwdates-reports-details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content" id="main-content">
    <h1 class="page-title">Report Results</h1>

    <div class="card">
        <h3 class="sub-title">Invoice Report</h3>
        <p class="report-range">
            <i class="fa fa-calendar"></i> Showing records from <strong><?php echo date("d-M-Y", strtotime($fromdate)); ?></strong> to <strong><?php echo date("d-M-Y", strtotime($todate)); ?></strong>
        </p>

        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice ID</th>
                    <th>Customer Name</th>
                    <th>Invoice Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($fromdate) && !empty($todate)) {
                // ADDED 'GROUP BY' so each BillingId only shows once
                // ADDED 'ORDER BY' so newest invoices show first
                $query = mysqli_query($con, "
                    SELECT i.BillingId, i.PostingDate, u.FullName
                    FROM tblinvoice i
                    JOIN tblusers u ON i.Userid = u.id
                    WHERE DATE(i.PostingDate) BETWEEN '$fromdate' AND '$todate'
                    GROUP BY i.BillingId
                    ORDER BY i.PostingDate DESC
                ");

                $cnt = 1;
                while ($row = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td>#<?php echo $row['BillingId']; ?></td>
                    <td><?php echo $row['FullName']; ?></td>
                    <td><?php echo date("d-M-Y H:i", strtotime($row['PostingDate'])); ?></td>
                    <td>
                        <a href="view-invoice.php?invoiceid=<?php echo $row['BillingId']; ?>" class="btn-view">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                </tr>
            <?php
                $cnt++;
                }

                if ($cnt == 1) {
                    echo "<tr><td colspan='5' style='text-align:center; padding:20px; color:red;'>No records found for this date range.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding:20px;'>Please go back and select a valid date range.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>