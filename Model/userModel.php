<?php
	include '../config.php';
	session_start();

	class userModel	{
		function login($username, $password){
			$con = new connect();
			$connect = $con -> getConnection();
			
			// default error
			$strMsg = "";
			// default input parameter
			date_default_timezone_set('Asia/Bangkok'); 
			$NowTimeStampLT = date("Y-m-d H:i:s");

			// Check Username and Password is valid in database
			$selUserAccSQL = "SELECT * FROM user_account WHERE USERNAME = '$username'";
			$rsSelUserAcc = mysqli_query($connect, $selUserAccSQL) or die("SELECT ERROR: ". mysqli_error($connect));
			$rowSelUserAcc = mysqli_num_rows($rsSelUserAcc);
			// END check Username and Password is valid in database
			
			$strAction = "";
				if($rowSelUserAcc > 0){

					$dataUser = mysqli_fetch_array($rsSelUserAcc);//USER_ACCOUNT table
					$dbemail = trim($dataUser['EMAIL']);
					$dbid = trim($dataUser["USERID"]);
					$dbroomstatus = trim($dataUser["ROOM_STATUS"]);
					$dbprivatestatus = trim($dataUser["PRIVATE_STATUS"]);
					$dbpassword = trim($dataUser['PASSWORD']);
					$dbUsername = trim(strtoupper($dataUser['USERNAME']));
					$OnlineFlag = trim(strtoupper($dataUser['ONLINE_FLAG']));
					
					
					if($password != "" || $dbpassword != $password){
						$strMsg = "Invalid password !";
						
					}/*else if($OnlineFlag == "Y" && strcasecmp($dbUsername, $username)==0 && $UserStatus != "P"){	
						$strMsg = "Sorry " . $username . " already login !";
						
					}*//*else if($txtRoomNo == "" && $UserStatus == "P"){
						$strMsg = "Please input room number !";	
					}*/
					
					$user_id = $dbid;
					
				}else{
					
					if($username != "" || $password != "" /*|| $txtRoomNo != ""*/){
						if($username == ""){
							$strMsg = "Please input username !";
							
						}else if($password == ""){
							$strMsg = "Please input password !";
							
						}/*else if($txtRoomNo == ""){
							$strMsg = "Not found presentation room !";
						}*/
						
					}
				}//END else...
			//END if($strAction != "")
			return $user_id;
		}

		function signup($username, $password, $email){
			$con = new connect();
			$connect = $con -> getConnection();

			$strMsg = "";
			date_default_timezone_set('Asia/Bangkok'); 
			$NowTimeStampLT = date("Y-m-d H:i:s");

			// check E-mail duplicate in database
			$SQLSelectEmail = "SELECT * FROM USER_ACCOUNT WHERE EMAIL='$email' ";
			$rsEmail = mysqli_query($connect, $SQLSelectEmail)or die(mysqli_error($connect));
			//$rsEmail = mysqli_query($SQLSelectEmail) or die(mysqli_error());

			// check Username duplicate in database
			$SQLSelectUsername = "SELECT * FROM USER_ACCOUNT WHERE USERNAME='$username' ";
			$rsUsername = mysqli_query($connect, $SQLSelectUsername)or die(mysqli_error($connect));

			if(mysqli_num_rows($rsEmail) > 0 && $email != ""){
				$strMsg = "Duplicate E-mail address !!!";
				
			}else if(mysqli_num_rows($rsUsername) > 0){
				$strMsg = "Duplicate username !!!";
					
			}else{
				// insert new user account in database
				$SQLInsertNewUser = "INSERT INTO USER_ACCOUNT (USERID, USERNAME, PASSWORD, EMAIL, STATUS, ONLINE_FLAG, USER_UPD_TIMESTAMP) 
				VALUES (NULL, '$username', '$password', '$email', 'V', 'N', '$NowTimeStampLT' )";
				
				$rsInsert = mysqli_query($connect, $SQLInsertNewUser) or die('INSERT ERROR : ' . mysqli_error($connect));
				$strMsg = "finished";	
			}
			echo $strMsg;
		}

		/*function logout($user_id){
			$con = new connect();
			$connect = $con -> getConnection();

			$user_id = $_SESSION['sess_user_id'];

			$SQLDeleteStatus = "DELETE FROM status WHERE USERID = '$user_id'";
			$rsDeleteStatus = mysqli_query($connect, $SQLDeleteStatus) or die('INSERT ERROR : ' . mysqli_error($connect));

			$updateStatusRoom = "UPDATE room_info SET ROOM_STATUS='OFF' WHERE USERID = '$user_id'";
			$rsUpdateStatusRoom = mysqli_query($connect, $updateStatusRoom)or die ("UPDATE ERROR: ". mysqli_error($connect));

		}*/
	}

?>
