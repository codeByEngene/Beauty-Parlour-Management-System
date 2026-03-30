<?php
session_start();
include('includes/dbconnection.php');

$fdate = isset($_REQUEST['fromdate']) ? $_REQUEST['fromdate'] : '';
$tdate = isset($_REQUEST['todate']) ? $_REQUEST['todate'] : '';

if (empty($fdate) || empty($tdate)) {
    echo "<script>alert('Please select a date range.'); window.location='bwdates-report-ds.php';</script>";
    exit;
}
if (strtotime($fdate) > strtotime($tdate)) {
    $temp = $fdate;
    $fdate = $tdate;
    $tdate = $temp;
}


$fromdate = mysqli_real_escape_string($con, $fdate);
$todate = mysqli_real_escape_string($con, $tdate);

$query = mysqli_query($con, "
    SELECT i.BillingId, i.PostingDate, u.FullName
    FROM tblinvoice i
    JOIN tblusers u ON i.Userid = u.id
    WHERE DATE(i.PostingDate) BETWEEN '$fromdate' AND '$todate'
    GROUP BY i.BillingId
    ORDER BY i.PostingDate DESC
");
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
        
        <div class="report-header-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <p class="report-range" style="margin: 0;">
                <i class="fa fa-calendar"></i> Showing records from 
                <strong><?php echo date("d-M-Y", strtotime($fromdate)); ?></strong> to 
                <strong><?php echo date("d-M-Y", strtotime($todate)); ?></strong>
            </p>
            <!-- <button onclick="window.print()" class="btn-print" style="cursor:pointer; padding: 8px 15px; background: #f67535; color: white; border: none; border-radius: 4px;">
                <i class="fa fa-print"></i> Print Report
            </button> -->
        </div>

        <table class="report-table" width="100%" border="1" style="border-collapse: collapse;">
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
                $cnt = 1;
                $row_count = mysqli_num_rows($query);

                if ($row_count > 0) {
                    while ($row = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td>#<?php echo $row['BillingId']; ?></td>
                    <td><?php echo $row['FullName']; ?></td>
                    <td><?php echo date("d-M-Y h:i A", strtotime($row['PostingDate'])); ?></td>
                    <td>
                        <a href="view-invoice.php?invoiceid=<?php echo $row['BillingId']; ?>" class="btn-view" style="text-decoration: none; color: #4e73df;">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                </tr>
            <?php
                    $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding:30px; color:red;'>No records found for this date range.</td></tr>";
                }
            ?>
            </tbody>
        </table>
        
        <?php if($row_count > 0): ?>
            <p style="margin-top: 15px; font-weight: bold;">Total Invoices Found: <?php echo $row_count; ?></p>
        <?php endif; ?>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>