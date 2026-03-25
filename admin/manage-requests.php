<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Security: Check if logged in and if they are an admin
if (strlen($_SESSION['bpmsaid'] == 0) || $_SESSION['role'] != 'admin') {
    header('location:../logout.php');
    exit();
}

// Logic to Approve an Admin
if(isset($_GET['approveid'])) {
    $id = intval($_GET['approveid']);
    $query = mysqli_query($con, "UPDATE tblusers SET status='active' WHERE id='$id'");
    if($query) {
        echo "<script>alert('Admin approved successfully!');</script>";
        echo "<script>window.location.href='manage-requests.php'</script>";
    }
}

// Logic to Reject/Delete a request
if(isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    $query = mysqli_query($con, "DELETE FROM tblusers WHERE id='$id'");
    if($query) {
        echo "<script>alert('Request rejected and deleted.');</script>";
        echo "<script>window.location.href='manage-requests.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>BPMS | Manage Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; }
        .card { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        h2 { color: #8f7463; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #8f7463; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .btn-approve { background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; margin-right: 5px; }
        .btn-reject { background: #dc3545; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; }
        .btn-approve:hover { background: #218838; }
        .no-data { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>

<div class="card">
    <h2><i class="fa fa-user-clock"></i> Pending Admin Approvals</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = 1;
            // Only fetch admins who are in 'pending' status
            $ret = mysqli_query($con, "SELECT * FROM tblusers WHERE role='admin' AND status='pending'");
            $num = mysqli_num_rows($ret);
            if($num > 0) {
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['MobileNumber'];?></td>
                    <td>
                        <a href="manage-requests.php?approveid=<?php echo $row['id'];?>" class="btn-approve" onclick="return confirm('Approve this admin?')">Approve</a>
                        <a href="manage-requests.php?delid=<?php echo $row['id'];?>" class="btn-reject" onclick="return confirm('Reject and delete this request?')">Reject</a>
                    </td>
                </tr>
            <?php 
                $cnt++; 
                } 
            } else { ?>
                <tr>
                    <td colspan="5" class="no-data">No pending admin requests found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <a href="dashboard.php" style="color: #8f7463; text-decoration: none; font-weight: bold;"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
</div>

</body>
</html>