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
					return $number.'st year/class';
				break;
					case 2:
				return $number.'nd year/class';
					break;
				case 3:
					return $number.'rd year/class';
				default:
					return $number.'th year/class';
				break;
			}
		}
	}

$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND teacherID='".$_SESSION["userID"]."' AND schyear=".date("Y",strtotime("-".$cutoffMonth." months",time()));

$result=mysql_query($sql);
$valuesList="";
include("includes/getSubjects.php");
if(!isset($_GET["class"])) $selected=""; else $selected=$_GET["class"];
$first="";
$oneselected=false;
while($row=mysql_fetch_array($result)){
		$subject=$subjects[$row["subjectID"]];
		if($selected=="") $selected=$row["classID"];
		if($first=="") $first=$row["classID"];
?>
<option value="<?php echo $row["classID"];?>" <?php if($selected==$row["classID"]){ $oneselected=true; ?>selected="selected"<?php }?>><?php echo ordinalizeYear($row["year"])." , ".$subject." ".$row["extraRef"];?></option>
<?php
}
if($oneselected==false) $selected=$first;
if($changeGET==true) $_GET["class"]=$selected;
?>
</select>