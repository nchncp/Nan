<select id="selPresentationRoom" name="selPresentationRoom" style="width:90%;" onChange="chkError();">
    <option value="">Select presentation room</option>

<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();

/*$selPresentationRoomSQL = "SELECT ROOM_NAME FROM room_info";*/
$selPresentationRoomSQL = "SELECT F.ROOM_NAME FROM room_info AS F, user_account AS U , status AS S " 
						 ."WHERE  U.user_id = F.user_id "
						 ."AND F.user_id = S.user_id "
						 ."AND S.USERSTATUS='P' ";

$rsSelPresentationRoom = mysqli_query($connect, $selPresentationRoomSQL) or die("Select Presentation Room error: ". mysqli_error());

while ($row = mysqli_fetch_array($rsSelPresentationRoom)){
	$presentation_room = trim($row['ROOM_NAME']);
	echo '<option value="'.$presentation_room.'">'.$presentation_room.'</option>';
}//END while loop
//=================================================================================================================
mysqli_close($connect);
?>
</select>