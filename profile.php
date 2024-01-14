<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Profile</title>
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
					<?php echo "User Details" ; ?> <small><?php echo $userRole; ?></small>
				</div>
				<div class='content-body'> 
					
					<?php $token = $_GET['token'];
						User::profile($token);  ?>
				</div><!-- end of the content area --> 
				</div> 
				
			</div><!-- col-md-8 --> 
			<!-- this should be a sidebar -->
				
		</div> 
	</div> 
</body>
</html>
