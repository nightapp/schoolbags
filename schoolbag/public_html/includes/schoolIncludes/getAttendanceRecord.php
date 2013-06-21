<?php
$justInclude=true;
include_once("../../config.php");
    function array_to_csv($array, $filename, $attachment = false, $headers = true) {
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w')or die("ERROR"."../../".$_SESSION["schoolPath"]."S/".$filename);
        } else {
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w')or die("ERROR"."../../".$_SESSION["schoolPath"]."S/".$filename);

        }
		echo $_SESSION["schoolPath"]."S/".$filename;
		$headerdone=!$headers;
		foreach($array as $row) {
			if(!$headerdone) fputcsv($fp, array_keys($row));
			$headerdone=true;
            fputcsv($fp, $row);
        }
        fclose($fp);
    }


    function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w')or die("ERROR"."../../".$_SESSION["schoolPath"]."S/".$filename);
        } else {
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w')or die("ERROR"."../../".$_SESSION["schoolPath"]."S/".$filename);
        }
			echo $_SESSION["schoolPath"]."S/".$filename;
        
        $result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
        if($headers) {
            // output header row (if at least one row exists)
            $row = mysql_fetch_assoc($result);
            if($row) {
				fputcsv($fp, array_keys($row));
                // reset pointer back to beginning
                mysql_data_seek($result, 0);
            }
        }
        while($row = mysql_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
date_default_timezone_set('Europe/Dublin');
$startTime=date("H:i:s");
$date=$datedmy=date("Y-m-d");
if(isset($_GET["date"]) && $_GET["date"]!=="") $date=$_GET["date"];

$date=strtotime($date);
$day=date("w",$date);
$schyear=date("Y",strtotime("-".$cutoffMonth." months",$date));

if(isset($_GET["recordType"])) $_GET["key"]=$_GET["recordType"];
if(!isset($_GET["key"])) $_GET["key"]="daysAbsent";
$start_date=$_GET["startDate"]?$_GET["startDate"]:"";
$end_date=$_GET["endDate"]?$_GET["endDate"]:"";
$year=$_GET["year"];
$class=$_GET["class"];
if(strpos($_GET["key"],"fullReport")!==false){
	
	include("functions/fullReport.php");
} elseif($_GET["key"]=="daysAbsent"){
	include("functions/daysAbsent.php");
} elseif($_GET["key"]=="dayReport"){
	include("functions/dayReport.php");
} elseif($_GET["key"]=="dayByDay"){
	include("functions/dayByDay.php");
}
    // output to file system
//    query_to_csv($db_conn, $sql, "test.csv", false);
?>
