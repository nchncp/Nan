<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();
if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = $_POST['txtRoomNo'];



// Check Room is valid in database
$SQL = "SELECT DISTINCT F.ROOM, F.PRIVATE_STATUS, F.PRIVATE_CODE, F.CURRENT_PAGE "
	."FROM PRESENTATION_FILE AS F, USER_ACCOUNT AS USR "
	."WHERE F.ROOM = '$txtRoomNo' "
	."AND USR.STATUS = 'P' "
	."AND USR.USERNAME = F.USERNAME ";
				
$rs = mysqli_query($connect, $SQL) or die(mysqli_error($connect));
if(mysqli_num_rows($rs) > 0){
	$data = mysqli_fetch_array($rs);
	$page = $data['CURRENT_PAGE'];
	
}else{
	//default pageno = 1
	$page = "1";
	
}

mysqli_close($connect);
//echo "ViewerConn()-- page_no = " . $page . "<br>";
?>

<input type="hidden" id="hidPresenterPage" name="hidPresenterPage" value="<?= $page ?>" />




