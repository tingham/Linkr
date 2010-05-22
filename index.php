<?php
session_start();
include("system/system.php");

$lookup_id = $_GET['id'];

if($lookup_id != "")
{
	$redirect_to = db_retrieve($lookup_id);

	echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $redirect_to . "\" />";

	echo "<center><table border=\"0\" width=\"300\"><tr><td><fieldset><legend>Redirecting</legend>";
	echo "<center><img src=\"system/images/linkr_logo.jpg\" alt=\"logo\">";
	echo "<br /><br /><br /><strong>You are being redirected to: " . $redirect_to . ".</strong></fieldset></td></tr></table></center>";
}
else
{
	echo "<center><table border=\"0\" width=\"300\"><tr><td><fieldset><legend>Error</legend>";
	echo "<center><img src=\"system/images/linkr_logo.jpg\" alt=\"logo\">";
	echo "<br /><br /><br /><strong>You followed an invalid link.</strong></fieldset></td></tr></table></center>";
}
?>