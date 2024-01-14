<?php
require_once "importance.php";

if (!User::loggedIn()) {
	Config::redir("login.php");
}
?>

<html>

<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Profile</title>
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
						<?php echo "Employee Details"; ?>
					</div>
					<div class='content-body'>

						<?php

						$token = $_GET['token'];
						$pic = User::get($token, "profile");
						$img = (!empty($pic)) ? ($pic) : ("profile.png");
						$empid = User::get($token, "id");
						$userFirstName = User::get($token, "firstName");
						$userSecondName = User::get($token, "secondName");
						$userDob = date("d M Y", strtotime(User::get($token, "date_of_birth")));
						$userDoj = date("d M Y", strtotime(User::get($token, "date_of_joining")));
						$userEmail = User::get($token, "email");
						$userPassword = User::get($token, "password");
						$userToken = User::get($token, "token");
						$userStatus = User::get($token, "status");
						$userPhone = User::get($token, "phone");
						$userProfile = User::get($token, "profile");
						$userGender = User::get($token, "gender");
						$userRole = User::get($token, "designation");
						$userSalary = User::get($token, "salary");
						$userAccount = User::get($token, "account_no");

						if ($userStatus == 1) {
							$userRole = "admin";
						} else {
							$userRole = $userRole;
						}
						echo "<div class='form-holder'>";

						$form = new Form(3, "post");
						$form->init();

						echo "
			<div class='form-group'>
				<label class='col-md-3' style='font-size:15px'>Photo</label>
				<div class='col-md-9'>
					<img src='images/$img' width='70px' height='70px'> 
				</div> 
			</div> 
		";

						$form->textBox("Employee Id", "user-ei", "text",  $empid, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("First Name", "user-fn", "text",  $userFirstName, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Last Name", "user-sn", "text",  $userSecondName, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Date Of Birth", "user-dob", "text",  $userDob, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Email", "user-em", "text",  $userEmail, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Designation", "user-role", "text",  $userRole, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Gender", "user-gender", "text",  $userGender, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Phone", "user-phone", "text",  $userPhone, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Date Of Joining", "user-doj", "text",  $userDoj, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Salary", "user-sl", "text", "kshs " . $userSalary, array("readonly='readonly'", "  style='font-size: 17px;' "));
						$form->textBox("Account No.", "user-ac", "text", $userAccount, array("readonly='readonly'", "  style='font-size: 17px;' "));
						?>



						<div class='row'>
							<div class='col-md-6'>
								<label style="font-size:15px">Allowances</label><br>
								<div class='col-md-11'>
									<ul class="list-group" style="list-style-type:none;">
										<?php

										$con = Db::connect();
										$sql = "SELECT ea.*, a.allowance_name as aname FROM emp_allowances ea inner join allowances a on ea.a_id=a.a_id where ea.e_id= $empid ";
										$query = $con->prepare($sql);
										$query->execute();
										while ($data = Db::assoc($query)) :  ?>
											<li class="list-group-item" data-id="<?php echo $data['a_id'] ?>">
												<div class='row'>
													<div class='col-md-6'>
														<p style="font-size:15px">
															<?php echo $data['aname'];
															$aid = $data['sno'];
															?>
														</p>
													</div>
													<div class='col-md-4'>
														<p style="font-size:15px">
															<?php echo "Kshs " . $data['amount'] ?>
														</p>
													</div>
													<div class='col-md-2'>
														<button class="btn btn-danger" onclick="location.href='actions.php?action=remove-empalw&sno=<?php echo $aid; ?>&tkn=<?php echo $token; ?>'" type="button" id="del_ea_btn" style="height: 1px width: 1px"><i class="fa fa-trash"></i></button>
													</div>
												</div>

											</li>
										<?php endwhile; ?>
									</ul>
								</div>
								<button class="btn btn-primary" onclick="location.href='add-empallowance.php?token=<?php echo $token; ?>'" type="button" id="new_ea_btn">Add Allowance</button>
							</div>

							<div class='col-md-6'>
								<label style="font-size:15px">Deductions</label><br>
								<div class='col-md-11'>
									<ul class="list-group" style="list-style-type:none;">
										<?php

										$con = Db::connect();
										$sql = "SELECT ed.*, d.deduction_name as dname FROM emp_deductions ed inner join deductions d on ed.d_id=d.d_id where ed.e_id= $empid ";
										$query = $con->prepare($sql);
										$query->execute();
										while ($data = Db::assoc($query)) :  ?>

											<li class="list-group-item" data-id="<?php echo $data['d_id'] ?>">
												<div class='row'>
													<div class='col-md-6'>
														<p style="font-size:15px">
															<?php echo $data['dname'];
															$did = $data['sno']; ?>
														</p>
													</div>
													<div class='col-md-4'>
														<p style="font-size:15px">
															<?php echo "kshs" . $data['amount'] ?>
														</p>
													</div>
													<div class='col-md-2'>
														<button class="btn btn-danger" onclick="location.href='actions.php?action=remove-empded&sno=<?php echo $did; ?>&tkn=<?php echo $token; ?>'" type="button" id="del_empded_btn" style="height: 1px width: 1px"><i class="fa fa-trash"></i></button>
													</div>
												</div>

											</li>
										<?php endwhile; ?>
									</ul>
								</div>
								<button class="btn btn-primary" onclick="location.href='add-empdeduction.php?token=<?php echo $token; ?>'" type="button" id="new_ed_btn">Add deduction</button>
							</div>

						</div>

						<?php

						$form->close("");

						echo "</div>";  ?>
					</div><!-- end of the content area -->
				</div>

			</div><!-- col-md-8 -->
			<!-- this should be a sidebar -->

		</div>
	</div>
</body>

</html>