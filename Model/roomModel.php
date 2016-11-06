<?php
	include '../config.php';
	session_start();

	class roomModel {
    
	    function createRoom($room_name, $status_room, $password_room,$user_id){
			$con = new connect();
			$connect = $con -> getConnection();
				
					
			//Check Room duplicate
				$selRoomSQL = "SELECT * FROM room_info WHERE ROOM_NAME = '$room_name'";
				$rsSelRoomAcc = mysqli_query($connect, $selRoomSQL) or die("SELECT ERROR: ". mysqli_error($connect));
				if(mysqli_num_rows($rsSelRoomAcc) > 0){
					echo "Room is duplicate";
				}else{
					if($status_room == 'N'){
						$password_room = null;
					}

					$sql = "INSERT INTO room_info(ROOM_NAME, PRIVATE_STATUS, PRIVATE_CODE, USERID) 
							VALUES('$room_name','$status_room','$password_room','$user_id')"; //into -> DB values -> variable

					if ($result = mysqli_query($connect, $sql )) {
						
						$selUserAccSQL = "SELECT ROOMID, ROOM_NAME FROM room_info WHERE ROOM_NAME = '$room_name'";
						$rsSelUserAcc = mysqli_query($connect, $selUserAccSQL) or die("SELECT ERROR: ". mysqli_error($connect));
						$rowSelUserAcc = mysqli_num_rows($rsSelUserAcc);
						if($rowSelUserAcc > 0){
							$dataUser = mysqli_fetch_array($rsSelUserAcc);//USER_ACCOUNT table
							$room_id = trim($dataUser['ROOMID']);
							$roomname = trim($dataUser['ROOM_NAME']);
						}
				    	echo "New record created successfully";
				    	echo $status_room, $password_room, $room_name,$roomname;
				    	return $room_id;
					} else {
				    	echo mysqli_error($connect);
				    }
				}
			
		}

		

		function selectFile($room_id){
			$con = new connect();
			$connect = $con -> getConnection();

			$selFile = "SELECT * FROM file_info WHERE ROOMID ='$room_id'";
			$rsSelFile = mysqli_query($connect, $selFile) or die("SELECT ERROR: ". mysqli_error($connect));		/*print_r($selRoom);*/
			
            return $rsSelFile;
		}

	}
?>
