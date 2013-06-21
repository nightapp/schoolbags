<?php
/////Modified to accept all sorts eg "PDF" "pdf" "PdF"... (ie $ext is all lowercase and is using a temp variable and checking the .$ext lowercaseFilename
function getfilelist($dir,$ext) {
	$ext=strtolower($ext);
	$Files = array();
	$It =  opendir($dir);
	if (!$It) return $Files;
	while ($Filename = readdir($It)) {
		$lowerFilename=strtolower($Filename);
		if ($Filename == '.' || $Filename == '..') continue;
		if (($ext=="dir") && (strpos($Filename,"_notes")===false) && (is_dir($dir.$Filename))) {
			$f=realpath($dir . $Filename);
			$lastModified=filectime($f);
			while (isset($Files[$lastModified])) $lastModified--;
		} elseif (($ext=="DIR") || (strpos($lowerFilename,".".$ext)===false)) {
			continue;
		} else {
			$f=realpath($dir . $Filename);
//		echo $f;
			$lastModified = filemtime($f);
			if (isset($_GET["debug"])) {
//				echo date( 'Y-m-d H:m:s', $lastModified )." : ".$Filename."<br>";
			}
			while (isset($Files[$lastModified])) $lastModified--;
		}
	    $Files[$lastModified] = $dir .$Filename;
	}
	return $Files;
}
//getfilelist("../../information/1/P/1/ebooks/2","Pdf");
?>