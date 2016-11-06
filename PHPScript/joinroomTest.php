<?php
session_start();
// default error
//$strMsg = "";

// default input parameter
date_default_timezone_set('Asia/Bangkok'); 
$NowTimeStampLT = date("Y-m-d H:i:s");

//if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
//else $txtUsername = trim(strtoupper($_POST['txtUsername'])); //set txtUsername is UpperCase

//if( !isset( $_POST['txtPassword'] ) ) $txtPassword = "";
//else $txtPassword =  trim($_POST['txtPassword']);


if( !isset( $_POST['password_room'] ) ) $txtRoomNo = "";
else $txtRoomNo =  trim(strtoupper($_POST['password_room']));
echo $txtRoomNo;

if( !isset( $_POST['room_name'] ) ) $txtroom = "";
else $txtroom = trim($_POST['room_name']);
echo $txtroom;

if( !isset( $_POST['hidFilename'] ) ) $txtFilename = "";
else $txtFilename = trim($_POST['hidFilename']);

//if( !isset( $_POST['selPresentationRoom'] ) ) $selPresentationRoom = "";
//else $selPresentationRoom = trim(strtoupper($_POST['selPresentationRoom']));

if($txtFilename == "") $UserStatus = "V";
else $UserStatus = "P";


if($txtRoomNo == "") $private_flag = "N";
else $private_flag = "Y";


if( !isset( $_POST['hidAction'] ) ) $strAction = "no action";
else $strAction =  trim($_POST['hidAction']);

include("../config.php");
print_r("test");
// get room ID
$sql = "SELECT ROOMID FROM room_info WHERE ROOM_NAME = 'privatesud'";
$testSql = mysql_query($sql) or die("Select roomID error: ". mysql_error());

$roomIDFileArr = mysql_fetch_array($testSql);
$selroomID = $roomIDFileArr[0];
print_r($selroomID);


// Check file name is valid
$selFileSQL = "SELECT F.FILENAME, F.PRIVATE_CODE, F.USERNAME, U.ONLINE_FLAG "
."FROM PRESENTATION_FILE AS F, USER_ACCOUNT AS U "
."WHERE F.ROOM='$txtRoomNo' "
."AND U.USERNAME = F.USERNAME "
."AND U.STATUS='P' ";

//echo ">>> " . $selFileSQL . "<br>";

$rsSelFile = mysql_query($selFileSQL) or die("Select PRESENTATION_FILE error: ". mysql_error());
$rowSelFile = mysql_num_rows($rsSelFile);
$dbRoomCode = "";
$dataFile = mysql_fetch_array($rsSelFile);

$dbRoomCode = $dataFile['PRIVATE_CODE'];
$Presenter =  $dataFile['USERNAME'];

if($UserStatus == "V"){
	$txtFilename =  $dataFile['FILENAME'];
}

if($rowSelFile > 0){
	if($UserStatus == "V"){
		if($txtRoomCode != "" && 
		   $dbRoomCode != "" && 
		   strcasecmp($txtRoomCode, $dbRoomCode) != 0
		){	
			$strMsg = "Invalid room code !, please retry room code.";
			
		}else if($dbRoomCode != "" && $txtRoomCode == ""){
			$strMsg = "This room is private, please enter room code.";
		}
		
	}// END if Viewer
	else if($UserStatus == "P"){
		if(strcasecmp($Presenter, $txtUsername) != 0){
			$strMsg = "Duplicated presentation room !";
		}		
	}// END else if Presenter
}//END if($rowSelFile > 0)

	
//=================================================================================================================	
if(strcasecmp($strAction, "click")==0 && $strMsg == "")
{
	
	$updUserOnlineSQL = "UPDATE USER_ACCOUNT SET ONLINE_FLAG = 'Y', STATUS = '$UserStatus' "
			.", USER_UPD_TIMESTAMP = '$NowTimeStampLT' "
			."WHERE USERNAME = '$txtUsername' "
			."AND PASSWORD = '$txtPassword' ";	
	$rsUpdateUserOnline = mysql_query($updUserOnlineSQL) or die('Update USER_ACCOUNT table error: ' . mysql_error());	

	$delFileSQL = "DELETE FROM PRESENTATION_FILE WHERE USERNAME = '$txtUsername' ";
	$rsDelFile = mysql_query($delFileSQL) or die("Delete PRESENTATION_FILE error: ". mysql_error());

	$selectNoteSQL = "SELECT ANNOTATION_TEXT FROM ANNOTATION WHERE ANNOTATION_OWNER = '$txtUsername' ";
	$rsSelNote = mysql_query($selectNoteSQL) or die("Select ANNOTATION error: ". mysql_error());
	while($data = mysql_fetch_assoc($rsSelNote)) {
		$pathNoteImg = "../images_annotation/".trim($data['ANNOTATION_TEXT']);
		if (file_exists($pathNoteImg)) {
			unlink($pathNoteImg); // delete file
		}
	}//END while loop to delete image file

	$delNoteSQL = "DELETE FROM ANNOTATION WHERE ANNOTATION_OWNER = '$txtUsername' ";
	$rsDelNote = mysql_query($delNoteSQL) or die("Delete ANNOTATION error: ". mysql_error());

	$delNoteDispSQL = "DELETE FROM ANNOTATION_DISP WHERE USERNAME = '$txtUsername' ";
	$rsDelNoteDisp = mysql_query($delNoteDispSQL) or die("Delete ANNOTATION_DISP error: ". mysql_error());
	
	//Insert
	$insertFileSQL = "INSERT INTO PRESENTATION_FILE "
	."( FILEID, ROOM, PRIVATE_STATUS, PRIVATE_CODE, FILENAME, CURRENT_PAGE, USERNAME, FILE_UPD_TIMESTAMP ) "
	."VALUES ( NULL, '$txtRoomNo', '$private_flag', '$txtRoomCode', '$txtFilename', '1', '$txtUsername', '$NowTimeStampLT' ) ";	
	$rsInsertFile = mysql_query($insertFileSQL) or die("Insert PRESENTATION_FILE error: ". mysql_error());
	// END check file name is valid
	
	$_SESSION['sess_username'] = $txtUsername; 
	$_SESSION['sess_email'] = $dbemail; 
	$_SESSION['sess_user_status'] = $UserStatus;
	$_SESSION['sess_room_flag'] = $private_flag;
	$_SESSION['sess_room_code'] = $txtRoomCode;
	$_SESSION['sess_room'] = $txtRoomNo;
	$_SESSION['sess_filename'] = $txtFilename;
	$strMsg = "finished";
	
}

//=================================================================================================================
mysql_close($objConnect);

?>

<input type="hidden" id="hidMsg" value="<?= $strMsg ?>" >
<input type="hidden" id="hidRoomCode" value="<?= $dbRoomCode ?>" >





