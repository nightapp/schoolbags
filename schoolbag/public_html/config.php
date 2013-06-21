<?php 
if(session_id()==''){
	session_start();
}
//var_dump($_SESSION);
//die();
error_reporting(0);
$userTypePage['A']="adminPage.php";
$userTypePage['P']="studentPage.php";
$userTypePage['T']="teacherPage.php";
$userTypePage['S']="schoolPage.php";

$visibleNoticeBoards['P']="'A','P','T','S'";
$visibleNoticeBoards['T']="'A','T','S'";
$visibleNoticeBoards['S']="'A','S'";
$visibleNoticeBoards['A']="'A'";

$mailHeaders=array();
$mailHeaders["From"]="schoolbag@live.ie";
$mailHeaders["Bcc"]="schoolbag@live.ie";

$fullTextUserType['P']="Student";
$fullTextUserType['T']="Teacher";
$fullTextUserType['S']="School";
$fullTextUserType['A']="Administrator";

$website_description="schoolBag web System";
$website_title="Schoolbag.ie";
$siteAdministrator="schoolbag@live.ie";
//$siteAdministrator="damien@onsight.ie";

$bookFileTypes=array("1","pdf","doc","docx","odt","ppt","xls","xlsx","xlsm","jpg","html","htm","flipchart","jcw","fhp");	
if(empty($_FILES)) $bookFileTypes[]="exe";
if(!isset($justInclude)){
	$justInclude=false;
}

//echo $_SERVER['SERVER_NAME']; 
	//">" is there so it it will not return 0 only true or false
		$vusername = "u1135518_con";              //your username for you local system 
		$pwd ="007121qw"; 
		$host = "localhost";   
		$dbname = "db1135518_schoolbag";          
		$websiteURL="http://www.schoolbag.ie";
     //db name to be accessed 
	if(strpos(">".$_SERVER['SERVER_NAME'],"localhost")){
//	echo"J";
    $vusername = "root";              //your username for you local system 
    $pwd ="";                  //password to accecss mySQL 
    $host = "localhost";               //host is localhost - even for most web hosts 
    $dbname = "schoolbag";               //db name to be accessed 
	$websiteURL="http://localhost/newschoolBag";
	$siteAdministrator="damien@onsight.ie";
	}
    //connect to db 

    if (!($conn=mysql_connect($host, $vusername, $pwd)))  { 
        printf("We couldn't connect to the database right now!  ".mysql_error()); 
        exit; 
    } 
       $db=mysql_select_db($dbname,$conn) or die("Unable to connect to database!");  

if(isset($_POST["username"]) && $_POST["username"]!=""){
	if(isset($_SESSION["passwordOverRide"]) && isset($_POST["userType"])){
		$sql="SELECT * from users WHERE (userID='".$_POST["username"]."') AND schoolID='".$_SESSION["schoolID"]."' AND Type='".$_POST["userType"]."' LIMIT 1";
		
		unset($_SESSION["passwordOverRide"]);

	} else {
		$sql="SELECT * from users WHERE (userID='".$_POST["username"]."' OR email='".$_POST["username"]."') AND `password`='".$_POST["password"]."' LIMIT 1";
//		echo $sql;
//		die();
	}
	$result=mysql_query($sql);
	if(mysql_num_rows($result)==1){
		$row=mysql_fetch_array($result);
		$_SESSION["userID"]=$row["userID"];
		$_SESSION["schoolID"]=$row["schoolID"];
		$_SESSION["firstName"]=$row["FirstName"];
		$_SESSION["year"]=$row["year"];
		$_SESSION["userType"]=$row["Type"];
		if($row["Type"]=="T"){
			$_SESSION["displayName"]=$row["FirstName"]." ".$row["LastName"];
		} else {
			$_SESSION["displayName"]=$row["FirstName"];
		}
	} else {
			$_SESSION["invalidLogin"]=true;
	}
}
if(!$justInclude){
	if(!isset($_SESSION["userID"])){
		if((strpos($_SERVER['SCRIPT_NAME'],"index.php")===false)){
			header("Location:index.php");
			die();
		}
	} else {

			$schoolPath="information/".$_SESSION["schoolID"]."/";
			$_SESSION["schoolPath"]=$schoolPath;
			$sql = "SELECT * FROM `schoolinfo` WHERE `schoolID` = ".$_SESSION["schoolID"]." LIMIT 1";
	//		echo $sql;
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$schoolName=$row["SchoolName"];
			$schoolAddress=$row["Address"];
			$schoolInfo=$schoolName.", ".$schoolAddress;
			if($_SESSION["userType"]=="S"){
				$SAC=$row["AccessCode"];
				$TAC=$row["TeacherAccessCode"];
			}			
			
			
			
			if(in_array($_SESSION["userType"],array_keys($userTypePage))){
				$redirectTo=$userTypePage[$_SESSION["userType"]];
				if(strpos($_SERVER['SCRIPT_NAME'],basename($redirectTo))===false){
					header("Location:".$redirectTo);
				}
			} else {
				echo "Unknown user type";
			}
	}
}
$dispAs=$_SESSION["userID"];
if(isset($_GET["dispAs"]) && $_GET["dispAs"]!=$_SESSION["userID"]){
	$sql="SELECT * from users,friends WHERE type='T' AND schoolID='".$_SESSION['schoolID']."' AND ((users.userID=friends.TeacherTo && friends.TeacherFrom=".$_SESSION["userID"].") OR (users.userID=friends.TeacherFrom && friends.TeacherTo=".$_SESSION["userID"].")) AND Verified=1 AND users.userID=".$_GET["dispAs"];
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0){
		$dispAs=$_GET["dispAs"];
	}
}
function translate($str){
	return $str;
}
//echo $schoolPath;
$websiteTitle="schoolbag";
$cutoffMonth=7;
?>
