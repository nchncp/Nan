<?php

include("../config.php");
$con = new connect();
$connect = $con -> getConnection();
$strMsg = "";
date_default_timezone_set('Asia/Bangkok'); 
$NowTimeStampLT = date("Y-m-d H:i:s");

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));

if( !isset( $_POST['txtPassword'] ) ) $txtPassword = "";
$txtPassword = trim($_POST['txtPassword']);

if( !isset( $_POST['txtRePassword'] ) ) $txtRePassword = "";
$txtRePassword = trim($_POST['txtRePassword']);

if( !isset( $_POST['txtEmail'] ) ) $txtEmail = "";
$txtEmail = trim($_POST['txtEmail']);

//=================================================================================================================
// check E-mail duplicate in database
$SQLSelectEmail = "SELECT * FROM USER_ACCOUNT WHERE EMAIL='$txtEmail' ";
$rsEmail = mysqli_query($connect,$SQLSelectEmail) or die(mysqli_error($connect));

// check Username duplicate in database
$SQLSelectUsername = "SELECT * FROM USER_ACCOUNT WHERE USERNAME='$txtUsername' ";
$rsUsername = mysqli_query($connect,$SQLSelectUsername) or die(mysqli_error($connect));


if(mysqli_num_rows($rsEmail) > 0 && $txtEmail != ""){
	$strMsg = "Duplicate E-mail address !!!";
	
}else if(mysqli_num_rows($rsUsername) > 0){
	$strMsg = "Duplicate username !!!";
		
}else{
	// insert new user account in database
	$SQLInsertNewUser = "INSERT INTO USER_ACCOUNT (USERID, USERNAME, PASSWORD, EMAIL, STATUS, ONLINE_FLAG, USER_UPD_TIMESTAMP) 
	VALUES (NULL, '$txtUsername', '$txtPassword', '$txtEmail', 'V', 'N', '$NowTimeStampLT' ) ";
	
	$rsInsert = mysqli_query($connect,$SQLInsertNewUser) or die('INSERT ERROR : ' . mysqli_error($connect));
	$strMsg = "finished";	
}
//=================================================================================================================
mysqli_close($connect);

?>
<input type="hidden" id="hidMsg" value="<?= $strMsg ?>" >