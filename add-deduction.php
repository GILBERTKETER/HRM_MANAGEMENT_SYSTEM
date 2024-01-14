<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Deductions</title>
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
					<?php if(isset($_GET['a_id'])){ echo "Edit Deductions <small>Edit this deduction</small>"; } else { ?> Add Deductions <?php } ?>  
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
						
					<div class='form-holder'>
						<?php 
							$did="";
							$deductionId = ""; 
							$deductionName = ""; 
							$deductionPercent = "";
							if(isset($_GET['did'])){
								$did = $_GET['did'];
								$deductionId = $_GET['did'];
								$deductionName = Deduction::get($deductionId, "deduction_name");
								$deductionPercent = Deduction::get($deductionId, "d_percentage");  
							}
							if(isset($_POST['dn'])){
								if($did == ""){
								$deductionId = $_POST['di'];}
								else { $deductionId = $deductionId;} 
								$deductionName = $_POST['dn'];
								$deductionPercent = $_POST['dp'];

								if($deductionId == "" || $deductionName == "" ||$deductionPercent == ""){
									Messages::error("You must fill in all the fields"); 
								}
								else {
									Deduction::add($did, $deductionId, $deductionName, $deductionPercent); 
								}
							}
								
								
							
							$form = new Form(3, "post");
							$form->init();
							if(isset($_GET['did'] )){
								$form->textBox("Deduction Id", "di", "text", "$deductionId", array("disabled")); 
							} else { 
								$form->textBox("Deduction Id", "di", "text", "$deductionId", "");
							}
							$form->textBox("Deduction Name", "dn", "text", "$deductionName", "");
							$form->textBox("Deduction Percentage", "dp", "text", "$deductionPercent", "");
							if(isset($_GET['did'] )){
								$form->close("Save Deduction"); 
							} else {
								$form->close("Add Deduction"); 
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
