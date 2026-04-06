<?php 
session_start();
include('includes/dbconnection.php');

if(isset($_GET['invoiceid']) && !empty($_GET['invoiceid'])) {
    $invid = mysqli_real_escape_string($con, $_GET['invoiceid']);
} else {
    echo "Invalid Invoice ID"; exit;
}

$ret = mysqli_query($con, "SELECT DISTINCT tblusers.FullName, tblusers.MobileNumber, tblinvoice.PostingDate 
                            FROM tblusers 
                            JOIN tblinvoice ON tblusers.id = tblinvoice.Userid 
                            WHERE tblinvoice.BillingId='$invid' LIMIT 1");
$user = mysqli_fetch_array($ret);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt_<?php echo $invid; ?></title>
    <style>

        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 20px; background: #fff; }
        
        .invoice-box { 
            width: 100%; 
            max-width: 800px; 
            margin: auto; 
            padding: 30px; 
            border: 1px solid #eee;
            box-sizing: border-box; 
        }

        .header-section { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #e76f51; padding-bottom: 10px; }
        .header-section h1 { margin: 0; color: #e76f51; text-transform: uppercase; font-size: 24px; }

        .info-grid { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 14px; }
        .info-left, .info-right { width: 48%; line-height: 1.5; }
        .info-right { text-align: right; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; table-layout: fixed; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; word-wrap: break-word; }
        th { background: #f9f9f9; font-size: 13px; }

        .total-row { font-weight: bold; background: #fdfaf7; font-size: 16px; color: #e76f51; }
        .text-right { text-align: right; }

        .footer-note { text-align: center; margin-top: 40px; font-style: italic; color: #666; font-size: 13px; }

        @media print {
            body { padding: 0; margin: 0; }
            .invoice-box { border: none; width: 100%; max-width: 100%; padding: 10px; }
            .no-print { display: none; }
            
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
        @media print {
        @page { 
            margin: 0; /* This tells the browser to remove the default margins where the URL sits */
        }
        body { 
            margin: 1.6cm; /* This adds margin back to your content so it doesn't touch the edge of the paper */
        }
        .no-print { display: none; }
        }


    </style>
</head>
<body onload="window.print()">

<div class="invoice-box">
    <div class="header-section">
        <h1>ANUA BEAUTY PARLOUR</h1>
        <p>Official Service Receipt</p>
    </div>

    <div class="info-grid">
        <div class="info-left">
            <strong>Customer:</strong> <?php echo $user['FullName']; ?><br>
            <strong>Contact:</strong> <?php echo $user['MobileNumber']; ?>
        </div>
        <div class="info-right">
            <strong>Invoice No:</strong> #<?php echo $invid; ?><br>
            <strong>Date:</strong> <?php echo date("d-M-Y", strtotime($user['PostingDate'])); ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="60%">Service Description</th>
                <th width="30%" class="text-right">Price</th>
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
                <td class="text-right">Rs. <?php echo number_format($row2['cost'], 2); ?></td>
            </tr>
        <?php $cnt++; $total += $row2['cost']; } ?>
            <tr class="total-row">
                <td colspan="2" class="text-right">GRAND TOTAL:</td>
                <td class="text-right">RS. <?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer-note">
        <p>Thank you for choosing Anua Beauty Parlour!</p>
        <button class="no-print" onclick="window.print()" style="padding:8px 15px; background:#e76f51; color:white; border:none; border-radius:4px; cursor:pointer;">Print Again</button>
    </div>
</div>

</body>
</html>