<?php 

class Deduction{
	public static function add($did, $deductionId, $deductionName, $deductionPercent){  // adding deduction in list
		if($did == "")
		{
			Db::insert(
				"deductions", 
				array("d_id", "deduction_name", "d_percentage"), 
				array($deductionId, $deductionName, $deductionPercent)
			);
			
			Messages::success("Deduction has been added successfully");
		} else {
			self::edit($did, $deductionName, $deductionPercent);
		}
	}

	
	public static function load(){ // display the types of deductions
		$query = Db::fetch("deductions", "", "", "", "d_id", "", "");
		if(Db::count($query)){
			echo"<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<tr>
						<td><center><strong>Deduction Id</strong></center></td>
						<td><center><strong>Deduction Name</strong></center></td>
						<td><center><strong>Deduction Percentage </strong></center></td>
						<td><center><strong>Action</strong></center></td>
					</tr>
			"; 
			
			while($data = Db::assoc($query)){ // fetching the table according to query
				$deductionId = $data['d_id']; 
				$deductionName = $data['deduction_name'];
				$deductionPercent = $data['d_percentage']; 
				
				echo "<tr>
						<td><center>$deductionId</center></td>
						<td><center>$deductionName</center></td>
						<td><center>$deductionPercent%</center></td> 
						<td><center><a href='add-deduction.php?did=$deductionId'>Edit</a> | <a href='actions.php?action=remove-ded&did=$deductionId'>Delete</a></center></td>
					</tr>";
			}
			
			echo "</table></div>";
			return; 
		}
		
		Messages::info("No deduction found in the records");
	}

	public static function get($deductionId, $field){ // fetch any row from deduction table by deduction id
		$query = Db::fetch("deductions", "$field", "d_id = ? ", $deductionId, "", "", "" );
		$data = Db::num($query); 
		return $data[0]; 
	}

	public static function getid($dname, $field){ // fetch any row from deduction table by deduction name
		$query = Db::fetch("deductions", "$field", "deduction_name = ? ", $dname, "", "", "" );
		$data = Db::num($query); 
		return $data[0]; 
	}
	
	public static function delete($deductionId){ //delete a particular deduction from the table by deduction id
		Db::delete("deductions", "d_id = ? ", $deductionId);
	}
	
	public static function edit($did, $deductionName, $deductionPercent){ // editing a deduction
		Db::update("deductions",
		array("deduction_name", "d_percentage"), 
		array($deductionName, $deductionPercent), 
		"d_id = ? ", array($did)); 
		
		Messages::success("You have edited this deduction <strong><a href='deduction-list.php'>View Edits</a></strong> ");
	}
}