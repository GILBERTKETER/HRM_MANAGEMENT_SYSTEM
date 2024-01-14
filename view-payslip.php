<?php
require_once "importance.php";

if (!User::loggedIn()) {
	Config::redir("login.php");
}
?>

<html>

<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Payslip</title>
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
						<?php echo "Employee Payslip"; ?>
					</div>
					<!-- <div class='content-body'> -->
					<?php
					if (isset($_GET['eid'])) {
						$empid = $_GET['eid'];
					}

					if (isset($_GET['pid'])) {
						$ref = $_GET['pid'];
						$df = date("d M Y", strtotime(Payroll::get($ref, "date_from")));
						$dt = date("d M Y", strtotime(Payroll::get($ref, "date_to")));
					}

					$fName = User::getbyid($empid, "firstName");
					$sName = User::getbyid($empid, "secondName");
					$bsal = User::getbyid($empid, "salary");
					$accno = User::getbyid($empid, "account_no");
					$ename = $fName . " " . $sName;
					$role = User::getbyid($empid, "designation");
					$ab = Payroll::getes($empid, $ref, "absent");
					$totalw = Payroll::getes($empid, $ref, "allowance_amt");
					$totded = Payroll::getes($empid, $ref, "deduction_amt");
					$totsal = Payroll::getes($empid, $ref, "net_salary");
					$it = Payroll::getes($empid, $ref, "income_tax");
					$amtinwrds = AmountInWords("$totsal");

					?>
					<div class='content-bodyes'>
						<p align="right">
							<button class="btn btn-primary" onclick="printDiv('p')" type="button" id="print_btn"></span>Print</button>
						</p>
						<div class='contriner-fluid' id='p'>
							<div class='form-holder'>
								<div class='col-12'>
									<div class='row'>
										<div class='col-md-6'>
											<h5><b>Employee ID : <small style="font-size:17px"><?php echo $empid ?></small></b></h5>
											<h5><b>Employee Name : <small style="font-size:17px"><?php echo $ename ?></small></b></h5>
											<h5><b>Designation : <small style="font-size:17px"><?php echo $role ?></small></b></h5>
											<h5><b>Account No. : <small style="font-size:17px"><?php echo $accno ?></small></b></h5>
										</div>
										<div class='col-md-6'>
											<h5><b>Payroll Ref. : <small style="font-size:17px"><?php echo $ref ?></small></b></h5>
											<h5><b>Payroll Range : <small style="font-size:17px"><?php echo $df . " - " . $dt ?></small></b></h5>
											<h5><b>Mode of transfer : <small style="font-size:17px"><?php echo "Bank Tranfer" ?></small></b></h5>
											<h5><b>Absent : <small style="font-size:17px"><?php echo $ab . " days" ?></small></b></h5>
										</div>
									</div>

									<hr class="divider" style="border-color:black">
									<h5><b>Basic Salary &emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;: &emsp;&emsp;<small style="font-size:17px"><?php echo "kshs " . $bsal ?></small></b></h5>
									<hr class="divider" style="border-color:black">

									<div class="row">
										<div class="col-md-6">
											<h5><b>Allowances : </b></h5><br>
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
																<div class='col-md-8'>
																	<small style="font-size:15px">
																		<?php echo $data['aname'] ?>
																	</small>
																</div>
																<div class='col-md-4'>
																	<p style="font-size:15px">
																		<?php echo "kshs " . $data['amount'] ?>
																	</p>
																</div>
															</div>
														</li>
													<?php endwhile; ?>
												</ul>
												<h5><b><?php echo "Total Amount : &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;kshs" . $totalw ?></b></h5>
											</div>
										</div>

										<div class='col-md-6'>
											<h5><b>Deductions : </b></h5><br>
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
																<div class='col-md-8'>
																	<small style="font-size:15px">
																		<?php echo $data['dname'] ?>
																	</small>
																</div>
																<div class='col-md-4'>
																	<small style="font-size:15px">
																		<?php echo "kshs " . $data['amount'] ?>
																	</small>
																</div>
															</div>

														</li>
													<?php endwhile; ?>
												</ul>
												<h5><b><?php echo "Total Amount : &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;kshs " . $totded ?></b></h5>
												<!--echo str_repeat("&nbsp;", 60); -->
											</div>
										</div>
									</div>
									<hr class="divider" style="border-color:black">

									<h5><b>Income Tax &emsp;&emsp;&emsp;&emsp;&emsp;: &emsp;&emsp;<small style="font-size:17px"><?php echo "kshs" . $it ?></small></b></h5>

									<h5><b>Net Salary &emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;: &emsp;&emsp;<small style="font-size:17px"><?php echo "kshs " . $totsal ?></small></b></h5>

									<h5><b>Amount in words &emsp;&emsp;: &emsp;&emsp;<small style="font-size:17px"><?php echo $amtinwrds ?></small></b></h5>
									<!-- <h5><b>Mode of Transfer &emsp;&emsp;: &emsp;&emsp;<small style="font-size:17px"><?php echo "Bank Transfer" ?></small></b></h5> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function printDiv(divName) {
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

		}
	</script>
</body>

</html>


<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
	if ($amount == 0)
		return "---";
	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;

	// Check if there is any number after decimal
	$amt_hundred = null;
	$count_length = strlen($num);
	$x = 0;
	$string = array();
	$change_words = array(
		0 => '', 1 => 'One', 2 => 'Two',
		3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
		7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
		10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
		13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
		16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
		19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
		40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
		70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
	);
	$here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	while ($x < $count_length) {
		$get_divider = ($x == 2) ? 10 : 100;
		$amount = floor($num % $get_divider);
		$num = floor($num / $get_divider);
		$x += $get_divider == 10 ? 1 : 2;
		if ($amount) {
			$add_plural = (($counter = count($string)) && $amount > 9) ? null : null;
			$amt_hundred = ($counter == 1 && $string[0]) ? /*' and '*/ null : null;
			$string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
		} else $string[] = null;
	}
	$implode_to_shillings = implode('', array_reverse($string));
	$paise_first_digit = floor($amount_after_decimal / 10) * 10;
	$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$paise_first_digit] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' shillings' : '';
	return ($implode_to_shillings ? $implode_to_shillings . 'shillings ' : '') . $get_paise;
}
?>