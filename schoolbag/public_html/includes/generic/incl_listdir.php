<?php
function makeDisplay($s,$fromlayout=false,$skeep9999=false) {
	$keepS=$s."/description.txt";
	$tmp=explode("/",$s); 
	$s=$tmp[count($tmp)-1];
	$tmp=explode(".",$s);
	$checkDate=explode("-",$tmp[0]);
	if ((count($checkDate)==3) || (count($checkDate)==4)) {
		if ($skeep9999==false) {
			if (!(@is_file($keepS))) {
				$keepS=str_replace("9999",date("Y"),$keepS);
			}
		} else {
			if (!(@is_file($keepS))) {
				$keepS=str_replace(date("Y"),"9999",$keepS);
			}
		} 
		if ($checkDate[0]=="9999") {
			$checkDate[0]=date("Y");
		}
		if (@checkdate($checkDate[1],$checkDate[2],$checkDate[0])) {
//			echo $checkDate[1]."-".$checkDate[2]."-".$checkDate[0];
			$tmpDate=@date("l, F jS, Y",mktime(0,0,0,$checkDate[1],$checkDate[2],$checkDate[0]));
			if ($tmpDate) $tmp[0]=strtolower($tmpDate);
			if ($fromlayout && is_file($keepS)) {
				$fp=fopen($keepS,"r");
				$filecontent=explode("\n",strip_tags(fread($fp,filesize($keepS))));
				$tmp[0]="<b>".str_replace("9999",date("Y"),$tmp[0])."</b><br>".$filecontent[0];
				fclose($fp);
			}
		}
	}
	$tmp[0]=strtoupper($tmp[0]);
	return str_replace("_","&nbsp;",str_replace("_AND_","&nbsp;&amp;&nbsp;",$tmp[0]));
}

function makelargeref($f,$ext) {
	$t = explode(".",implode("/images/",explode("/",$f)));
	return $t[0].".".$ext;
}

function imgtoshow($d,$f) {
	if (!(is_dir($d."/images"))) return "";
	if (is_file(makelargeref($f,"jpg"))) return "jpg";
	if (is_file(makelargeref($f,"pdf"))) return "pdf";
	if (is_file(makelargeref($f,"doc"))) return "doc";
	return "";
}

function prelink($m,$d,$f) {
	$tmp=imgtoshow($d,$f);
	if ($tmp=="jpg") {
		echo "<a href='../showfullimage.php?img=".$m.makelargeref($f,$tmp)."'>";
	} elseif ($tmp!="") {
		echo "<a href='".makelargeref($f,$tmp)."'>";
	}
}

function postlink($d,$f) {
	if (imgtoshow($d,$f)!="") {
		echo "</a>";
	}
}
function invalidDirLevel($base) {
	$dirParts=explode("/",$base);
	$maxAllowed=floor(count($dirParts)/2);
	$maxAllowed=0;
	foreach ($dirParts as $d) {
		if ($d=="..") {
			$maxAllowed--;
		}
	}
	return ($maxAllowed<0);
}
$filelist = array(); 
$dirlist = array(); 
function recursive_listdir($base,$ext,$recurse) {
	global $filelist;
	global $dirlist;
   if (invalidDirLevel($base)) die();
   if(is_dir($base)) {
      $dh = opendir($base);
      while (false !== ($dir = readdir($dh))) { 
		 if ($dir !== '.' && $dir !== '..' && $dir !== '_notes') {
	         if (is_dir($base ."/". $dir)) { 
	            $subbase = $base ."/". $dir; 
	            $dirlist[] = $subbase;
			    if ($recurse) {
					$subdirlist = recursive_listdir($subbase,$ext,$recurse); 
		    	}
			    if ($ext=="") {
				    $filelist[]=$subbase;
			    }
	         } else {
				 if (is_file($base ."/". $dir)) {
					   $tmp=explode(".",$dir);
					   if ((strtolower($tmp[1])==$ext) && (count($tmp)==2)) {
							$f=realpath($base ."/". $dir);
							$lastModified = filemtime($f);
							while (isset($filelist[$lastModified])) $lastModified--;
						
							$filelist[$lastModified] = $base ."/". $dir; 
					   }
				 } 
			}
	   	} 
	}
      closedir($dh); 
   } else {
		return "0";
   }
   if ($ext==".") {
	   return $dirlist;  
   } else {
	   return $filelist;
   }
} 
function recursive_listdir_array($base,$ext,$recurse) {
	global $filelist;
	global $dirlist;
   if (invalidDirLevel($base)) die();
   if(is_dir($base)) {
      $dh = opendir($base);
      while (false !== ($dir = readdir($dh))) { 
		 if ($dir !== '.' && $dir !== '..' && $dir !== '_notes') {
	         if (is_dir($base ."/". $dir)) { 
	            $subbase = $base ."/". $dir; 
	            $dirlist[] = $subbase;
			    if ($recurse) {
					$subdirlist = recursive_listdir_array($subbase,$ext,$recurse); 
		    	}
	         } else {
				 if (is_file($base ."/". $dir)) {
					   $tmp=explode(".",$dir);
					   if (in_array(strtolower($tmp[1]),$ext) && (count($tmp)==2)) {
							$f=realpath($base ."/". $dir);
							$lastModified = filemtime($f);
							while (isset($filelist[$lastModified])) $lastModified--;
						
							$filelist[$lastModified] = $base ."/". $dir; 
					   }
				 } 
			}
	   	} 
	}
      closedir($dh); 
   } else {
		return "0";
   }
   if ($ext==".") {
	   return $dirlist;  
   } else {
	   return $filelist;
   }
} 
function dirsort($arr){
		$tmp=array();
		$l="";
		foreach($arr as $k=>$v){
			$d=dirname($v);
			$d=explode("/",str_replace($_SESSION["schoolPath"],"",$d));
			$l=$d[0];
			$d=array_slice($d,4);
			$d=implode("/",$d);
			if($_SESSION["userType"]=="P"){
				if($l=="P") $l="My Resources"; else $l="Teachers Resources";
				$d=$l."/".$d;
			}
			$d=trim($d,"/");
			$s=$d;
			$p=count(explode("/",$s));
			while($p>1){
				$s=dirname($s);
				if(!is_array($tmp[$s]))$tmp[$s]=array();
				$p=count(explode("/",$s));
			}
			if(!is_array($tmp[$d]))$tmp[$d]=array();
			$tmp[$d][]=$v; 
		}
		ksort($tmp);
		return $tmp;
}
?>