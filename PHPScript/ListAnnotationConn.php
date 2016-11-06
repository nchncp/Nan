<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();
if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));

if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
else $hidFileid = trim($_POST['hidFileid']);

if( !isset( $_POST['txtPageNo'] ) ) $txtPageNo = "1";
else $txtPageNo = trim($_POST['txtPageNo']);

if( !isset( $_POST['hidUserStatus'] ) ) $txtUserStatus = "";
else $txtUserStatus = trim(strtoupper($_POST['hidUserStatus']));

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));


//==========================================================================================

$SQL = "SELECT DISTINCT DISP.USERNAME, DISP.USER_STATUS, DISP.OWNER, DISP.PAGE_NO, DISP.CHECKED, DISP.PRESENTER_CHECKED, DISP.DUPLICATED_DISPLAY, A.ANNOTATION_TEXT, A.ROOM_NO, A.SOURCE_IMAGE, A.ANNOTATION_UPD_TIMESTAMP "
."FROM ANNOTATION_DISP AS DISP, ANNOTATION AS A "
."WHERE  DISP.PAGE_NO = A.PAGE_NO "
."AND DISP.PAGE_NO = '$txtPageNo' "
."AND A.ROOM_NO = '$txtRoomNo' "
."AND A.FILEID = '$hidFileid' "
."AND DISP.OWNER = A.ANNOTATION_OWNER "
."ORDER BY A.ANNOTATION_UPD_TIMESTAMP DESC ";

$result = mysqli_query($connect,$SQL) 
or die("ListAnnotationConn.php()-- error: " . mysqli_error($connect));

$rows = mysqli_num_rows($result);
$strListAnnotation = "";

$arrOwnerDup = array();
$arrPresenterDup = array();
$strCheckBox = "";

while ($data = mysqli_fetch_assoc($result)) {
	$strAnnotationOwner = $data['OWNER'];
	$strUsername = trim(strtoupper($data['USERNAME']));
	$DuplicatedFlag = $data["DUPLICATED_DISPLAY"];
	$strUserStatus = trim(strtoupper($data['USER_STATUS']));
	
	if($DuplicatedFlag == "Y" && strcasecmp($txtUsername, $strUsername) == 0){
		array_push($arrOwnerDup, $strAnnotationOwner);							
	}
	if(	$DuplicatedFlag == "Y" && 
		$strUserStatus == "P" &&
		strcasecmp($txtUsername, $strUsername) == 0)
	{
		array_push($arrPresenterDup, $strAnnotationOwner);							
	}
}// END while

