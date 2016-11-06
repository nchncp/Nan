<?php
	include '../config.php';
	session_start();

	class fileModel	{
		function bookshelf(){

		}
		function uploadFile($file_name, $user_id, $room_id){
			$con = new connect();
			$connect = $con -> getConnection();

			// default error
			$strMsg = "";
			// default input parameter
			date_default_timezone_set('Asia/Bangkok'); 
			$NowTimeStampLT = date("Y-m-d H:i:s");

			$sql = "INSERT INTO file_info(FILE_NAME, FILE_UPD_TIMESTAMP, USERID, ROOMID) 
					VALUES('$file_name','$NowTimeStampLT','$user_id', '$room_id')";
			
			if (mysqli_query($connect, $sql)) {
				$selUserAccSQL = "SELECT FILEID, FILE_NAME FROM file_info WHERE FILE_NAME = '$file_name' AND USERID = '$user_id' AND ROOMID = '$room_id'";
				$rsSelUserAcc = mysqli_query($connect, $selUserAccSQL) or die("SELECT ERROR: ". mysqli_error($connect));
				
					$dataUser = mysqli_fetch_array($rsSelUserAcc);//USER_ACCOUNT table
					$file_id = trim($dataUser['FILEID']);
					$file_name = trim($dataUser['FILE_NAME']);
				echo "Upload Finish";
			}else{
				echo mysqli_error($connect);
				
			}

			return $file_name;
		}
		
		function joinRoom($selPresentationRoom, $room_id, $file_id, $file_name, $password_room){
			$con = new connect();
			$connect = $con -> getConnection();

			$user_id = $_SESSION['sess_user_id'];
			/*$selRoom = "SELECT ROOMID, PRIVATE_STATUS, ROOM_STATUS FROM room_info 
					    WHERE ROOM_NAME ='$selPresentationRoom'AND PRIVATE_CODE='$password_room'";*/
			$selRoom = "SELECT ROOMID, PRIVATE_STATUS, ROOM_STATUS FROM room_info 
					    WHERE ROOM_NAME ='$selPresentationRoom' AND ROOM_STATUS = 'ON' AND PRIVATE_CODE='$password_room'";
			$rsSelRoom = mysqli_query($connect, $selRoom) or die("SELECT ERROR: ". mysqli_error($connect));		/*print_r($selRoom);*/
			
			if(mysqli_num_rows($rsSelRoom) > 0){
				$dataUser = mysqli_fetch_array($rsSelRoom);//USER_ACCOUNT table
				$room_id = trim($dataUser['ROOMID']);

				if (mysqli_query($connect, $selRoom)) {
					$selFile = "SELECT FILE_NAME, FILEID FROM file_info WHERE ROOMID='$room_id'AND STATUS_FILE = 'ON'";
					$selFileName = mysqli_query($connect, $selFile) or die("SELECT ERROR: ". mysqli_error($connect));
					$dataFile = mysqli_fetch_array($selFileName);
					$dataFileName =$dataFile['FILE_NAME'];
					$file_id = trim($dataFile['FILEID']);
					//$arr = array($dataFileName,$room_id);
					//echo($dataFileName);
					
				}else {
				    echo mysqli_error($connect);
				}
				
				$selStatus = "SELECT * FROM status WHERE '$user_id' = USERID";
				$rsStatus = mysqli_query($connect,$selStatus) or die(mysqli_error($connect));

				if(mysqli_num_rows($rsStatus) > 0){
					$statusUp = "UPDATE status SET ROOMID='$room_id', FILEID='$file_id', USERSTATUS='V' WHERE USERID = '$user_id'";
					mysqli_query($connect, $statusUp) or die ("INSERT ERROR: ". mysqli_error($connect));
				}else{
					$statusIn = "INSERT INTO status(USERID, ROOMID, FILEID, USERSTATUS, CURRENT_PAGE)
								VALUES('$user_id','$room_id','$file_id','V','1')";
					mysqli_query($connect, $statusIn) or die ("INSERT ERROR: ". mysqli_error($connect));
				}
				return array($selPresentationRoom, $room_id, $file_id, $dataFileName);

			}else{
				
			}
			
		}

		function enterToFile($room_id, $file_id){
			$con = new connect();
			$connect = $con -> getConnection();
			$user_id = $_SESSION['sess_user_id'];

			$sqlFile = "UPDATE file_info SET STATUS_FILE='ON' WHERE ROOMID = '$room_id' AND FILEID = '$file_id'";

			if(mysqli_query($connect, $sqlFile)){
				$sqlRoom = "UPDATE room_info SET ROOM_STATUS='ON' WHERE ROOMID = '$room_id'";
				
				if(mysqli_query($connect, $sqlRoom)){
					$sqlOffline = "UPDATE file_info SET STATUS_FILE='OFF' WHERE ROOMID = '$room_id' AND FILEID != '$file_id'";
					mysqli_query($connect, $sqlOffline) or die ("UPDATE ERROR: ". mysqli_error($connect));
				}else{
					echo"UPDATE ERROR: ". mysqli_error($connect);
				}
			}else{
				echo "UPDATE ERROR: ". mysqli_error($connect);
			}
			
			$selStatus = "SELECT * FROM status WHERE '$user_id' = USERID";
			$rsStatus = mysqli_query($connect,$selStatus) or die(mysqli_error($connect));

			if(mysqli_num_rows($rsStatus) > 0){
				$statusUp = "UPDATE status SET ROOMID='$room_id', FILEID='$file_id', USERSTATUS='P' WHERE USERID = '$user_id'";
				mysqli_query($connect, $statusUp) or die ("INSERT ERROR: ". mysqli_error($connect));
			}else{ //new status that not have in database
				$statusIn = "INSERT INTO status(USERID, ROOMID, FILEID, USERSTATUS, CURRENT_PAGE)
							VALUES('$user_id','$room_id','$file_id','P','1')";
				mysqli_query($connect, $statusIn) or die ("INSERT ERROR: ". mysqli_error($connect));
			}
		}

		function updateStatusOffline($room_id, $file_id){
			$con = new connect();
			$connect = $con -> getConnection();

			$sqlFile = "UPDATE file_info SET STATUS_FILE='OFF' WHERE ROOMID = '$room_id' AND FILEID = '$file_id'";

			if(mysqli_query($connect, $sqlFile)){
				$sqlRoom = "UPDATE room_info SET ROOM_STATUS='OFF' WHERE ROOMID = '$room_id'";
				mysqli_query($connect, $sqlRoom) or die ("UPDATE ERROR: ". mysqli_error($connect));

				$updateCurrent = "UPDATE status SET CURRENT_PAGE='1' WHERE ROOMID = '$room_id' AND FILEID = '$file_id'";
				mysqli_query($connect, $updateCurrent) or die ("UPDATE ERROR: ". mysqli_error($connect));
			}else{
				echo "UPDATE ERROR: ". mysqli_error($connect);
			}
		}

		function deleteFile($checked,$room_id,$room_name){
			$con = new connect();
			$connect = $con -> getConnection();

			for($i=0; $i < count($checked); $i++){
			    $sqlFile = "DELETE FROM file_info WHERE FILEID = '$checked[$i]'";
				$rsFile = mysqli_query($connect,$sqlFile) or die(mysqli_error($connect));

				$sqlStatus = "DELETE FROM status WHERE FILEID = '$checked[$i]'";
				$rsStatus = mysqli_query($connect,$sqlStatus) or die(mysqli_error($connect));

				$deleteDisp = "DELETE FROM annotation_disp WHERE FILEID = '$checked[$i]'";
				$rsDeleteDisp = mysqli_query($connect,$deleteDisp) or die(mysqli_error($connect));

				$deleteAnno = "DELETE FROM annotation WHERE FILEID = '$checked[$i]'";
				$rsDeleteAnno = mysqli_query($connect,$deleteAnno) or die(mysqli_error($connect));
			}
			
		}
		function deleteRoom($room_id, $user_id, $room_name){
			$con = new connect();
			$connect = $con -> getConnection();

			$sqlRoom = "DELETE FROM room_info WHERE ROOMID = '$room_id' AND USERID = '$user_id'";
			$rsRoom = mysqli_query($connect,$sqlRoom) or die(mysqli_error($connect));

			$sqlFile = "DELETE FROM file_info WHERE ROOMID = '$room_id' AND USERID = '$user_id'";
			$rsFile = mysqli_query($connect,$sqlFile) or die(mysqli_error($connect));

			$sqlStatus = "DELETE FROM status WHERE ROOMID = '$room_id'";
			$rsStatus = mysqli_query($connect,$sqlStatus) or die(mysqli_error($connect));

			$deleteDisp = "DELETE FROM annotation_disp WHERE ROOM_NO = '$room_name'";
			$rsDeleteDisp = mysqli_query($connect,$deleteDisp) or die(mysqli_error($connect));

			$deleteAnno = "DELETE FROM annotation WHERE ROOM_NO = '$room_name'";
			$rsDeleteAnno = mysqli_query($connect,$deleteAnno) or die(mysqli_error($connect));
		}

		function logoutRoom($room_id){
			$con = new connect();
			$connect = $con -> getConnection();

			$sqlRoom = "UPDATE room_info SET ROOM_STATUS='OFF' WHERE ROOMID = '$room_id'";
			$rsRoom = mysqli_query($connect,$sqlRoom) or die(mysqli_error($connect));

			$updateCurrent = "UPDATE status SET CURRENT_PAGE='1' WHERE ROOMID = '$room_id'";
			mysqli_query($connect, $updateCurrent) or die ("UPDATE ERROR: ". mysqli_error($connect));

			$sqlFile = "UPDATE file_info SET STATUS_FILE='OFF' WHERE ROOMID = '$room_id'";
			mysqli_query($connect, $sqlFile) or die ("UPDATE ERROR: ". mysqli_error($connect));
	}
	}
?>