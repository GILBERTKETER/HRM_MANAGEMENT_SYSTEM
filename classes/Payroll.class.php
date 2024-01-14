<?php

class Payroll
{
	public static function add($dateFrom, $dateTo)
	{
		$ref = date("ymd-Hs");
		$status = 0;
		$dateCreated = date("Y-m-d H:i:s");
		Db::insert(
			"payroll",
			array("ref_no", "date_from", "date_to", "status", "date_created"),
			array($ref, $dateFrom, $dateTo, $status, $dateCreated)
		);

		Config::redir("payroll.php?message=Payroll has been added successfully");
	}


	public static function load()
	{ // displays monthly payrolls calculated
		$query = Db::fetch("payroll", "", "", "", "sno", "", "");
		if (Db::count($query)) {
			echo "<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<tr>
						<td><center><strong>Reference No</strong></center></td>
						<td><center><strong>Date From</strong></center></td>
						<td><center><strong>Date To</strong></center></td>
						<td><center><strong>Status</strong></center></td>
						<td><center><strong>Action</strong></center></td>
					</tr>
			";

			while ($data = Db::assoc($query)) {
				$ref = $data['ref_no'];
				$dateFrom = date("d-m-Y", strtotime($data['date_from']));
				$dateTo = date("d-m-Y", strtotime($data['date_to']));
				if ($data['status'] == 0) {
					$status = "New";
					$v = "Calculate";
					$page = "calculate-payroll.php";
				} else {
					$status = "Calculated";
					$v = "View";
					$page = "view-payroll.php";
				}

				echo "<tr>
						<td><center>$ref</center></td>
						<td><center>$dateFrom</center></td>
						<td><center>$dateTo</center></td>
						<td><center><span class='badge badge-primary'>$status</span></center></td>
						<td><center><a href='$page?pid=$ref'>$v</a> | <a href='actions.php?action=remove-pr&pid=$ref'>Delete</a></center></td>
					</tr>";
			}

			echo "</table></div>";
			return;
		}

		Messages::info("No payrolls found in the record");
	}

	public static function loadlist($ref)
	{ // displays the list of employees payroll
		$query = Db::fetch("payroll_items", "", "ref_no = ?", "$ref", "sno", "", "");
		if (Db::count($query)) {
			echo "<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<tr>
						<td><center><strong>Employee Id</strong></center></td>
						<td><center><strong>Employee Name</strong></center></td>
						<td><center><strong>Hours Worked</strong></center></td>
						<td><center><strong>Absent</strong></center></td>
						<td><center><strong>Total Allowance</strong></center></td>
						<td><center><strong>Total Deduction</strong></center></td>
						<td><center><strong>Net Salary</strong></center></td>
						<td><center><strong>Action</strong></center></td>
					</tr>
			";

			while ($data = Db::assoc($query)) {
				$empid = $data['e_id'];
				$fName = User::getbyid($empid, "firstName");
				$sName = User::getbyid($empid, "secondName");
				$ename = $fName . " " . $sName;
				$ab = $data['absent'];
				$hr = $data['hrs_worked'];
				$totalw = $data['allowance_amt'];
				$totded = $data['deduction_amt'];
				$totsal = $data['net_salary'];

				echo "<tr>
						<td><center>$empid</center></td>
						<td><center>$ename</center></td>
						<td><center>$hr</center></td>
						<td><center>$ab</center></td>
						<td><center>$totalw</center></td>
						<td><center>$totded</center></td>
						<td><center>$totsal</center></td>
						<td><center><button class='btn btn-primary' onclick=\"location.href='view-payslip.php?eid=$empid&pid=$ref'\" type='button' id='view_btn'><i class='fa fa-eye'></i> View</button>  </center></td>
					</tr>";
			}

			echo "</table></div>";
			return;
		}

		Messages::info("No payrolls found in the record");
	}

	public static function get($ref, $field)
	{
		$query = Db::fetch("payroll", "$field", "ref_no = ? ", $ref, "", "", "");
		$data = Db::num($query);
		return $data[0];
	}

	public static function getlist($ref, $field)
	{
		$query = Db::fetch("payroll_items", "$field", "ref_no = ? ", $ref, "", "", "");
		$data = Db::num($query);
		return $data[0];
	}

	public static function getes($eid, $ref, $field)
	{
		$query = Db::fetch("payroll_items", "$field", "e_id = ? AND ref_no = ?", array($eid, $ref), "", "", "");
		if (DB::count($query) > 0) {
			$data = Db::num($query);
			return $data[0];
		} else {
			return 0.0;
		}
	}

	public static function delete($ref)
	{ // deletes the payroll
		Db::delete("payroll", "ref_no = ? ", $ref);
	}

	public static function deletelist($ref)
	{ // if we delete a payroll of month then the payslips generated will also get deleted
		Db::delete("payroll_items", "ref_no = ? ", $ref);
	}

	public static function load_es()
	{ // displays list of payslips to particular employee
		$query = Db::fetch("payroll", "", "", "", "sno", "", "");
		if (Db::count($query)) {
			echo "<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<tr>
						<td><center><strong>Reference No</strong></center></td>
						<td><center><strong>Date From</strong></center></td>
						<td><center><strong>Date To</strong></center></td>
						<td><center><strong>Status</strong></center></td>
						<td><center><strong>Action</strong></center></td>
					</tr>
			";

			if (isset($_GET['eid'])) {
				$empid = $_GET['eid'];
			}

			while ($data = Db::assoc($query)) {
				$ref = $data['ref_no'];
				$dateFrom = date("d-m-Y", strtotime($data['date_from']));
				$dateTo = date("d-m-Y", strtotime($data['date_to']));
				if ($data['status'] == 0) {
					$status = "New";
					$v = "-";
					$page = "";
				} else {
					$status = "Calculated";
					$v = "View";
					$page = "view-payslip.php";
				}

				echo "<tr>
						<td><center>$ref</center></td>
						<td><center>$dateFrom</center></td>
						<td><center>$dateTo</center></td>
						<td><center><span class='badge badge-primary'>$status</span></center></td>
						<td><center><a href='$page?eid=$empid&pid=$ref'>$v</a></center></td>
					</tr>";
			}

			echo "</table></div>";
			return;
		}

		Messages::info("No payrolls found in the record");
	}
}



//