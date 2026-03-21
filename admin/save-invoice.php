<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['assign'])) {
    $userid = $_GET['addid']; 
    $services = $_POST['selected_services']; 
    
    $billingid = mt_rand(100000000, 999999999);

    if (!empty($services)) {
        foreach ($services as $serviceid) {
            $query = mysqli_query($con, "INSERT INTO tblinvoice (Userid, ServiceId, BillingId) 
                                         VALUES ('$userid', '$serviceid', '$billingid')");
        }

        if ($query) {
            echo "<script>alert('Services Assigned Successfully! Invoice ID: $billingid');</script>";
            echo "<script>window.location.href='invoices.php';</script>";
        } else {
            echo "<script>alert('Database Error. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please select at least one service.');</script>";
        echo "<script>window.location.href='add-customer-services.php?addid=$userid';</script>";
    }
}
?>