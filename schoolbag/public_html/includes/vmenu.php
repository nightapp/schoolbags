<?php 
if(!isset($_GET["debug"])) $_GET["debug"]=false;
$add="";
if(!isset($upOneLevel)) $upOneLevel=false;
	if($upOneLevel){
		$add="../";
	}	
if(!($_GET["debug"])){
	if($_SESSION["userType"]=="T"){
		include_once($add."includes/teacherIncludes/vmenu.php");
	} elseif($_SESSION["userType"]=="P"){
		include_once($add."includes/studentIncludes/vmenu.php");
	} else if($_SESSION["userType"]=="S"){
		include_once($add."includes/schoolIncludes/vmenu.php");
	} else if($_SESSION["userType"]=="A"){
		include_once($add."includes/adminIncludes/vmenu.php");
	}
}
?><div id='displayMenu'>Show Menu</div>