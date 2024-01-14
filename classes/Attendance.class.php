<?php 

class Attendance{
	public static function add($sno, $date, $ename, $timeIn, $timeOut){
		if($sno == ""){ // adding an attendance

			$con = Db::connect();
			$sql = "SELECT id, concat(u.firstName,' ', u.secondName) as ename FROM users u";
			$query = $con->prepare($sql);
			$query->execute();
			while($data = Db::assoc($query))
			{
				if($data['ename']==$ename)
				{
					$eid=$data['id'];break;
				}
			}

			$TI = new DateTime($timeIn);
			$TO = new DateTime($timeOut);
			$interval = $TI->diff($TO);
			$h= floatval($interval->format('%H'));
			$m= floatval($interval->format('%i'));
			$m=$m/60;
			$h=$h+$m;

 			$timeUpdated = date("Y-m-d H:i:s"); // getting present time
			Db::insert(
				"attendance", 
				array("e_id", "date", "time_in", "time_out", "hours", "time_updated"), 
				array($eid, $date, $timeIn, $timeOut, $h, $timeUpdated)
			);
			
			Messages::success("Attendance has been recorded successfully");
		} else {
			self::edit($sno, $date, $timeIn, $timeOut);
		}
	}
	
	public static function load(){ // displaying attendance list of all employees
		$con = Db::connect();
		
		// query to get attendance table and sort according to date & id

		$sql = "SELECT a.*, u.firstName, u.secondName FROM attendance a inner join users u on a.e_id=u.id order by a.date desc, e_id";
		$query = $con->prepare($sql);
		$query->execute();

		if(Db::count($query)){
			//table column names
			echo"<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<thead>
					<tr>
						<th><center><strong>Date</strong></center></th>
						<th><center><strong>Employee Id</strong></center></th>
						<th><center><strong>Employee Name</strong></center></th>
						<th><center><strong>Time In</strong></center></th> 
						<th><center><strong>Time Out</strong></center></th> 
						<th><center><strong>Hours Worked</strong></center></th>
						<th><center><strong>Action</strong></center></th>
					</tr>
					</thead>
			"; 
			
			while($data = Db::assoc($query)){
				$sno = $data['sno'];
				$date = date("d-m-Y",strtotime($data['date']));
				$eid = $data['e_id'];
				$firstName = $data['firstName']; 
				$secondName = $data['secondName'];
				$ename = $firstName." ".$secondName;  
				$timeIn = $data['time_in'];
				$timeOut = $data['time_out'];
				$h = $data['hours'];


				//table records
				echo "<tr>
						<td><center>$date</center></td>
						<td><center>$eid</center></td>
						<td><center>$ename</center></td> 
						<td><center>$timeIn</center></td> 
						<td><center>$timeOut</center></td>
						<td><center>$h</center></td>
						<td><center><a href='add-attendance.php?sno=$sno'>Edit</a> | <a href='actions.php?action=remove-atd&sno=$sno'>Delete</a></center></td>
					</tr>";
			}
			
			echo "</table></div>";
			return; 
		}
		
		Messages::info("No employee found in the attendance records");
	}

	public static function loademp($empid){ // displaying attendance list of particular employee
		$con = Db::connect();
		
		// query to get attendance table and sort according to date & id

		$sql = "SELECT a.* FROM attendance a where a.e_id=$empid order by date";
		$query = $con->prepare($sql);
		$query->execute();

		if(Db::count($query)){
			//table column names
			echo"<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<thead>
					<tr>
						<th><center><strong>Date</strong></center></th>
						<th><center><strong>Time In</strong></center></th> 
						<th><center><strong>Time Out</strong></center></th> 
						<th><center><strong>Hours Worked</strong></center></th>
					</tr>
					</thead>
			"; 
			
			while($data = Db::assoc($query)){
				$date = date("d-m-Y",strtotime($data['date'])); 
				$timeIn = $data['time_in'];
				$timeOut = $data['time_out'];
				$h = $data['hours'];


				//table records
				echo "<tr>
						<td><center>$date</center></td> 
						<td><center>$timeIn</center></td> 
						<td><center>$timeOut</center></td>
						<td><center>$h</center></td>
					</tr>";
			}
			
			echo "</table></div>";
			return; 
		}
		
		Messages::info("No employee found in the attendance records");
	}
	
	public static function get($sno, $field){ // get attendance details by sno
		$query = DB::fetch("attendance", "$field", "sno = ? ", $sno, "", "", "");
		$data = Db::num($query); 
		return $data[0];
	}

	public static function getname($eid, $field){ 
		$query = DB::fetch("users", "$field", "id = ? ", $eid, "", "", "");
		$data = Db::num($query); 
		return $data[0];
	}
	
	public static function delete($sno){ // deleting attendance
		Db::delete("attendance", "sno = ? ", $sno);
	}
	
	public static function edit($sno, $date, $timeIn, $timeOut){ // editing attendance if time or date is wrong
		$timeUpdated = date("Y-m-d H:i:s");
		Db::update("attendance",
		array("date", "time_in", "time_out", "time_updated"), 
		array($date, $timeIn, $timeOut, $timeUpdated), 
		"sno = ? ", array($sno)); 
		
		Messages::success("You have edited this attendance <strong><a href='attendance-list.php'>View Edits</a></strong> ");
	}
}