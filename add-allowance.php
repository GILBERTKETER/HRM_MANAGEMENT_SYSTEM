<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Allowances</title>
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
					<?php if(isset($_GET['a_id'])){ echo "Edit Allowances <small>Edit this allowance</small>"; } else { ?> Add Allowances  <?php } ?>  
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
						
					<div class='form-holder'>
						<?php 
							$aid = "" ;
							$allowanceId = ""; 
							$allowanceName = "";
							$allowancePercent = "";
							if(isset($_GET['aid'])){
								$aid = $_GET['aid'];
								$allowanceId = $_GET['aid'];
								$allowanceName = Allowance::get($allowanceId, "allowance_name"); 
								$allowancePercent = Allowance::get($allowanceId, "a_percentage"); 
							}
							if(isset($_POST['an'])){
								if($aid == ""){
								$allowanceId = $_POST['ai'];}
								else { $allowanceId = $allowanceId;}
								$allowanceName = $_POST['an'];
								$allowancePercent = $_POST['ap'];

								if($allowanceId == "" || $allowanceName == "" || $allowancePercent == ""){
									Messages::error("You must fill in all the fields"); 
								}
								else {
									Allowance::add($aid, $allowanceId, $allowanceName, $allowancePercent); 
								}
							}
								
								
							
							$form = new Form(3, "post");
							$form->init();
							if(isset($_GET['aid'] )){
								$form->textBox("Allowance Id", "ai", "text", "$allowanceId", array("disabled")); 
							} else {
								$form->textBox("Allowance Id", "ai", "text", "$allowanceId", "");
							}
							$form->textBox("Allowance Name", "an", "text", "$allowanceName", "");
							$form->textBox("Allowance Percentage", "ap", "text", "$allowancePercent", "");
							if(isset($_GET['aid'] )){
								$form->close("Save Allowance"); 
							} else {
								$form->close("Add Allowance"); 
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
