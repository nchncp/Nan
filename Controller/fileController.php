<?php
	include '../Model/fileModel.php';
	

	function uploadFile($file_name, $user_id, $room_id, $room_name){
		
		if(isset($_FILES['file'])){
			$errors= array();
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			/*$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			
			      
			$expensions= array("pdf","docx","pptx");
			      
			if(in_array($file_ext,$expensions)== false){
			    $errors[]="extension not allowed, please choose a PDF file.";
			}
			   */   
			if($file_size > 257698037760){
			    $errors[]='File size must be excately 30 MB';
			}
			      
			if(empty($errors)==true){
				
			    move_uploaded_file($file_tmp,"../pdf/temp/".$file_name);
			    echo "Success";

				header("Location: ../bookshelf.php?action=selectFile&room_name=".$room_name. "&room_id=".$room_id."&file_id=".$file_id."&file_name=".$file_name);
			    $fileModel = new fileModel();
				
				if($file_id = $fileModel -> uploadFile($file_name, $user_id, $room_id)){
					/*$_SESSION['sess_file_id'] = $file_id;
					$_SESSION['sess_file_name'] = $file_name;*/
				}

			}else{
			    print_r($errors);
			}
		}

	}

	function joinRoom($selPresentationRoom, $room_id, $file_id, $file_name, $password_room){

		if( !isset( $_POST['room_name'] ) ) $room_name = "";
		else $room_name =  trim($_POST['room_name']);

		if( !isset( $_POST['password_room'] ) ) $password_room = "";
		else $password_room = trim($_POST['password_room']);

		if( !isset( $_POST['hidFilename'] ) ) $file_name = "";
		else $file_name = trim($_POST['hidFilename']);

		if( !isset( $_POST['hidFileid'] ) ) $file_id = "";
		else $file_id = trim($_POST['hidFileid']);

		if( !isset( $_POST['room_id'] ) ) $room_id = "";
		else $room_id = trim($_POST['room_id']);

		if( !isset( $_POST['selPresentationRoom'] ) ) $selPresentationRoom = "";
		else $selPresentationRoom = trim($_POST['selPresentationRoom']);

		$fileModel = new fileModel();
		
		/*echo "test";
		echo $room_id;
		echo $dataFileName;*/
		if($room_id <= 0){
			echo "Fail";
		}
		if($data=$fileModel -> joinRoom($selPresentationRoom, $room_id, $file_id, $file_name, $password_room)){
			header("Location: ../vpresent.php?action=joinRoom&room_id=".$data[1]."&room_name=".$selPresentationRoom."&file_id=".$data[2]."&file_name=".$data[3]);
		}else{
			header("Location: ../index.php");
		}
	}

	function enterToFile($room_id, $file_id,$room_name, $file_name){
		$fileModel = new fileModel();
		$fileModel -> enterToFile($room_id, $file_id);
		header("Location: ../ppresent.php?room_id=".$room_id."&file_id=".$file_id."&room_name=".$room_name."&file_name=".$file_name);
	}

	function updateStatusOffline($room_id, $file_id){
		$fileModel = new fileModel();
		$fileModel -> updateStatusOffline($room_id, $file_id);

		header("Location: ../bookshelf.php?action=selectFile&room_name=".$room_name. "&room_id=".$room_id);
	}

	function deleteFile($checked,$room_id,$room_name){

		$fileModel = new fileModel();
		$fileModel -> deleteFile($checked,$room_id,$room_name);

		$checked = $_POST['select'];

		for($i=0; $i < count($checked); $i++){
			$fileArr[$i] = $checked[$i];
		    /*echo $fileArr[$i];*/
		}
		header("Location: ../bookshelf.php?action=selectFile&room_name=".$room_name. "&room_id=".$room_id);
	}

	function deleteRoom($room_id, $user_id, $room_name){

		$fileModel = new fileModel();
		$fileModel -> deleteRoom($room_id, $user_id, $room_name);

		header("Location: ../index.php");
	}

	function logoutPpresent($room_id, $file_id){

		$fileModel = new fileModel();
		$fileModel -> updateStatusOffline($room_id, $file_id);

		session_unset();
		header("Location: ../index.php");
	}
	function logoutRoom($room_id){
		$fileModel = new fileModel();
		$fileModel -> logoutRoom($room_id);

		session_unset();
		header("Location: ../index.php");
	}
	switch ($_GET['action']) {	
	    case 'uploadFile':
	    	uploadFile($_FILES['file']['name'], $_SESSION['sess_user_id'], $_GET['room_id'], $_GET['room_name']);
	    break;
	    case 'enterToFile':
	    	enterToFile($_GET['room_id'], $_GET['file_id'],$_GET['room_name'], $_GET['file_name']);
	    break;	
	    case 'joinRoom':
	   		joinRoom($_POST['room_name'],$_POST['password_room'],$_GET['room_id'],$_GET['file_id'],$_POST['password_room']);
	    break;
	    case 'deleteFile':
	   		deleteFile($_POST['select'] ,$_GET['room_id'],$_GET['room_name']);
	    break;
	    case 'deleteRoom':
	    	deleteRoom($_GET['room_id'], $_SESSION['sess_user_id'],$_GET['room_name']);
	    break;
	    case 'updateStatusOffline':
	    	updateStatusOffline($_GET['room_id'], $_GET['file_id']);
	    break;
	    case 'logoutPpresent':
	    	logoutPpresent($_GET['room_id'], $_GET['file_id']);
	    break;
	    case 'logoutRoom':
	    	logoutRoom($_GET['room_id']);
	    break;
	}
?>