//==========================================================================================
//Clear data
if($rows > 0){
	mysqli_data_seek ($result, 0);
}
//==========================================================================================
while ($data = mysqli_fetch_assoc($result)) {
	$strUserStatus = trim(strtoupper($data['USER_STATUS']));
	$strUsername = trim(strtoupper($data['USERNAME']));
	$strAnnotationOwner = trim(strtoupper($data['OWNER']));
	$strTimeStamp = $data['ANNOTATION_UPD_TIMESTAMP'];
	$strAnnotationTxt = trim($data['ANNOTATION_TEXT']);
	$strPresenterChecked = $data['PRESENTER_CHECKED'];
	$strOwnerChecked = $data['CHECKED'];
	$DuplicatedFlag = $data["DUPLICATED_DISPLAY"];

	$listCheckBox="";
	if($DuplicatedFlag == "Y"){	//2
		// DUPLICATED_DISPLAY = 'Y' => Note's owner or Presenter
		if( strcasecmp($txtUsername, $strUsername) == 0)
		{
			$listCheckBox = setAnnotationList($txtUserStatus
						, $strPresenterChecked
						, $strOwnerChecked
						, $strAnnotationTxt
						, $strAnnotationOwner
						, $strListAnnotation
						, $strUsername
						, $txtUsername
						, $strTimeStamp );
		
		}// END if USERNAME(OWNER) = USERNAME(CHECKED)
		
	}//END if DUPLICATED_DISPLAY = 'Y'
	else{
		// DUPLICATED_DISPLAY = 'N' => Note's owner or Presenter
		// owner is duplicated
		if(  (
				(
				 ($txtUserStatus == "V" && 
				  $strUserStatus == "V" && 
				  strcasecmp($txtUsername, $strUsername) == 0 && 
				  strcasecmp($txtUsername, $strAnnotationOwner) == 0 ) 
				  ||
				 (
				  $strUserStatus == "P" && 
				  strcasecmp($strUsername, $strAnnotationOwner) == 0 )
			  	) 
			 	&& 
			 	in_array($strAnnotationOwner, $arrOwnerDup) == false
			 ) 
			 ||
			 ($txtUserStatus == "P" && 
			  $strUserStatus == "V" &&
			  strcasecmp($strUsername, $strAnnotationOwner) == 0 &&
			  in_array($strAnnotationOwner, $arrPresenterDup) == false
			 )
			  /*
			 ||
			 ($txtUserStatus == "P" && 
			  $strUserStatus == "V" &&
			  strcasecmp($strUsername, $strAnnotationOwner) == 0
			 )
			 */
		  )
		{
			$listCheckBox = setAnnotationList($txtUserStatus
					, $strPresenterChecked
					, $strOwnerChecked
					, $strAnnotationTxt
					, $strAnnotationOwner
					, $strListAnnotation
					, $strUsername
					, $txtUsername
					, $strTimeStamp );
		}
		
	}//END if DUPLICATED_DISPLAY = 'N'

	if($listCheckBox != ""){
		$strListAnnotation .= $listCheckBox;
	}//END if $listCheckBox != ""
	
}// END while
//==========================================================================================

function setAnnotationList($txtUserStatus
						, $strPresenterChecked
						, $strOwnerChecked
						, $strAnnotationTxt
						, $strAnnotationOwner
						, $strListAnnotation
						, $strUsername
						, $txtUsername
						, $strTimeStamp
){
	$strTime = substr($strTimeStamp,11);
	$idCheckBox = "chk".$strAnnotationOwner;
	
	if($txtUserStatus == "P" ){ // Presenter
		if($strPresenterChecked == "Y"){
			$strCheckBox = '<input type="checkbox" id="'.$idCheckBox.'" name="'.$idCheckBox.'" '
			.'onClick="ChkNote(id);" value="'.$strAnnotationTxt.'" checked/>';
		}else{
			$strCheckBox = '<input type="checkbox" id="'.$idCheckBox.'" name="'.$idCheckBox.'" '
			.'onClick="ChkNote(id);" value="'.$strAnnotationTxt.'" />';
		}
	}//END if presenter
	else{//Viewer
		// If user <> ANNOTATION_OWNER, so can see list same as persenter
		if($strOwnerChecked == "Y" && strcasecmp($txtUsername, $strUsername) == 0)
		{
			$strCheckBox = '<input type="checkbox" id="'.$idCheckBox.'" name="'.$idCheckBox.'" '
			.'onClick="ChkNote(id);" value="'.$strAnnotationTxt.'" checked/>';
		}else{
			$strCheckBox = '<input type="checkbox" id="'.$idCheckBox.'" name="'.$idCheckBox.'" '
			.'onClick="ChkNote(id);" value="'.$strAnnotationTxt.'" />';
		}
	}//END if viewer
	
	$idSpan = "span" . $strAnnotationOwner;
	$strList ='<span id="'.$idSpan.'" >'
							.$strCheckBox
							.'&nbsp;'
							.$strAnnotationOwner
							.'&nbsp;&nbsp;'
							.$strTime 
						.'</span><br>';
								
	return $strList;
}// END setAnnotationList()
//==========================================================================================

mysqli_close($connect);
echo($strListAnnotation);

	
?>


