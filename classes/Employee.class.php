<?php

class Employee
{
	public static function add($token, $firstName, $secondName, $dob, $email, $phone, $img, $gender, $role, $doj, $sal, $accno, $password)
	{
		// Adding employees in the database
		if ($token == "") {
			$token = md5(time() . uniqid() . unixtojd() . $role . $email . $phone);  // Developing a token to identify the user uniquely

			// Hash the password
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			Db::insert(
				"users",
				array("firstName", "secondName", "date_of_birth", "email", "password", "token", "status", "phone", "profile", "gender", "designation", "date_of_joining", "salary", "account_no"),
				array($firstName, $secondName, $dob, $email, $hashedPassword, $token, 2, $phone, $img, $gender, $role, $doj, $sal, $accno)
			);

			Messages::success("Employee has been added successfully");
		} else {
			self::edit($token, $firstName, $secondName, $dob, $email, $phone, $role, $doj, $sal, $accno);
		}
	}


	public static function empalw($token, $aname/*, $amt*/)
	{
		//this function adds the allowance for particular employee

		// amt is commented so that if you dont want to give allowance in % you can give it in direct amount

		$eid = User::get($token, "id");
		$aid = Allowance::getid($aname, "a_id");
		$p = Allowance::getid($aname, "a_percentage");
		$sal = User::get($token, "salary");
		$amt = ($p / 100) * $sal;
		$datecreated = date("Y-m-d H:i:s");

		Db::insert(
			"emp_allowances",
			array("a_id", "e_id", "amount", "date_created"),
			array($aid, $eid, $amt, $datecreated)
		);

		Messages::success("Allowance has been added successfully");
		Config::redir("view-employees.php?token=$token");
	}

	public static function empded($token, $dname/*, $amt*/)
	{
		//this function adds the deduction for particular employee

		$eid = User::get($token, "id");
		$did = Deduction::getid($dname, "d_id");
		$p = Deduction::getid($aname, "d_percentage");
		$sal = User::get($token, "salary");
		$amt = ($p / 100) * $sal;
		$datecreated = date("Y-m-d H:i:s");

		Db::insert(
			"emp_deductions",
			array("d_id", "e_id", "amount", "date_created"),
			array($did, $eid, $amt, $datecreated)
		);

		Messages::success("Deduction has been added successfully");
		Config::redir("view-employees.php?token=$token");
	}

	public static function load()
	{
		// displays the employee list of the company
		$query = Db::fetch("users", "", "status = ? ", "2", "id", "", "");
		if (Db::count($query)) {
			echo "<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<thead>
					<tr>
						<th><strong>Photo</strong></th>
						<th><strong>Employee Id</strong></th>
						<th><strong>First Name</strong></th> 
						<th><strong>Last Name</strong></th> 
						<th><strong>Email</strong></th> 
						<th><strong>Phone</strong></th> 
						<th><strong>Gender</strong></th> 
						<th><strong>Role</strong></th>
						<th><strong>Action</strong></th>
					</tr>
					</thead>
			";

			while ($data = Db::assoc($query)) {
				$pic = $data['profile'];
				$img = (!empty($pic)) ? ($pic) : ("profile.png");
				$empid = $data['id'];
				$firstName = $data['firstName'];
				$secondName = $data['secondName'];
				$email = $data['email'];
				$phone = $data['phone'];
				$gender = $data['gender'];
				$role = $data['designation'];
				$token = $data['token'];

				echo "<tr>
						<td><img src='images/$img' width='30px' height='30px'></td>
						<td><center>$empid</center></td>
						<td>$firstName</td> 
						<td>$secondName</td> 
						<td>$email</td> 
						<td>$phone</td> 
						<td>$gender</td> 
						<td>$role</td> 
						<td><center><a href='view-employees.php?token=$token'>View</a>  | <a href='add-employees.php?token=$token'>Edit</a> | <a href='actions.php?action=remove-emp&token=$token'>Delete</a></center></td>
					</tr>";
			}

			echo "</table></div>";
			return;
		}

		Messages::info("No employee found in the records");
	}

	public static function delete($token)
	{
		// deleting an employee details from database
		Db::delete("users", "token = ? ", $token);
	}

	public static function empdelalw($sno)
	{
		// deleting particular employee allowance
		Db::delete("emp_allowances", "sno = ? ", $sno);
	}

	public static function empdelded($sno)
	{
		// deleting particular employee deduction
		Db::delete("emp_deductions", "sno = ? ", $sno);
	}

	public static function edit($token, $firstName, $secondName, $dob, $email, $phone, $role, $doj, $sal, $accno)
	{
		// editing employee details
		Db::update(
			"users",
			array("firstName", "secondName", "date_of_birth", "email", "phone", "designation", "date_of_joining", "salary", "account_no"),
			array($firstName, $secondName, $dob, $email, $phone, $role, $doj, $sal, $accno),
			"status = ? AND token = ? ",
			array(2, $token)
		);

		Messages::success("You have edited this employee <strong><a href='employees-record.php'>View Edits</a></strong> ");
	}
}
