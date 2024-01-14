<?php 

class Dashboard extends DashboardUi{ // using inheritance
	public static function deductions(){
		$query = Db::fetch("deductions", "", "", "", "", "",  "");
		return Db::count($query);
	}
	
	public static function allowances(){
		$query = Db::fetch("allowances", "", "", "", "", "",  "");
		return Db::count($query);
	}
	
	public static function employees(){ // no of employees to show in dash board
		$query = Db::fetch("users", "", "status = ? ", "2", "", "",  "");
		return Db::count($query);
	}

	public static function attendance($empid){ // no of employees to show in dash board
		$con = Db::connect();
		$sql = "SELECT a.* FROM attendance a where a.e_id=$empid order by date";
		$query = $con->prepare($sql);
		$query->execute();
		return Db::count($query);
	}

	public static function leaves($token){ // no of employees to show in dash board
		$query = Db::fetch("leaves", "", "from_id = ? AND status = ?", array($token, 1) , "", "", "" );
		return Db::count($query);
	}

	public static function admin_attendance(){ // no of employees present today to show in dash board
		$con = Db::connect();
		$today=date("Y-m-d");
		//$d=date_format($today,'Y-m-d');
		$sql = "SELECT a.* FROM attendance a where a.date like '$today' ";
		$query = $con->prepare($sql);
		$query->execute();
		return Db::count($query);
	}

	public static function admin_leaves(){ // no of employees on leave today to show in dash board
		$con = Db::connect();
		$today=date("Y-m-d");
		//$d=date_format($today,'Y-m-d');
		$sql = "SELECT l.* FROM leaves l where l.date_of_leave like '$today' and status=1 ";
		$query = $con->prepare($sql);
		$query->execute();
		return Db::count($query);
	}

	public static function payroll(){ // no of employees to show in dash board
		$query = Db::fetch("payroll", "", "", "", "", "",  "");
		return Db::count($query);
	}
	
}