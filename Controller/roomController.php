<?php
	include '../Model/roomModel.php';
	

	function createRoom($room_name, $status_room, $password_room, $user_id){
		$roomModel = new roomModel();
		$room_id;
		if( !isset( $_POST['room_name'] ) ) $room_name = "";
		else $room_name = trim(strtoupper($_POST['room_name']));

		if($room_id = $roomModel -> createRoom($room_name, $status_room, $password_room, $user_id)){
			$_SESSION['sess_room_name'] = $room_name;
			/*$_SESSION['sess_private_status'] = $private_status; 
			$_SESSION['sess_room_status'] = $room_status; */
			$_SESSION['sess_password_room'] = $password_room; 
			$_SESSION['sess_room_id'] = $room_id;
			header("Location: ../bookshelf.php?action=selectFile&room_name=".$room_name."&room_id=".$room_id);
		}else{
			header("Location: ../index.php");
		}
	}

	function outRoom(){
		session_unset();
		header("Location: ../index.php");
	}

	function selectFile($room_id){
		$roomModel = new roomModel();
		$select = $roomModel -> selectFile($room_id);

		while ($data = mysqli_fetch_array($select)){
            $file_id = trim($data['FILEID']);
            $file_name = trim($data['FILE_NAME']);
            echo $file_id.$file_name;
        }
	}

	switch ($_GET['action']) {	
	    case 'createRoom':
	    	createRoom($_POST['room_name'],$_POST['status'],$_POST['password_room'],$_SESSION['sess_user_id']);
	    break;
	     	
	    case 'selectFile':
	    	selectFile($_GET['room_id']);
	    break; 
	    case 'outRoom':
	   		outRoom();
	    break; 	
	}
?>