<select id="classSelect" name="SubSubFolder">
<?php
if(!isset($changeGET)) $changeGET=false;
	function ordinalizeYear($number) {
		if (in_array(($number % 100),range(11,13))){
			return $number.'th';
		} else if($number==-1){
			return "Juniors";
		} else if($number==0){
			return "Seniors";
		} else {
			switch (($number % 10)) {
				case 1:
					return $number.'st';
				break;
					case 2:
				return $number.'nd';
					break;
				case 3:
					return $number.'rd';
				default:
					return $number.'th';
				break;
			}
		}
	}

$sql="SELECT * from classlistofusers WHERE schoolID='".$_SESSION["schoolID"]."' AND studentID='".$_SESSION["userID"]."'";

$result=mysql_query($sql);
$valuesList="";
if(mysql_num_rows($result)>0){
	$valuesList=" AND classID IN (";
	while($row=mysql_fetch_array($result)){
			if(strlen($valuesList)>17) $valuesList.=", ";
			$valuesList.="'".$row["classID"]."'";
	}
	$valuesList.=")";
}

$sql2="SELECT * from classlist WHERE schoolID=".$_SESSION["schoolID"].$valuesList;
//echo $sql2;
$result2=mysql_query($sql2);
include_once("includes/getSubjects.php");
if(!isset($_GET["class"])) $selected=""; else $selected=$_GET["class"];
$first="";
$oneselected=false;
?><?php
while($row2=mysql_fetch_array($result2)){
		$subject=$subjects[$row2["subjectID"]];
		if($selected=="") $selected=$row2["classID"];
		if($first=="") $first=$row2["classID"];
?>
<option value="<?php echo $row2["classID"];?>" <?php if($selected==$row2["classID"]){ $oneselected=true; ?>selected="selected"<?php }?>><?php echo ordinalizeYear($row2["year"])." year, ".$subject." ".$row2["extraRef"];?></option>
<?php
}
if($oneselected==false) $selected=$first;
if($changeGET==true) $_GET["class"]=$selected;
?>
</select>