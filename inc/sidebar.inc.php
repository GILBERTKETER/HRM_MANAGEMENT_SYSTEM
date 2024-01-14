<?php 
if(User::loggedIn()){

	if($userStatus == 1){
	?> 
	<div class='sidebar'>
		<div class='sidebar-area'> 
			<div class='row' style='margin-bottom: 20px;'> 
				<div class='col-md-6'> 
					<div class='user-profile'> 
						<img src='images/admin-logo.png' class='img-responsive' style='max-height: 80px;' /> 
					</div>
				</div> 
				<div class='col-md-6'> 
					<div class='user-names'> 
						<?php echo "$userFirstName";  ?>
					</div>
					
					<div class='user-role'> 
						<?php echo "$userRole";  ?>
					</div>
				</div> 
			</div> 
			<ul class='sidebar-menu'>
				<li><a href='index.php'><img class='sidebar-menu-icon' src='images/ic_account_balance_wallet_white_24dp.png'  /> Dashboard</a></li>

				<li><a href='profile.php?token=<?php echo $userToken; ?>'><img class='sidebar-menu-icon' src='images/ic_account_box_white_24dp.png'  /> Profile</a></li>
				
				<!-- <li><a href='add-employees.php'><img class='sidebar-menu-icon' src='images/add_employee.png'  /> Add Employee</a></li> -->

				<li><a href='employees-record.php'><img class='sidebar-menu-icon' src='images/employee_list.png'  /> Employees' List</a></li>

				<li><a href='attendance-list.php'><img class='sidebar-menu-icon' src='images/ic_alarm_white_24dp.png'  /> Attendance</a></li>

				<li><a href='received-leave.php'><img class='sidebar-menu-icon' src='images/ic_alarm_white_24dp.png'  /> Leaves</a></li> 

				<li><a href='allowance-list.php'><img class='sidebar-menu-icon' src='images/list.png' width='20px' height='20px'  /> Allowances List</a></li>
				
				<li><a href='deduction-list.php'><img class='sidebar-menu-icon' src='images/list.png' width='20px' height='20px'  /> Deductions List</a></li>

				<li><a href='payroll.php'><img class='sidebar-menu-icon' src='images/payroll.png'  /> Payroll</a></li>
			
			</ul> 
		</div> 
	</div>
	<?php 
	// END OF THE ADMIN
	} else {
	?> 

	<div class='sidebar'>
		<div class='sidebar-area'> 
			<div class='row' style='margin-bottom: 20px;'> 
				<div class='col-md-6'> 
					<div class='user-profile'> 
						<img src='images/emp-logo.png' class='img-responsive' style='max-height: 80px;' /> 
					</div>
				</div> 
				<div class='col-md-6'> 
					<div class='user-names'> 
						<?php echo "$userFirstName";  ?>
					</div>
					
					<div class='user-role'> 
						<?php echo "$userRole";  ?>
					</div>
				</div> 
			</div> 
			<ul class='sidebar-menu'>
				<li><a href='index.php'><img class='sidebar-menu-icon' src='images/ic_account_balance_wallet_white_24dp.png'  /> Dashboard</a></li>

				<li><a href='profile.php?token=<?php echo $userToken; ?>'><img class='sidebar-menu-icon' src='images/ic_account_box_white_24dp.png'  /> Profile</a></li>

				<li><a href='attendance-list.php'><img class='sidebar-menu-icon' src='images/ic_alarm_white_24dp.png'  /> Attendance</a></li>

				<li><a href='sent-leave.php'><img class='sidebar-menu-icon' src='images/ic_alarm_white_24dp.png'  /> Leaves</a></li>

				<li><a href='view-empsal.php?eid=<?php echo $userId; ?>'><img class='sidebar-menu-icon' src='images/salarydetails.png'  /> Salary Details</a></li>
			</ul> 
		</div> 
	</div>

<?php
}

}