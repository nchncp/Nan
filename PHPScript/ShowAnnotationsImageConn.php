<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();


if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));

if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
else $hidFileid = trim($_POST['hidFileid']);

if( !isset( $_POST['hidUserStatus'] ) ) $txtUserStatus = "";
else $txtUserStatus = trim(strtoupper($_POST['hidUserStatus']));

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));

if( !isset( $_POST['txtPageNo'] ) ) $txtPageNo = "1";
else $txtPageNo = trim($_POST['txtPageNo']);

if( !isset( $_POST['isPresent'] ) ) $isPresent = "";
else $isPresent = trim(strtoupper($_POST['isPresent']));

if( !isset( $_POST['txtPresenterPageNo'] ) ) $txtPresenterPageNo = $txtPageNo;
else $txtPresenterPageNo = trim($_POST['txtPresenterPageNo']);



//=========================================================================================================

	$SQLSelectImageNote = "SELECT DISTINCT A.ANNOTATION_TEXT, A.ANNOTATION_OWNER, DISP.USERNAME, DISP.CHECKED "
	.", DISP.PRESENTER_CHECKED, A.ANNOTATION_UPD_TIMESTAMP, DISP.USER_STATUS, A.SOURCE_IMAGE, A.ROOM_NO, A.FILEID " 

	."FROM ANNOTATION_DISP AS DISP, ANNOTATION AS A, ROOM_INFO AS R, FILE_INFO AS F, USER_ACCOUNT AS USR "

	."WHERE A.ROOM_NO = '$txtRoomNo' "
	."AND A.FILEID = '$hidFileid' "
	."AND DISP.PAGE_NO = A.PAGE_NO "
	."AND DISP.OWNER = USR.USERNAME ";
	if($isPresent == "Y"){ 
		$SQLSelectImageNote = "";
	}else{
		$SQLSelectImageNote .= " AND DISP.USERNAME = '$txtUsername' "
			 				." AND A.PAGE_NO = '$txtPageNo' ";
		if($txtUserStatus == "P"){
			$SQLSelectImageNote .=" AND DISP.PRESENTER_CHECKED = 'Y' "
								."AND DISP.OWNER = A.ANNOTATION_OWNER ";
			//print_r("presenter");
		}else{
			$SQLSelectImageNote .=" AND DISP.CHECKED = 'Y' "
								."AND DISP.OWNER = A.ANNOTATION_OWNER ";
			//print_r("viewer");
		}
		$SQLSelectImageNote .=" ORDER BY A.ANNOTATION_UPD_TIMESTAMP DESC ";
	
	}

$strImgNoteName = "";
$strOwner = "";
$strUpdatedNoOld = "";
$strUpdatedNoNew = "";
$strSourceImage = "";
/*print_r($SQLSelectImageNote);*/
if($SQLSelectImageNote != ""){
	$rsSelect = mysqli_query($connect,$SQLSelectImageNote) 
	or die("ShowAnnotationImageConn.php()-- error:: " . mysqli_error($connect));
	
	$num_rows = mysqli_num_rows($rsSelect);
	
	//echo $SQLSelectImageNote . "<br>";
	//echo ">>> " . $num_rows . "<br>";
	
	
	while($data = mysqli_fetch_assoc($rsSelect)) {
		$strImgNoteName .= $data['ANNOTATION_TEXT'] . ",";
		$strOwner .= $data['ANNOTATION_OWNER'] . ",";
		$strSourceImage .= $data['SOURCE_IMAGE'] . ",";
	}// END while loop
}

			
//echo ">> Array ImgNoteName = " . $strImgNoteName . "<br>";
//=========================================================================================================
mysqli_close($connect);

?>

<input type="hidden" id="hidArrNoteName" value="<?= $strImgNoteName  ?>" >
<input type="hidden" id="hidArrOwnerNote" value="<?= $strOwner ?>" > 
<input type="hidden" id="hidArrSourceImage" value="<?= $strSourceImage  ?>" >


