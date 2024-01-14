<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Emp_Allowance</title>
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
					Add Employee Allowance 
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
						
					<div class='form-holder'>
						<?php
							$sno=""; 
							$aname = ""; 
							//$amt = "";
							$token = "";
							$option=array();

							$query = Db::fetch("allowances", array("allowance_name"), "","","","","");
							$c=0;
							while($data = Db::assoc($query)){
								$aname=$data['allowance_name'];
								$option[$c] = $aname;
								$c++;
							}

							if(isset($_GET['token']))
								{$token = $_GET['token'];}

							if(isset($_POST['an'])){
								$aname = $_POST['an']; 
								//$amt = $_POST['amt']; 
								
								if($aname == "" /*|| $amt == ""*/){
									Messages::error("You must fill in all the fields"); 
								} else {
									Employee::empalw($token, $aname/*, $amt*/);
								}
								
								
							}
							
							$form = new Form(3, "post");
							$form->init();

							$form->select("Allowance Name", "an", "", $option);
							//$form->textBox("Amount", "amt", "text", "$amt", "");
							
							$form->close("Add Allowance"); 
						
							
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
