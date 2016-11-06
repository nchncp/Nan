<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();
$strMsg = "";
date_default_timezone_set('Asia/Bangkok');
$NowTimeStampLT = date("Y-m-d H:i:s");

if( !isset( $_POST['txtPassword'] ) ) $strNewPassword = "";
$strNewPassword = trim($_POST['txtPassword']);

if( !isset( $_POST['txtEmail'] ) ) $strEmail = "";
else $strEmail = trim($_POST['txtEmail']);

if( !isset( $_POST['txtUsername'] ) ) $strUsername = "";
else $strUsername = trim(strtoupper($_POST['txtUsername']));


//=================================================================================================================
if($strUsername != ""){
	
	// check Username duplicate in database
	$SQLSelect = "SELECT * FROM USER_ACCOUNT WHERE USERNAME='$strUsername' ";
	$rsUsername = mysqli_query($connect,$SQLSelect) or die(mysqli_error($connect));
	
	if(mysqli_num_rows($rsUsername) > 0){
		// update new user password in database
		$SQLUpdate = "UPDATE USER_ACCOUNT SET PASSWORD='$strNewPassword', USER_UPD_TIMESTAMP='$NowTimeStampLT' "
					."WHERE USERNAME='$strUsername' ";
		
		$rsUpdatedByUsername = mysqli_query($connect,$SQLUpdate) or die('UPDATE ERROR : ' . mysqli_error($connect));	
		if(!$rsUpdatedByUsername){
			$strMsg = "Error: cannot update data into database !!!";
		}else{
			$strMsg = "finished";
		}
	}else{
		$strMsg = "Not found username !!!";
	}
}else if($strEmail != ""){
	// check E-mail duplicate in database
	$SQLSelect = "SELECT * FROM USER_ACCOUNT WHERE EMAIL='$strEmail' ";
	$rsEmail = mysqli_query($connect,$SQLSelect) or die(mysqli_error($connect));
	
	if(mysqli_num_rows($rsEmail) > 0){
		// update new user password in database
		$SQLUpdate = "UPDATE USER_ACCOUNT SET PASSWORD='$strNewPassword', USER_UPD_TIMESTAMP='$nowUTCTimeStamp' 
					  WHERE EMAIL='$strEmail' ";
		
		$rsUpdatedByEmail = mysqli_query($connect,$SQLUpdate) or die('UPDATE ERROR : ' . mysqli_error($connect));	
		if(!$rsUpdatedByEmail){
			$strMsg = "Error: cannot update data into database !!!";
		}else{
			$strMsg = "finished";
		}
	}else{
		$strMsg = "Not found E-mail !!!";
	}
}
mysqli_close($connect);


?>
<input type="hidden" id="hidMsg" value="<?= $strMsg ?>" >