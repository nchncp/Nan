<?php

	include("../config.php");
	$con = new connect();
	$connect = $con -> getConnection();

	date_default_timezone_set('Asia/Bangkok'); 
	$NowTimeStampLT = date("Y-m-d H:i:s");
	
	if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
	else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));
	
	if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
	else $txtUsername = trim(strtoupper($_POST['txtUsername']));
	
	if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
	else $hidFileid = trim($_POST['hidFileid']);

	if( !isset( $_POST['txtPageNo'] ) ) $txtPageNo = "";
	else $txtPageNo = trim($_POST['txtPageNo']);
	
	if( !isset( $_POST['hidUserStatus'] ) ) $txtUserStatus = "";
	else $txtUserStatus = trim(strtoupper($_POST['hidUserStatus']));
	
	if( !isset( $_POST['imgTime'] ) ) $imgTime = "";
	else $imgTime = trim($_POST['imgTime']);
	
	$img = $_POST["imgs"];
	
	$dt = round(microtime(true) * 1000); 
	$StartPath = "../images_annotation/";
	
//==========================================================================================
// decode binary to image file(.png)
$decoded = base64_decode($img);



$selectSQL = "SELECT ANNOTATION_TEXT FROM ANNOTATION "
			. "WHERE ROOM_NO = '$txtRoomNo' "
			. "AND FILEID = '$hidFileid' "
			. "AND PAGE_NO = '$txtPageNo' "
			. "AND ANNOTATION_OWNER = '$txtUsername' ";
$rsSelect =	mysqli_query($connect, $selectSQL) or die("SELECT ERROR: ". mysqli_error($connect));
/* mysqli_query($selectSQL) or die(mysqli_error());*/
if(mysqli_num_rows($rsSelect) > 0){
	$data = mysqli_fetch_assoc($rsSelect);
	
	
	$NoteImgNameOLD = $data['ANNOTATION_TEXT'];
	$PathImgNameOLD = $StartPath . $NoteImgNameOLD;
	$OldNoteImg = imagecreatefrompng("$PathImgNameOLD"); // base image
	
	$TmpNoteImgNameNew = "tmp" . $txtUsername . "_PageNo" . $txtPageNo . ".png";
	$PathTmpImgNameNEW = $StartPath . $TmpNoteImgNameNew;
	file_put_contents($PathTmpImgNameNEW,$decoded); // create temp image file

	$tmpNewNoteImg = imagecreatefrompng("$PathTmpImgNameNEW"); // top image
	list($width, $height) = getimagesize("$PathTmpImgNameNEW"); // Find image size of top image		

	//Make transparent image as the base(OldNoteImg) and merge(NewNoteImg)
	imagealphablending($OldNoteImg, true);
	imagesavealpha($OldNoteImg, true);  
	
	imagealphablending($tmpNewNoteImg, true); 
	imagesavealpha($tmpNewNoteImg, true);  
	
	//Merge image:: imagecopymerge($base, $top, move x-axis, move y-axis, 0,0, $newwidth, $newheight);    
	imagecopy($OldNoteImg, $tmpNewNoteImg, 0, 0, 0,0, $width, $height);
	header('Content-Type: image/png');
	$imgFile = imagepng($OldNoteImg, "$PathImgNameOLD"); //show&save image
	imagedestroy($OldNoteImg);  
	imagedestroy($tmpNewNoteImg);
	
	if (file_exists($PathTmpImgNameNEW)) {
		unlink($PathTmpImgNameNEW); // delete file
	}
	update($txtRoomNo, $hidFileid, $txtPageNo, $OldNoteImg, $txtUsername, $txtUserStatus, $NoteImgNameOLD, $imgTime);

}else{
	$NoteImgNameNew = $txtUsername . "_RoomName" . $txtRoomNo . "_FileID" . $hidFileid . "_PageNo" . $txtPageNo . ".png";
	$PathImgNameNEW = $StartPath . $NoteImgNameNew;
	file_put_contents($PathImgNameNEW,$decoded); // create new file
	
	$insertSQLAnnotation = "INSERT INTO ANNOTATION "
	."(ANNOTATIONID, ANNOTATION_TEXT, ROOM_NO, FILEID, PAGE_NO, ANNOTATION_OWNER, SOURCE_IMAGE, ANNOTATION_UPD_TIMESTAMP) "
	."VALUES (NULL, '$NoteImgNameNew', '$txtRoomNo', '$hidFileid', '$txtPageNo' , '$txtUsername','images_annotation/$NoteImgNameNew', '$NowTimeStampLT' )";
	$rsInsertAnnotation = mysqli_query($connect, $insertSQLAnnotation) or die("INSERT ERROR: ". mysqli_error($connect));
	/*$rsInsertAnnotation = mysqli_query($insertSQLAnnotation) 
	or die("AnnotationConn(): insert annotation error::" . mysqli_error());
	*/
	$PresenterChecked = "N";
	if($txtUserStatus == "P"){
		$PresenterChecked = "Y";
	}
	
	$insertSQLAnnotationDisp = "INSERT INTO ANNOTATION_DISP "
	."(CHECKID, ROOM_NO, FILEID, USERNAME, USER_STATUS, OWNER, PAGE_NO, CHECKED, PRESENTER_CHECKED) "
	."VALUES (NULL, '$txtRoomNo', '$hidFileid', '$txtUsername', '$txtUserStatus', '$txtUsername', '$txtPageNo' , 'Y', '$PresenterChecked' )";
	$rsInsertAnnotationDisp = mysqli_query($connect, $insertSQLAnnotationDisp) or die("INSERT ERROR: ". mysqli_error($connect));
	/*$rsInsertAnnotationDisp = mysqli_query($insertSQLAnnotationDisp) 
	or die("AnnotationConn(): insert annotation_disp error::" . mysqli_error());*/
	
	
}

