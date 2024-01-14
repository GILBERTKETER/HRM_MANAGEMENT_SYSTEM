<?php 

class Leave{
	public static function send($dol, $token, $msg) {
		$status = 0;
		$dateCreated = date("Y-m-d H:i:s"); 
		Db::insert("leaves", 
			array("date_of_leave", "from_id", "message", "status", "date_created"), 
			array($dol, $token, $msg, $status, $dateCreated)
		);
		Messages::success("Your leave request has been sent");
		return; 	
	}
	
	public static function loadsentleave($token){
		
			$query = Db::fetch("leaves", "", "from_id = ?", $token , "", "", "" );
			if(!Db::count($query)){
				Messages::info("You currently haven't send any leave");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Date of leave", "Reason", "Status"); 
			Table::header($header);
			while($data = Db::assoc($query) ){
				$dol = $data['date_of_leave']; 
				$msg = $data['message'];
				$status = $data['status'];
				if ($status == 0)
					Table::body(array($dol, $msg, "<span class='label label-warning'>Pending</span>"));
				elseif ($status == 1)
					Table::body(array($dol, $msg, "<span class='label label-success'>Accepted</span>"));
				else 
					Table::body(array($dol, $msg, "<span class='label label-danger'>Rejected</span>"));
			}
			//Table::create($header, $body);
			Table::close();
			echo "</div>"; 
			return; 
		
	}

	public static function loadreceivedleave(){
			$query = Db::fetch("leaves", "", "", "", "", "", "" );
			if(!Db::count($query)){
				Messages::info("You currently haven't received any leave");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Employee Id", "Employee Name", "Date of Leave", "Reason", "Status"); 
			$body = array();
			Table::header($header); 
			while($data = Db::assoc($query) ){
				$sno = $data['sno'];
				$tkn = $data['from_id'];
				$eid = User::get($tkn,"id");
				$ename = User::get($tkn,"firstName")." ".User::get($tkn,"secondName");
				$status = $data['status'];

				if($status == 0)
				{
				Table::body(array($eid, $ename, $data['date_of_leave'], $data['message'], "<center><button class='btn btn-success' onclick=\"location.href='actions.php?action=accept-lv&sno=$sno'\" type='button' id='st_btn'>Accept</button>   <button class='btn btn-danger' onclick=\"location.href='actions.php?action=reject-lv&sno=$sno'\" type='button' id='st_btn'>Reject</button></center>"));
				}
				else if($status == 1)
				{
					Table::body(array($eid, $ename, $data['date_of_leave'], $data['message'], "<span class='label label-success'>Accepted</span>"));
				}
				else
				{
					Table::body(array($eid, $ename, $data['date_of_leave'], $data['message'], "<span class='label label-danger'>Rejected</span>"));
				} 
			}
			
			Table::close();
			echo "</div>"; 
			return; 
	}

	public static function accept($sno){
		$dateReplied = date("Y-m-d H:i:s");
		Db::update("leaves",
		array("status", "date_replied"), 
		array(1, $dateReplied), 
		"sno = ? ", array($sno));
	}

	public static function reject($sno){
		$dateReplied = date("Y-m-d H:i:s");
		Db::update("leaves",
		array("status", "date_replied"), 
		array(2, $dateReplied), 
		"sno = ? ", array($sno));
	}
	
	
	/* public static function loadreceivedleave(){
			$query = Db::fetch("leaves", "", "", "", "", "", "" );
			if(!Db::count($query)){
				Messages::info("You currently have no received leaves");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Employee Id", "Employee Name", "Date of Leave", "Message", "Action"); 
			$body = array();
			Table::header($header); 
			while($data = Db::assoc($query) ){
				$sno = $data['sno'];
				$tkn = $data['from_id'];
				$eid = User::get($tkn,"id");
				$ename = User::get($tkn,"firstName")." ".User::get($tkn,"secondName");

				Table::body(array($eid, $ename, $data['date_of_leave'], $data['message'], "<center><button class='btn btn-success' onclick=\"location.href='actions.php?action=accept-lv&sno=$sno'\" type='button' id='st_btn'>Accept</button>  | <button class='btn btn-danger' onclick=\"location.href='actions.php?action=reject-lv&sno=$sno'\" type='button' id='st_btn'>Reject</button></center>")); 
			}
			
			Table::close();
			echo "</div>"; 
			return; 
	}
	
	public static function loadrepliedleave(){
			$query = Db::fetch("leaves", "", "", "", "", "", "" );
			if(!Db::count($query)){
				Messages::info("You haven't replied to any leaves as of now");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Employee Id", "Employee Name", "Date of Leave", "Message", "Status"); 
			$body = array();
			Table::header($header); 
			while($data = Db::assoc($query) ){
				$sno = $data['sno'];
				$tkn = $data['from_id'];
				$eid = User::get($tkn,"id");
				$ename = User::get($tkn,"firstName")." ".User::get($tkn,"secondName");
				$status = $data['status'];
				if ($status == 0)
					continue;
				elseif ($status == 1)
					$st = "Accepted";
				else 
					$st = "Rejected";

				Table::body(array($eid, $ename, $data['date_of_leave'], $data['message'], $st)); 
			}
			Table::close();
			echo "</div>"; 
			return; 
	}*/
			
}