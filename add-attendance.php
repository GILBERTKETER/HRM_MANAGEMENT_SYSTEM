<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Attendance</title>
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
					<?php if(isset($_GET['token'])){ echo "Edit Employee <small>Edit this employee</small>"; } else { ?> Add Attendance <?php } ?> 
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
						
					<div class='form-holder'>
						<?php 
							$sno = "";
							$date = date("d-m-Y");
							$eid = "";
							$firstName = "";
							$secondName = "";
							$ename = "";
							$timeIn = date("H:i:s");  
							$timeOut = date("H:i:s");
							$option=array();

							$query = Db::fetch("users", array("id","firstName","secondName"), "status = ? ", "2", "id", "", "");
							$c=0;
							while($data = Db::assoc($query)){
								$eid = $data['id'];
								$firstName = $data['firstName']; 
								$secondName = $data['secondName'];
								$ename = $firstName." ".$secondName;
								$option[$c] = $ename;
								$c++;

							}

							if(isset($_GET['sno'])){
								$sno = $_GET['sno'];
								$date = Attendance::get($sno, "date");
								$eid = Attendance::get($sno, "e_id");
								$firstName = Attendance::getname($eid, "firstName"); 
								$secondName = Attendance::getname($eid, "secondName");
								$timeIn = Attendance::get($sno, "time_in"); 
								$timeOut = Attendance::get($sno, "time_out");
							}
							if(isset($_POST['dt'])){
								if($sno == ""){ 
								$ename = $_POST['en']; }
								else { $ename = $ename; }
								$date = $_POST['dt'];
								$timeIn = $_POST['ti']; 
								$timeOut = $_POST['to'];
								
								if($ename == "" || $date == "" || $timeIn == "" || $timeOut == ""){
									Messages::error("You must fill in all the fields"); 
								}  else {
									Attendance::add($sno, $date, $ename, $timeIn, $timeOut);
								}
								
								
							}
							
							$form = new Form(3, "post");
							$form->init();
							if(isset($_GET['sno'])){
								$form->textBox("Employee Name","","text","$ename",array("disabled"));
							} else {
								$form->select("Employee Name", "en", "", $option);
							}
							$form->textBox("Date", "dt", "date", "$date", "");
							$form->textBox("Time In", "ti", "time", "$timeIn", "");
							$form->textBox("Time Out", "to", "time", "$timeOut", "");
							
							if(isset($_GET['token'] )){
								$form->close("Save Attendance"); 
							} else {
								$form->close("Add Attendance"); 
							}
	
						?> 
					</div> 
				</div><!-- end of the content area --> 
				</div> 
				
			</div><!-- col-md-7 --> 

			<div class='col-md-3'>
			</div> <!-- this should be a sidebar -->
				
		</div> 
	</div> 
</body>
</html>
