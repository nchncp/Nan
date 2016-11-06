<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));

if( !isset( $_POST['txtPageNo'] ) ) $txtPageNo = "1";
else $txtPageNo = trim($_POST['txtPageNo']);

if( !isset( $_POST['hidUserStatus'] ) ) $txtUserStatus = "";
else $txtUserStatus = trim(strtoupper($_POST['hidUserStatus']));
	
if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));
	
if( !isset( $_POST['txtRoomFlag'] ) ) $txtRoomFlag = "";
else $txtRoomFlag = trim(strtoupper($_POST['txtRoomFlag']));

if( !isset( $_POST['txtRoomCode'] ) ) $txtRoomCode = "";
else $txtRoomCode = trim(strtoupper($_POST['txtRoomCode']));

if( !isset( $_POST['txtFilename'] ) ) $txtFilename = "";
else $txtFilename = trim($_POST['txtFilename']);

if( !isset( $_POST['txtUserid'] ) ) $txtUserid = "";
else $txtUserid = trim(strtoupper($_POST['txtUserid']));

if( !isset( $_POST['$txtRoomid'] ) ) $txtRoomid = "";
else $txtRoomid = trim(strtoupper($_POST['$txtRoomid']));

if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
else $hidFileid = trim($_POST['hidFileid']);

date_default_timezone_set('Asia/Bangkok'); 
$NowTimeStampLT = date("Y-m-d H:i:s");
$rows = 0;


//====================================================================================================
$selectPageNoSQL = "SELECT CURRENT_PAGE FROM status WHERE USERID='$txtUserid' AND FILEID='$hidFileid' ";
$rsSelectPageNo = mysqli_query($connect,$selectPageNoSQL) or die("SELECT ERROR: ". mysqli_error($connect));
$rows = mysqli_num_rows($rsSelectPageNo);
/*echo $selectPageNoSQL."<br>";
echo "row=" . $rows . "<br>";*/
if( $rows > 0 ){
	$data = mysqli_fetch_array($rsSelectPageNo);
	$tmpPage = $data['CURRENT_PAGE'];
	//echo "current page = " . $txtPageNo . ", db page = " . $tmpPage;
	if($tmpPage != 	$txtPageNo){
		$updateSQL = "UPDATE status SET CURRENT_PAGE='$txtPageNo'"
					."WHERE USERID='$txtUserid' AND FILEID='$hidFileid'";
		$rsUpdate = mysqli_query($connect,$updateSQL) or die("UPDATE ERROR: ". mysqli_error($connect));
	/*echo $updateSQL;*/
	}
		//echo "not update !!!";
}else{
	// else not found data in "PRESENTATION_FILE" table.
	/*$insertNewPageNoSQL = "INSERT INTO file_info "
	."(FILEID, USERID, ROOMID, FILE_NAME, FILE_UPD_TIMESTAMP, STATUS_FILE) VALUES "
	."(NULL, '$txtRoomNo', '$txtRoomFlag', '$txtRoomCode', '$txtFilename', '$txtPageNo', '$txtUsername', '$NowTimeStampLT')";
		
	$rsInsertPageNo = mysqli_query($connect,$insertNewPageNoSQL) or die("INSERT ERROR: ". mysqli_error($connect));
*/
	echo "can't update";
}
//=====================================================================================	
mysqli_close($connect);		
	
?>

<input type="hidden" id="hidPresentNowPageNo" name="hidPresentNowPageNo" value="<?= $txtPageNo ?>" />
