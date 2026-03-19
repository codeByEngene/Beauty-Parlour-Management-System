<!DOCTYPE html>
<html>
<head>
<title>Sales Reports</title>
<link rel="stylesheet" href="css/sales-reports.css">
</head>

<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">

<div class="main-container">

<h2 class="page-title">Sales Reports</h2>

<div class="report-box">

<div class="box-header">
Sales Reports:
</div>

<div class="box-body">

<form>

<label>From Date</label>
<input type="date" class="input-field">

<label>To Date</label>
<input type="date" class="input-field">

<label>Request Type</label>

<div class="radio-group">
<input type="radio" name="type" checked> Month wise
<input type="radio" name="type"> Year wise
</div>

<button type="submit" class="btn-submit">Submit</button>

</form>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>