function update($txtRoomNo
				, $hidFileid
				, $txtPageNo
				, $NoteImgNameNew
				, $txtUsername
				, $txtUserStatus
				, $NoteImgNameOLD
				, $imgTime) 
{
	$con = new connect();
$connect = $con -> getConnection();

	$selectSQLAllChecked = "SELECT USERNAME FROM ANNOTATION_DISP WHERE PAGE_NO = '$txtPageNo' ";
	$rsAllChecked = mysqli_query($connect, $selectSQLAllChecked) or die("INSERT ERROR: ". mysqli_error($connect));
	/*$rsAllChecked = mysqli_query($selectSQLAllChecked) or die(mysqli_error());*/
	while($data = mysqli_fetch_assoc($rsAllChecked)) {
		$Username = $data['USERNAME'];
		if($txtUserStatus == "P"){
			$updateSQLAnnotationDisp = "UPDATE ANNOTATION_DISP SET CHECKED='Y', PRESENTER_CHECKED='Y' ";	
		}else {
			$updateSQLAnnotationDisp = "UPDATE ANNOTATION_DISP SET CHECKED='Y' ";
		}
		$updateSQLAnnotationDisp .= "WHERE USERNAME = '$Username' "
								   ."AND PAGE_NO = '$txtPageNo' ";
		$rsUpdateAnnotationDisp = mysqli_query($connect, $updateSQLAnnotationDisp) or die("INSERT ERROR: ". mysqli_error($connect));
		/*$rsUpdateAnnotationDisp = mysqli_query($updateSQLAnnotationDisp) 
		or die("AnnotationConn(): update annotation_disp error::" . mysqli_error());*/
	}//END while loop
	
	$SrcImage = "images_annotation/" . $NoteImgNameOLD . "?time=" . $imgTime;
	
	$updateSQLFile = "UPDATE ANNOTATION  SET SOURCE_IMAGE='$SrcImage' "
	 			. "WHERE ROOM_NO = '$txtRoomNo' "
	 			. "AND FILEID = '$hidFileid' "
				. "AND PAGE_NO = '$txtPageNo' "
				. "AND PAGE_NO = '$txtPageNo' "
				. "AND ANNOTATION_OWNER = '$txtUsername' ";
	$rsUpdateFile = mysqli_query($connect, $updateSQLFile) or die("INSERT ERROR: ". mysqli_error($connect));
	/*$rsUpdateFile = mysqli_query($updateSQLFile) 
	or die("AnnotationConn(): update presentation_file error::" . mysqli_error());	*/		

}// END update()

mysqli_close($connect);
	
?>

