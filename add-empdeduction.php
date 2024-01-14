<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Emp_Deduction</title>
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
					Add Employee Deduction 
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
						
					<div class='form-holder'>
						<?php
							$sno=""; 
							$dname = ""; 
							//$amt = "";
							$token = "";
							$option=array();

							$query = Db::fetch("deductions", array("deduction_name"), "","","","","");
							$c=0;
							while($data = Db::assoc($query)){
								$dname=$data['deduction_name'];
								$option[$c] = $dname;
								$c++;
							}

							if(isset($_GET['token']))
								{$token = $_GET['token'];}

							if(isset($_POST['dn'])){
								$aname = $_POST['dn']; 
								//$amt = $_POST['amt']; 
								
								if($dname == "" /*|| $amt == ""*/){
									Messages::error("You must fill in all the fields"); 
								} else {
									Employee::empded($token, $dname/*, $amt*/);
								}
								
								
							}
							
							$form = new Form(3, "post");
							$form->init();

							$form->select("Deduction Name", "dn", "", $option);
							//$form->textBox("Amount", "amt", "text", "$amt", "");
							
							$form->close("Add Deduction"); 
						
							
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
