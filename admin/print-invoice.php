<?php 
include('includes/dbconnection.php');

if(isset($_GET['invoiceid']) && !empty($_GET['invoiceid'])) {
    $invid = $_GET['invoiceid'];
} else {
    echo "Invalid Invoice ID";
    exit;
}

$safe_invid = mysqli_real_escape_string($con, $invid);

// 1. Fetch User/Invoice Header Info - Added LIMIT 1 to ensure only ONE header shows
$ret = mysqli_query($con, "SELECT DISTINCT tblusers.FullName, tblusers.MobileNumber, tblinvoice.PostingDate 
                           FROM tblusers 
                           JOIN tblinvoice ON tblusers.id = tblinvoice.Userid 
                           WHERE tblinvoice.BillingId='$safe_invid' 
                           LIMIT 1");
$user = mysqli_fetch_array($ret);

// Check if user exists to avoid errors
if(!$user) {
    echo "No invoice found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Invoice - <?php echo $invid; ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; margin: 0; padding: 40px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; background: #fff; }
        .invoice-header { margin-bottom: 20px; border-bottom: 2px solid #e76f51; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="invoice-box">
        <div class="invoice-header">
            <h2 class="text-center">ANUA BEAUTY PARLOUR</h2>
            <p class="text-center" style="margin-top:-10px;">Service Invoice</p>
        </div>

        <div style="display: flex; justify-content: space-between;">
            <div>
                <p><strong>Customer:</strong> <?php echo $user['FullName']; ?></p>
                <p><strong>Contact:</strong> <?php echo $user['MobileNumber']; ?></p>
            </div>
            <div class="text-right">
                <p><strong>Invoice No:</strong> #<?php echo $invid; ?></p>
                <p><strong>Date:</strong> <?php echo date("d-M-Y", strtotime($user['PostingDate'])); ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>Service Name</th>
                    <th width="25%">Cost</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // 2. Fetch the specific services - This loop handles the multiple items
            $ret2 = mysqli_query($con, "SELECT services.service_name, services.cost 
                                        FROM tblinvoice 
                                        JOIN services ON services.id = tblinvoice.ServiceId 
                                        WHERE tblinvoice.BillingId='$safe_invid'");
            $cnt = 1; 
            $total = 0;
            while($row2 = mysqli_fetch_array($ret2)){
            ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row2['service_name']; ?></td>
                    <td>Rs. <?php echo number_format($row2['cost'], 2); ?></td>
                </tr>
            <?php 
                $cnt++; 
                $total += $row2['cost']; 
            } 
            ?>
                <tr>
                    <th colspan="2" class="text-right">Grand Total:</th>
                    <th>Rs. <?php echo number_format($total, 2); ?></th>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 50px;" class="text-center">
            <p><em>Thank you for your visit!</em></p>
            <button class="no-print" onclick="window.print()" style="padding:10px 20px; background:#e76f51; color:white; border:none; cursor:pointer; border-radius:4px;">Print Again</button>
        </div>
    </div>

</body>
</html>