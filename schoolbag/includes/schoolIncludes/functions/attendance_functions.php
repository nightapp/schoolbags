<?php
function array_to_csv($array, $filename, $attachment = false, $headers = true) {
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w')or die("ERROR"."../../".$_SESSION["schoolPath"]."S/".$filename);
        } else {
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w');

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
            $fp = fopen("../../".$_SESSION["schoolPath"]."S/".$filename, 'w');
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
?>