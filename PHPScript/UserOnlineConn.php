<?php
	include("../config.php");
	$con = new connect();
	$connect = $con -> getConnection();

	$filename = $_POST['strFilename'];
	$strOnlineNo = "";
	$strOfflineNo = "";
	
	$SQLOnline = "SELECT DISTINCT USR.USERNAME FROM USER_ACCOUNT AS USR, PRESENTATION_FILE AS FILE WHERE FILE.FILENAME = '$filename' 
			AND USR.ONLINE_FLAG = 'Y' AND USR.USERNAME = FILE.USERNAME ";

			
	$rsOnline = mysqli_query($connect,$SQLOnline) or die(mysqli_error($connect));
	$strOnlineNo = mysqli_num_rows($rsOnline);
	
	
	mysqli_close($connect);


?>

<input type="hidden" id="hidOnlineNo" value="<?= $strOnlineNo ?>" >



