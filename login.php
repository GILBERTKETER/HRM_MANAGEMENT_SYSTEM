<?php
require_once "importance.php";

if (User::loggedIn()) {
	Config::redir("index.php");
}
?>

<html>

<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Login</title>
	<?php require_once "inc/head.inc.php";  ?>
</head>

<body>
	<?php require_once "inc/header.inc.php"; ?>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-1'></div>
			<div class='col-md-4'>

			</div> <!-- this should be a sidebar -->
			<div class='col-md-15'>
				<div class='content-area'>
					<div class='content-header'>

					</div>
					<div class='content-body'>

						<?php
						if (isset($_GET['attempt'])) {
							// STARTING THE LOGIN AREA 

							$status = $_GET['attempt'];

							if ($status == 1) {
								$header = "Login as an Admin";
							} else {
								$header = "Login as an Employee";
							}

							echo "<center><div class='badge-header'>$header</div></center>";

							// we created a method for creating forms

							if (isset($_POST['login-email'])) {
								$email = $_POST['login-email'];
								$password = $_POST['login-password'];

								if ($email == "" || $password == "") {
									Messages::error("You must fill in all the fields");
								} else {
									User::login($email, $password, $status);
								}
							}

						?>
							<div class='row'>
								<div class='col-md-3'></div>
								<div class='col-md-6'>
									<div class='form-holder'>
										<?php Db::form(array("Email", "Password"), 3, array("login-email", "login-password"), array("text", "password"), "Login"); ?>
										<a href="requestPassword_change.php">forgot password?</a>
									</div>
								</div>
								<div class='col-md-3'></div>
							</div>
						<?php
							// ENDNG THE LOGIN AREA
						} else {

						?>

							<center>
								<div class='badge-header'>Login As:</div>
							</center>
							<div class='row'>
								<div class='col-md-3'></div>
								<div class='col-md-6'>
									<div class='row' style='margin-top: 70px;'>
										<div class='col-md-6'>
											<center>
												<div class='img-login-icons'>
													<img class='img-responsive' src='images/admin-logo.png' alt='login as a admin' />
												</div>
												<center><a href='login.php?attempt=1'>
														<div class='badge-header'>Admin</div>
													</a></center>

											</center>
										</div>
										<div class='col-md-6'>
											<center>
												<div class='img-login-icons'>
													<img class='img-responsive' src='images/emp-logo.png' alt='login as a employee' />
												</div>
												<center><a href='login.php?attempt=2'>
														<div class='badge-header'>Employee</div>
													</a></center>
											</center>
										</div>
									</div>
								</div>
								<div class='col-md-3'></div>
							<?php } ?>
							</div><!-- end of the content area -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	include 'inc/footer.inc.php'; ?>
</body>

</html>