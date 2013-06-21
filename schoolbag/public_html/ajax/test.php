<?php 
include('../includes/mshell_mail.php');
$to = "liamfromlimerick@eircom.net";
$from = "info@onsight.ie";
//$cc = $siteAdministrator;
$cc="damien@onsight.ie";
// Create an instance of the mshell_mail class.
$Mail = new mshell_mail();
	foreach($mailHeaders as $k=>$v){
		$Mail->set_header($k, $v);
	}

$styleContent="";
$thtml="TEST EMAIL";
// Send an html message.
$Mail->clear_bodytext();
$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");
$Mail->sendmail($to, "Password Reminder for Liam from ");
echo "A password reminder has been sent.";
?>