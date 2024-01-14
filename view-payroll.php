<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Payroll Item</title>
	<?php require_once "inc/head.inc.php";  ?> 
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> 
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; 
			if(isset($_GET['pid']))
				{
					$ref = $_GET['pid'];
					$df = date("d M Y",strtotime(Payroll::get($ref,"date_from")));
					$dt = date("d M Y",strtotime(Payroll::get($ref,"date_to")));
				}

				?></div> <!-- this should be a sidebar --> 
			<div class='col-md-10'>
				<div class='content-area'> 
				<div class='content-header'>
					Payroll : <small style="font-size:20px"><?php echo $ref;?></small><br>
					Payroll Range : <small style="font-size:20px"><?php echo $df." - ".$dt;?></small>
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'> 
					<?php Payroll::loadlist($ref);?>
				</div><!-- end of the content area --> 
				</div> 
				
			</div><!-- col-md-7 --> 

			
				
		</div> 
	</div> 
</body>
</html>
