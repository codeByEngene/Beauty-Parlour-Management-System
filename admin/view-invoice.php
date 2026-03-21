<?php 
session_start();
include('includes/dbconnection.php'); ?>
<?php
if(isset($_GET['invoiceid']) && !empty($_GET['invoiceid'])) {
    $invid = $_GET['invoiceid'];
} else {
    
    echo "<h2 style='color:red; text-align:center;'>Error: Invalid Invoice ID. No ID provided in the URL.</h2>";
    exit;
}
$safe_invid = mysqli_real_escape_string($con, $invid);

$ret = mysqli_query($con, "SELECT DISTINCT tblusers.FullName, tblusers.email, tblusers.MobileNumber, tblinvoice.PostingDate 
                           FROM tblusers 
                           JOIN tblinvoice ON tblusers.id = tblinvoice.Userid 
                           WHERE tblinvoice.BillingId='$safe_invid'");
$user = mysqli_fetch_array($ret);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Details</title>
    <link rel="stylesheet" href="css/view-customer.css">
    <style>
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php
$invid = $_GET['invoiceid'];
$ret = mysqli_query($con, "SELECT DISTINCT tblusers.FullName, tblusers.email, tblusers.MobileNumber, tblinvoice.PostingDate FROM tblusers JOIN tblinvoice ON tblusers.id = tblinvoice.Userid WHERE tblinvoice.BillingId='$invid'");
$user = mysqli_fetch_array($ret);
?>

<div class="main-content">
    <div class="invoice-box">
        <h2 style="text-align:center;">Parlour Service Invoice</h2>
        <hr>
        <p><strong>Invoice No:</strong> <?php echo $invid; ?></p>
        <p><strong>Customer:</strong> <?php echo $user['FullName']; ?> (<?php echo $user['MobileNumber']; ?>)</p>
        <p><strong>Date:</strong> <?php echo $user['PostingDate']; ?></p>

        <table>
            <thead>
                <tr style="background: #f4f4f4;">
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $ret2 = mysqli_query($con, "SELECT services.service_name, services.cost FROM tblinvoice JOIN services ON services.id = tblinvoice.ServiceId WHERE tblinvoice.BillingId='$invid'");
            $cnt = 1; $total = 0;
            while($row2 = mysqli_fetch_array($ret2)){
            ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row2['service_name']; ?></td>
                    <td><?php echo $row2['cost']; ?></td>
                </tr>
            <?php $cnt++; $total += $row2['cost']; } ?>
                <tr>
                    <th colspan="2" style="text-align:right;">Grand Total:</th>
                    <th>Rs. <?php echo $total; ?></th>
                </tr>
            </tbody>
        </table>
        <br>
       <a href="print-invoice.php?invoiceid=<?php echo $invid; ?>" 
   target="_blank" 
   style="padding:10px 20px; background:#e76f51; color:white; text-decoration:none; border:none; cursor:pointer; display:inline-block; border-radius: 5px;">
   Print Invoice
</a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>