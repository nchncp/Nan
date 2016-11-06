<?php
	include '../Model/userModel.php';
	session_start();

	function signup($username,$email,$password){
		if( !isset( $_POST['username'] ) ) $username = "";
		else $username = trim(strtoupper($_POST['username']));

		if( !isset( $_POST['email'] ) ) $email = "";
		$email = trim($_POST['email']);

		if( !isset( $_POST['password'] ) ) $password = "";
		$password = trim($_POST['password']);

		if( !isset( $_POST['re_password'] ) ) $re_password = "";
		$re_password = trim($_POST['re_password']);

		$userModel = new userModel();
		$userModel -> signup($username, $password, $email);
		header("Location: ../index.php");
	}

	function login($username, $password){
		header("Location: ../index.php");
		
		if( !isset( $_POST['username'] ) ) $username = "";
		else $username = trim(strtoupper($_POST['username'])); //set txtUsername is UpperCase

		if( !isset( $_POST['password'] ) ) $password = "";
		else $password =  trim($_POST['password']);

		
		/*if( !isset( $_POST['hidAction'] ) ) $strAction = "";
		else $strAction =  trim($_POST['hidAction']);*/

		$msg = "";
		$userModel = new userModel();
		/*$user_id = $userModel -> login($username, $password);
*/
		if($user_id = $userModel -> login($username, $password)){
			$_SESSION['sess_username'] = $username; 
			$_SESSION['sess_email'] = $email; 
			$_SESSION['sess_password'] = $password; 
			
			$_SESSION['sess_user_id'] = $user_id;
			
		}else{
			$msg = "Not have this account";
		}

		
	}

	function logout(){
		/*$userModel = new userModel();
		$userModel -> logout($user_id);*/

		session_unset();
		header("Location: ../index.php");
	}

	if(isset($_GET['action'])){
		switch ($_GET['action']) {	
		    case 'signup':
		    	signup($_POST['username'],$_POST['email'],$_POST['password']);
		    break;
		    case 'login':
		    	login($_POST['username'],$_POST['password']);
		    break;
		    case 'logout':
		    	/*logout($_SESSION['sess_user_id']);*/
		    	logout();
		    break;
		}
	}
?>