<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SYSTEM_NAME; ?> : Employees List</title>
	<?php require_once "inc/head.inc.php";  ?> 
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> 
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- this should be a sidebar --> 
			<div class='col-md-10'>
				<div class='content-area'> 
				<div class='content-header'> 
					Employees 
				</div>
				<?php require_once "inc/alerts.inc.php";  ?> 
				<div class='content-body'>
					<p align="right">
						<button class="btn btn-primary" onclick="location.href='add-employees.php'" type="button" id="new_atd_btn"><img src='images/add_employee.png'> Add Employee</button> 
					</p>
					<?php Employee::load(); ?><br>
					
				</div><!-- end of the content area --> 
				</div> 
				
			</div><!-- col-md-7 --> 

			
				
		</div> 
	</div> 
</body>
</html>
