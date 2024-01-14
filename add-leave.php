<?php 
require_once "importance.php"; 

?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : New Leave</title>
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
					New Leave <small>Request a leave</small>
				</div>
				<div class='content-body'> 
					<div class='form-holder'><br /><br />
						<?php

						$ename = User::get($token,"firstName")." ".User::get($token,"secondName");
						$eid = $userId;
						$dol = date("d-m-Y");
						
							if(isset($_POST['e-date'])){
								$dol = $_POST['e-date']; 
								$msg = $_POST['e-msg'];
								
								if($dol == "" || $msg == ""){
									Messages::error("You must fill in all the fields");
								} else {
									Leave::send($dol, $token, $msg);
								}
							}
							
							$form = new Form(3, "post"); 
							$form->init(); 
							$form->textBox("Name", "e-name", "text", "$ename", array("readonly") );
							$form->textBox("Id", "e-id", "text", "$eid", array("readonly") );
							$form->textBox("Date of leave", "e-date", "date", "$dol", "");
							$form->textarea("Message", "e-msg", "" );
							$form->close("Send");
						?>
					</div>
				</div><!-- end of the content area --> 
				</div> 
				
			</div><!-- col-md-8 --> 

				
		</div> 
	</div> 
</body>
</html>
