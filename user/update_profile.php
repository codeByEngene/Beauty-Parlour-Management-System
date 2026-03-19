<?php
session_start();
include('include/db_connection.php');

if(isset($_POST['submit'])) {
    $uid = $_SESSION['uid'];
    $fname = $_POST['FullName'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    // Update query
    $query = mysqli_query($con, "update tblusers set FirstName='$fname', MobileNumber='$mobile', Email='$email' where ID='$uid'");

    if ($query) {
        echo "<script>alert('Profile has been updated.');</script>";
        echo "<script>window.location.href='profile.php'</script>";
    } else {
        echo "<script>alert('Something Went Wrong. Please try again.');</script>";
        echo "<script>window.location.href='profile.php'</script>";
    }
}
?>