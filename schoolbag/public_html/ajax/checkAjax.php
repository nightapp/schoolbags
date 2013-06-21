<?php
if(!isset($typesAllowed)){
	die("Access Denied Error 1");
} else if($typesAllowed!="external"){
	if($typesAllowed!="none"){
		if($typesAllowed!="all"){
			if(!in_array($_SESSION["userType"],$typesAllowed)){
				die("Access Denied Error 2");
			} else {
				
			}
		} else {
			if(!isset($_SESSION["userType"])){
				die("Access Denied Error 3");
			}
		}
	} else {
	
	}
}
if(isset($postVariablesRequired)){
	foreach($postVariablesRequired as $v){
		if(!isset($_POST[$v])){
			die("Error In Request POST[".$v."] is undefined");
		}
	}
}
if(isset($getVariablesRequired)){
	foreach($getVariablesRequired as $v){
		if(!isset($_GET[$v])){
			die("Error In Request GET[".$v."] is undefined");
		}
	}
}
?>