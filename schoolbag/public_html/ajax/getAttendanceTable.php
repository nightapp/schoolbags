<?php
$justInclude=true;
include_once("../config.php");

$reasonsForAbsence=array();

$reasonsForAbsence["A"]="Illness";
$reasonsForAbsence["B"]="Urgent Family Reason";
$reasonsForAbsence["C"]="Expelled";
$reasonsForAbsence["D"]="Suspended";
$reasonsForAbsence["E"]="Other";
$reasonsForAbsence["F"]="Unexplained";
$reasonsForAbsence["G"]="Transfered To Another School";

$typesAllowed=array("S");
$postVariablesRequired=array("date");
include("checkAjax.php");
$date=date("Y-m-d");
if(isset($_POST["date"])) $date=$_POST["date"];

$select="<select class='reasonForAbsence' name='note'><option value='0'>Not absent</option>";
foreach($reasonsForAbsence as $k=>$r) $select.="<option value='$k'>$r</option>";

$select.="</select>";

$sql="SELECT *,SUM(present) AS 'Classes Attended',GROUP_CONCAT(notes SEPARATOR '') AS NOTE
FROM users,present
WHERE users.userID=studentID AND users.schoolID=".$_SESSION["schoolID"]." AND date='".$date."'
GROUP BY date,studentID
ORDER BY 'Classes Attended' ASC";
$result=mysql_query($sql);
?>
<b>Date: <?php echo date("jS F Y",strtotime($date));?></b><br>	
<form>
<table border="1" style="width:100%">
<tr><th>First Name</th><th>Last Name</th><th>Reason for absence</th></tr>
<?php
while($row=mysql_fetch_array($result)){
?>
<tr><td><?php echo $row["FirstName"];?></td><td><?php echo $row["LastName"];?></td><td rel="<?php echo $row["NOTE"];?>"><input type="hidden" name="studentID" class="studentID" value="<?php echo $row["userID"];?>" /><?php echo $select;?></td></tr>
<?php
}
?>
</table>
</form>