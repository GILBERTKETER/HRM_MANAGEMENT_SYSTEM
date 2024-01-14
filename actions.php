<?php 

require_once "importance.php"; 

if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if(isset($_POST['action'])){
	$action = $_POST['action'];
}

if($action == "remove-emp"){
	$emp = $_GET['token'];
	Employee::delete($emp);
	Config::redir("employees-record.php?message=Employee has been removed!"); 
}

if($action == "remove-alw"){
	$alw = $_GET['aid'];
	Allowance::delete($alw);
	Config::redir("allowance-list.php?message=Allowance has been removed!"); 
}

if($action == "remove-ded"){
	$ded = $_GET['did'];
	Deduction::delete($ded);
	Config::redir("deduction-list.php?message=Deduction has been removed!"); 
}

if($action == "remove-atd"){ //remove attendance
	$atd = $_GET['sno'];
	Attendance::delete($atd);
	Config::redir("attendance-list.php?message=Attendance has been removed!"); 
}

if($action == "remove-empalw"){ //remove emp allowance
	$empalw = $_GET['sno'];
	$tkn = $_GET['tkn'];
	Employee::empdelalw($empalw);
	Config::redir("view-employees.php?token=$tkn&message=Allowance has been removed!"); 
}

if($action == "remove-empded"){  //remove emp deduction
	$empded = $_GET['sno'];
	$tkn = $_GET['tkn'];
	Employee::empdelded($empded);
	Config::redir("view-employees.php?token=$tkn&message=Deduction has been removed!");
}

if($action == "remove-pr"){  // remove payroll
	$pr = $_GET['pid'];
	Payroll::delete($pr);
	Payroll::deletelist($pr);
	Config::redir("payroll.php?message=Payroll has been removed!"); 
}

if($action == "accept-lv"){
	$sno = $_GET['sno'];
	Leave::accept($sno);
	Config::redir("received-leave.php?"); 
}

if($action == "reject-lv"){
	$sno = $_GET['sno'];
	Leave::reject($sno);
	Config::redir("received-leave.php?"); 
}
