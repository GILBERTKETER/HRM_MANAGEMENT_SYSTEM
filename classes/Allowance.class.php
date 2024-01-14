<?php 

class Allowance{
	public static function add($aid, $allowanceId, $allowanceName, $allowancePercent){ // adding allowance in list
		if($aid == "")
		{
			Db::insert(
				"allowances", 
				array("a_id", "allowance_name", "a_percentage"), 
				array($allowanceId, $allowanceName, $allowancePercent)
			);
			
			Messages::success("Allowance has been added successfully");
		} else {
			self::edit($aid, $allowanceName, $allowancePercent);
		}
	}

	
	public static function load(){ // display the types of allowances
		$query = Db::fetch("allowances", "", "", "", "a_id", "", "");
		if(Db::count($query)){
			echo"<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<tr>
						<td><center><strong>Allowance Id</strong></center></td>
						<td><center><strong>Allowance Name</strong></center></td>
						<td><center><strong>Allowance Percentage </strong></center></td>
						<td><center><strong>Action</strong></center></td>
					</tr>
			"; 
			
			while($data = Db::assoc($query)){ // fetching the table according to query
				$allowanceId = $data['a_id']; 
				$allowanceName = $data['allowance_name']; 
				$allowancePercent = $data['a_percentage'];
				
				echo "<tr>
						<td><center>$allowanceId</center></td>
						<td><center>$allowanceName</center></td>
						<td><center>$allowancePercent%</center></td>
						<td><center><a href='add-allowance.php?aid=$allowanceId'>Edit</a> | <a href='actions.php?action=remove-alw&aid=$allowanceId'>Delete</a></center></td>
					</tr>";
			}
			
			echo "</table></div>";
			return; 
		}
		
		Messages::info("No allowance found in the records");
	}
	

	public static function get($allowanceId, $field){  // fetch any row from allowance table by allowace id
		$query = Db::fetch("allowances", "$field", "a_id = ? ", $allowanceId, "", "", "" );
		$data = Db::num($query); 
		return $data[0]; 
	}

	public static function getid($aname, $field){  // fetch any row from allowance table by allowace name
		$query = Db::fetch("allowances", "$field", "allowance_name = ? ", $aname, "", "", "" );
		$data = Db::num($query); 
		return $data[0]; 
	}
	
	public static function delete($allowanceId){  //delete a particular allowance from the table by allowance id
		Db::delete("allowances", "a_id = ? ", $allowanceId);
	}
	
	public static function edit($aid, $allowanceName ,$allowancePercent){ // editing an allowance
		Db::update("allowances",
		array("allowance_name", "a_percentage"), 
		array($allowanceName, $allowancePercent), 
		"a_id = ? ", array($aid)); 
		
		Messages::success("You have edited this allowance <strong><a href='allowance-list.php'>View Edits</a></strong> ");
	}
}