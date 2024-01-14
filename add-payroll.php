<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Payroll</title>
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
					Add Payroll 
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
						
					<div class='form-holder'>
						<?php 
							$dateFrom = date("d-m-Y");
							$dateTo = date("d-m-Y");

							if(isset($_POST['df'])){
								$dateFrom = $_POST['df'];
								$dateTo = $_POST['dt']; 
								
								if($dateFrom == "" || $dateTo == ""){
									Messages::error("You must fill in all the fields"); 
								}  else {
									Payroll::add($dateFrom, $dateTo);
								}
								
								
							}
							
							$form = new Form(3, "post");
							$form->init();

							$form->textBox("Date From", "df", "date", "$dateFrom", "");
							$form->textBox("Date To", "dt", "date", "$dateTo", "");
							$form->close("Add Payroll"); 
	
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
