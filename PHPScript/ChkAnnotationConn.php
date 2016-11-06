<?php

include("../config.php");
$con = new connect();
$connect = $con -> getConnection();

date_default_timezone_set('Asia/Bangkok'); 
$NowTimeStampLT = date("Y-m-d H:i:s");
	
if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));

if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
else $hidFileid = trim($_POST['hidFileid']);

if( !isset( $_POST['txtPageNo'] ) ) $txtPageNo = "";
else $txtPageNo = trim(strtoupper($_POST['txtPageNo']));

if( !isset( $_POST['hidUserStatus'] ) ) $txtUserStatus = "";
else $txtUserStatus = trim(strtoupper($_POST['hidUserStatus']));

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));

if( !isset( $_POST['isChecked'] ) ) $isChecked = "N";
else $isChecked = trim($_POST['isChecked']);

if( !isset( $_POST['txtNoteOwner'] ) ) $txtNoteOwner = "";
else $txtNoteOwner = trim(strtoupper($_POST['txtNoteOwner']));
	

//==============================================================================================
$selectSQL = "SELECT CHECKED FROM ANNOTATION_DISP "
			."WHERE PAGE_NO = '$txtPageNo' "
			."AND USERNAME = '$txtUsername' "
			."AND OWNER = '$txtNoteOwner' ";

$rsSelect = mysqli_query($connect,$selectSQL) 
or die("ChkAnnotationConn(): select annotation_disp error:: " . mysqli_error($connect));
	
if(mysqli_num_rows($rsSelect) > 0){
	$selectSQLAllChecked = "SELECT DISP.USERNAME, DISP.OWNER, USR.STATUS, DISP.DUPLICATED_DISPLAY, DISP.CHECKED "
				."FROM ANNOTATION_DISP AS DISP, USER_ACCOUNT AS USR "
				."WHERE PAGE_NO = '$txtPageNo' "
				."AND (DISP.OWNER = '$txtUsername' OR DISP.USERNAME = '$txtUsername') "
				."AND DISP.OWNER = USR.USERNAME ";
						
	$rsAllChecked = mysqli_query($connect,$selectSQLAllChecked) or die(mysqli_error($connect));
	
	while($data = mysqli_fetch_assoc($rsAllChecked)) {
		$strUsername = trim(strtoupper($data['USERNAME']));
		$strOwner = trim(strtoupper($data['OWNER']));
		$strUserStatus = trim(strtoupper($data['STATUS']));
		$strUserChecked = trim(strtoupper($data['CHECKED']));

		$updateSQLAnnotationDisp = "";
		
		if($txtUserStatus == "P" && 
		   strcasecmp($txtUsername, $strUsername) == 0 &&
		   strcasecmp($txtUsername, $strOwner) == 0 &&
		   strcasecmp($txtUsername, $txtNoteOwner) == 0 )
		{
			//echo "(1)" . "<br>";
			$updateSQLAnnotationDisp = "UPDATE ANNOTATION_DISP SET CHECKED='$isChecked', PRESENTER_CHECKED='$isChecked' "
									."WHERE USERNAME = '$txtUsername' "
								 	."AND PAGE_NO = '$txtPageNo' "
									."AND OWNER = '$txtUsername' ";
									print_r("1");
									
		}else if($txtUserStatus == "P" && 
		   		 strcasecmp($txtUsername, $strUsername) == 0 &&
				 strcasecmp($txtNoteOwner, $strOwner) == 0 )
		{
			//echo "(2)" . "<br>";
			$updateSQLAnnotationDisp = "UPDATE ANNOTATION_DISP SET CHECKED='$isChecked', PRESENTER_CHECKED='$isChecked' "
									."WHERE USERNAME = '$txtUsername' "
								 	."AND PAGE_NO = '$txtPageNo' "
									."AND OWNER = '$txtNoteOwner' ";
									print_r(" 2");
									
		}else if($txtUserStatus == "P" && 
		   		 strcasecmp($txtUsername, $strUsername) == 0 &&
				 strcasecmp($txtNoteOwner, $strOwner) != 0 )
		{
			//echo "(3)" . "<br>";
			$updateSQLAnnotationDisp = "UPDATE ANNOTATION_DISP SET PRESENTER_CHECKED='$isChecked' "
									/*."WHERE USERNAME = '$strUsername' "*/
									."WHERE USERNAME = '$txtNoteOwner' "
								 	."AND PAGE_NO = '$txtPageNo' "
									."AND OWNER = '$txtNoteOwner' ";
									print_r(" 3");		
																										
		}else if($txtUserStatus == "V" && 
		 		 strcasecmp($txtNoteOwner, $strOwner) == 0 &&
				 strcasecmp($txtUsername, $strUsername) == 0 )
		{
			//echo "(4)". "<br>";
			$updateSQLAnnotationDisp = "UPDATE ANNOTATION_DISP SET CHECKED='$isChecked' "
									."WHERE USERNAME = '$txtUsername' "
								 	."AND PAGE_NO = '$txtPageNo' "
									."AND OWNER = '$txtNoteOwner' ";
									print_r("4 jaa");
			
		}
		
		if($updateSQLAnnotationDisp != "")
		{	
			$rsUpdateAnnotationDisp = mysqli_query($connect,$updateSQLAnnotationDisp) 
			or die("AnnotationConn(): update annotation_disp error::" . mysqli_error($connect));
		}
		
	}//END while loop
}else{
	//Other User that not note owner
	$insertSQLAnnotationDisp = "INSERT INTO ANNOTATION_DISP "
	."(CHECKID, ROOM_NO, FILEID, USERNAME, USER_STATUS, OWNER, PAGE_NO, CHECKED, PRESENTER_CHECKED, DUPLICATED_DISPLAY) "
	."VALUES (NULL, '$txtRoomNo', '$hidFileid', '$txtUsername', '$txtUserStatus', '$txtNoteOwner', '$txtPageNo', '$isChecked', '$isChecked', 'Y' )";
	
	$rsInsertAnnotationDisp = mysqli_query($connect,$insertSQLAnnotationDisp) 
	or die("ChkAnnotationConn(): insert annotation_disp error::" . mysqli_error($connect));
	
}
//==============================================================================================
mysqli_close($connect);
	
?>



