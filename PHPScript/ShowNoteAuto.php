<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();
if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));
//echo "txtRoomNo = " . $txtRoomNo . "<br>";

/*if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
else $hidFileid = trim($_POST['hidFileid']);*/

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));
//echo "txtUsername = " . $txtUsername . "<br>";

/*if( !isset( $_POST['txtPageNo'] ) ) $txtPageNo = "1";
else $txtPageNo = trim($_POST['txtPageNo']);*/
//echo "txtPageNo = " . $txtPageNo . "<br>";

if( !isset( $_POST['isPresent'] ) ) $isPresent = "";
else $isPresent = $_POST['isPresent'];
//echo "isPresent = " . $isPresent . "<br>";


// Check Room is valid in database
/*$SQLSelectPresenterPageNo = "SELECT DISTINCT R.ROOM_NAME, R.PRIVATE_STATUS, R.PRIVATE_CODE, S.CURRENT_PAGE "
	."FROM FILE_INFO AS F, USER_ACCOUNT AS USR, STATUS AS S, ROOM_INFO AS R "
	."WHERE R.ROOM_NAME = '$txtRoomNo' "
	."AND F.FILEID = '$hidFileid' "
	."AND S.USERSTATUS = 'P' "
	."AND S.USERID = F.USERID "
	."AND USR.USERID = F.USERID ";
				
$rsSelectPage = mysqli_query($connect,$SQLSelectPresenterPageNo) or die(mysqli_error($connect));
$pagePresenter = "1";
if(mysqli_num_rows($rsSelectPage) > 0){
	$data = mysqli_fetch_array($rsSelectPage);
	$pagePresenter = $data['CURRENT_PAGE'];
	
	//echo "if row > 0... pageno=" . $pagePresenter . "<br>";
}else{
	//default pageno = 1
	$pagePresenter = "1";
	
	//echo "else... pageno=" . $pagePresenter . "<br>";
}*/

//================================================================
/*$SQLSelectNote = "SELECT A.ANNOTATION_TEXT, A.ANNOTATION_OWNER, DISP.USERNAME, DISP.CHECKED "
	.", DISP.PRESENTER_CHECKED, A.ANNOTATION_UPD_TIMESTAMP, USR.STATUS, A.SOURCE_IMAGE "
	."FROM ANNOTATION_DISP AS DISP, ANNOTATION AS A, PRESENTATION_FILE AS F, USER_ACCOUNT AS USR "
	."WHERE A.ROOM_NO = '$txtRoomNo' "
	."AND A.ROOM_NO = F.ROOM "
	."AND DISP.PAGE_NO = A.PAGE_NO "
	."AND DISP.OWNER = F.USERNAME "
	."AND DISP.OWNER = A.ANNOTATION_OWNER "
	."AND DISP.OWNER = USR.USERNAME "
 	."AND DISP.USER_STATUS = 'P' "
	."AND A.PAGE_NO = '$pagePresenter' "
	."AND DISP.PRESENTER_CHECKED = 'Y' "
	."ORDER BY A.ANNOTATION_UPD_TIMESTAMP DESC ";*/

	$SQLSelectNote = "SELECT DISTINCT A.ANNOTATION_TEXT, A.ANNOTATION_OWNER, "
."A.ANNOTATION_UPD_TIMESTAMP, A.SOURCE_IMAGE " 
."FROM  ANNOTATION AS A "
."WHERE A.ROOM_NO = '$txtRoomNo' "
."ORDER BY A.ANNOTATION_UPD_TIMESTAMP DESC ";



$rsSelectNote = mysqli_query($connect,$SQLSelectNote) or die("ShowAuto.php()-- error:: " . mysqli_error($connect));
$num_rows = mysqli_num_rows($rsSelectNote);

//echo $SQLSelectImageNote . "<br>";
//echo ">>> " . $num_rows . "<br>";

$strImgNoteName = "";
$strOwner = "";
$strSourceImage = "";
while($data = mysqli_fetch_assoc($rsSelectNote)) {
	$strImgNoteName .= $data['ANNOTATION_TEXT']. ",";
	$strOwner .= $data['ANNOTATION_OWNER']. ",";
	$strSourceImage .= $data['SOURCE_IMAGE']. ",";
}// END while loop
			
//echo $strImgNoteName . "<br>";
mysqli_close($connect);
/*
echo ">>>> Image Note : " 
. ", Image Note Name: ". $strImgNoteName 
. ", Owner Note Name: ". $strOwner 
. ", Src Note Name: ". $strSourceImage . "<br>";
*/

?>

<input type="hidden" id="hidArrNoteNamePresenter" value="<?= $strImgNoteName  ?>" >
<input type="hidden" id="hidArrOwnerNotePresenter" value="<?= $strOwner ?>" > 
<input type="hidden" id="hidArrSourceImagePresenter" value="<?= $strSourceImage  ?>" >
