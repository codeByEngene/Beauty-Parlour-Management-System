<?php
include('includes/dbconnection.php');
if(isset($_GET['delid'])) {
    $id = $_GET['delid'];
    mysqli_query($con, "DELETE FROM tblcontact WHERE id='$id'");
    echo "<script>alert('Enquiry deleted'); window.location.href='read-enquiry.php';</script>";
}
?>