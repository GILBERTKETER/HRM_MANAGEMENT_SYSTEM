<?php
require_once "importance.php";

if (!User::loggedIn()) {
	Config::redir("login.php");
}
$otp = User::get(User::getToken(), "otp");
if (!$otp == 0) {
	Config::redir("otp_verification.php"); // Redirect to the verification stage or login page
}
?>

<html>

<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Dashboard</title>
	<?php require_once "inc/head.inc.php";  ?>
</head>

<body>
	<?php require_once "inc/header.inc.php"; ?>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-3'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- this should be a sidebar -->
			<div class='col-md-8'>
				<div class='content-area'>
					<div class='content-header'>
						Dashboard <small></small>
					</div>
					<div class='content-body'>
						<div class='row'>
							<?php if ($userStatus == 1) {
								Dashboard::draw(" Employees", Dashboard::employees(),  "employees-record.php");
							} ?>
							<?php if ($userStatus == 1) {
								Dashboard::draw("Allowances", Dashboard::allowances(),  "allowance-list.php");
							} ?>
							<?php if ($userStatus == 1) {
								Dashboard::draw("Deductions", Dashboard::deductions(),  "deduction-list.php");
							} ?>
							<?php if ($userStatus == 1) {
								Dashboard::draw("Attendance", Dashboard::admin_attendance(),  "attendance-list.php");
							} ?>
							<?php if ($userStatus == 2) {
								Dashboard::draw("Attendance", Dashboard::attendance($userId),  "attendance-list.php");
							} ?>
							<?php if ($userStatus == 1) {
								Dashboard::draw("Leaves", Dashboard::admin_leaves(),  "received-leave.php");
							} ?>
							<?php if ($userStatus == 1) {
								Dashboard::draw("Payroll", Dashboard::payroll(),  "payroll.php");
							} ?>
							<?php if ($userStatus == 2) {
								Dashboard::draw("Leaves", Dashboard::leaves($token),  "sent-leave.php");
							} ?>
							<?php if ($userStatus == 2) {
								Dashboard::draw("Salary Details", "",  "view-empsal.php?eid=$userId");
							} ?>
							<?php Dashboard::draw("Change Password", "",  "change-password.php"); ?>
						</div>
					</div><!-- end of the content area -->
				</div>
			</div>

		</div> <!-- this should be a sidebar -->
	</div>
	</div>

</body>

</html>