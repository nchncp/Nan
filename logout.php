<!DOCTYPE HTML>

<html>
<head>
<meta charset="utf-8">
<title>logout</title>
</head>

<body>

<?php
//session_start(); 
if( !isset( $_GET['username'] ) ) $username = "";
else $username =  trim(strtoupper($_GET['username']));

date_default_timezone_set('Asia/Bangkok'); 
$NowTimeStampLT = date("Y-m-d H:i:s");

if($username != ""){
	/*include("PHPScript/dbconnect.php");*/
	include("config.php");
	$updateSQL = "UPDATE USER_ACCOUNT SET ONLINE_FLAG = 'N', USER_UPD_TIMESTAMP = '$NowTimeStampLT' "
				."WHERE USERNAME = '$username' ";	
	$rsUpdate = mysql_query($updateSQL) or die('Update USER_ACCOUNT table error : ' . mysql_error());
	mysql_close($objConnect);
}// End if txtUsername != ""
session_start();
session_destroy();
header("Location: index.php");

?>

</body>
</html>