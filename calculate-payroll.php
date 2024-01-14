<?php
require_once "importance.php"; 
if(!User::loggedIn()){
	Config::redir("login.php"); 
}

$ref = "";
$empid = "";
$pr = 0;
$ab = 0;
$hrs_wrk = 0.0;
$sal = 0;
$ot = 0;
$tot_alw = 0;
$tot_ded = 0;
$tot_sal = 0;
$ded_arr = array();
$alw_arr = array();
$dateCreated = date("Y-m-d H:i:s");

if(isset($_GET['pid'])){
	$ref=$_GET['pid'];
}

$df = Payroll::get($ref, "date_from");
$dt = Payroll::get($ref, "date_to");

$dateFrom = date_create($df);
$DF = date_format($dateFrom, 'Y-m-d');

$dateTo = date_create($dt);
$dateTo->modify('+1 day');
$DT = date_format($dateTo, 'Y-m-d');

$diff = date_diff($dateFrom,$dateTo);
$days=$diff->format("%a"); // no of working days including sat and sun

$period = new DatePeriod($dateFrom, new DateInterval('P1D'), $dateTo);

foreach($period as $dt) {
    $curr = $dt->format('D');

    // substract if Saturday or Sunday
    if ($curr == 'Sat' || $curr == 'Sun') {
        $days--; // no of working days excluding sat and sun
    }

    /* (optional) 
    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
        $w_days--;
    }*/
}

$tot_hrs = $days*8;

$query = Db::fetch("users", "", "status = ? ", "2", "id", "", "");
if(Db::count($query)){
	while($data = Db::assoc($query)){
		$empid = $data['id'];
		$sal = $data['salary'];
		$bsal = $sal;
		$con = Db::connect();
		$sql2 = "SELECT a.* FROM attendance a where a.e_id=$empid and a.date between '$DF' and '$DT' "; // to get attendence of particular employee
		$query2 = $con->prepare($sql2);
		$query2->execute();

		$pr = Db::count($query2);
		$ab = $days - $pr;
		while($data2 = Db::assoc($query2)){
			$hrs_wrk = $hrs_wrk + $data2['hours'];
		}
		if($hrs_wrk > $tot_hrs)
		{
			$perhr = ($sal/$days)/8;
			$extra_hrs = $tot_hrs - $hrs_wrk;
			$ot = $extra_hrs*$perhr;
		}

		$sql3 = "SELECT ea.amount, a.allowance_name as aname FROM emp_allowances ea inner join allowances a on ea.a_id=a.a_id where ea.e_id= $empid"; //to get allowance details of particular employee
		$query3 = $con->prepare($sql3);
		$query3->execute();
		while($data3 = Db::assoc($query3)){
			$tot_alw = $tot_alw + $data3['amount'];
			$alw_arr[] = $data3;
		}
		if($ab>2) // paid leaves allowed is 2 days in month
		{
			$persal=$sal/$days;
			$sal=$persal*$pr;
		}

		$sql4 = "SELECT ed.amount, d.deduction_name as dname FROM emp_deductions ed inner join deductions d on ed.d_id=d.d_id where ed.e_id= $empid "; //to get deduction details of particular employee
		$query4 = $con->prepare($sql4);
		$query4->execute();
		while($data4 = Db::assoc($query4)){
			$tot_ded = $tot_ded + $data4['amount'];
			$ded_arr[] = $data4;
		}

		if($pr==0)  //if the employee in not present for even one day of the month
		{
			$ot=0;
			$tot_alw=0;
			$tot_ded=0;
			$tot_sal=0;
			continue;
		}

		$tot_sal = $sal + $tot_alw - $tot_ded + $ot;

		//calculation of income tax

		if($tot_sal<=20000)
			$it=0;
		else if($tot_sal>20000 && $tot_sal<=40000)
			$it=0.05*($tot_sal-20000);
		else if($tot_sal>40000 && $tot_sal<=60000)
			$it=(0.05*20000) + (0.10*($tot_sal-40000));
		else if($tot_sal>60000 && $tot_sal<=80000)
			$it=(0.05*20000) + (0.10*20000) + (0.15*($tot_sal-60000));
		else if($tot_sal>80000 && $tot_sal<=100000)
			$it=(0.05*20000) + (0.10*20000) + (0.15*20000) + (0.20*($tot_sal-80000));
		else
			$it=(0.05*20000) + (0.10*20000) + (0.15*20000) + (0.20*20000) + (0.25*($tot_sal-100000));

// end of income tax



		Db::insert("payroll_items", array("ref_no", "e_id", "present", "absent", "hrs_worked", "salary", "allowance_amt", "allowances", "deduction_amt", "deductions", "net_salary", "income_tax", "date_created"), array($ref, $empid, $pr, $ab, $hrs_wrk, $sal, $tot_alw, json_encode($alw_arr), $tot_ded, json_encode($ded_arr), $tot_sal, $it, $dateCreated));

		$tot_alw=0;
		$tot_ded=0;
		$hrs_wrk=0.0;
		$it=0;
		$ded_arr = array();
		$alw_arr = array();

	}
}
$set=1;
Db::update("payroll", array("status"), array($set), "ref_no = ?", array($ref));
Config::redir("payroll.php?message=Payroll has been calculated successfully");






