<table>
<thead>
</table>
<table border="1">
  <tr>
    <th rowspan="2" scope="col">Name</th>
    <th rowspan="2" scope="col">Address</th>
    <th rowspan="2" scope="col">Email</th>
    <th colspan="2" scope="col">Access Codes </th>
    <th rowspan="2" scope="col">Password</th>
  </tr>
  <tr><td>Student</td><td>Teacher</td></tr>
  <?php $sql="SELECT * FROM schoolinfo,users WHERE schoolinfo.schoolID=users.schoolID AND users.Type='S'";
//echo $sql;
$result=mysql_query($sql);
while($row = mysql_fetch_array($result)){
?>
<tr><td><?php echo $row["SchoolName"];?></td><td><?php echo $row["Address"];?></td><td><?php echo $row["email"];?></td><td><?php echo $row["AccessCode"];?></td><td><?php echo $row["TeacherAccessCode"];?></td><td><?php echo $row["password"];?></td></tr>
<?php } ?>
</table>
