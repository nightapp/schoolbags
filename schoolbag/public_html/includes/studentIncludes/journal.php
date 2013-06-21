<div class="middleDiv"><?php include("includes/calendar.php"); 
$iframePage="iframes/getJournal.php?date=".date("d|m|Y");
if(isset($_GET["iframePage"])){
	if(strpos($_GET["iframePage"],"./")!==false){
		die("Error loading Journal");
	} else {
		$iframePage="iframes/".$_GET["iframePage"].".php?".$_SERVER['QUERY_STRING'];
	}
}
?><iframe frameborder="0" src="<?php echo $iframePage;?>" name="dateIframe" scrolling="no" id="dateIframe" style="height:1000px;width:800px;display:inline;float:left"></iframe></div>