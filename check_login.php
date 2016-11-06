<?
	session_start();
	mysql_connect("localhost","root","root");
	mysql_select_db("mydatabase");
	$strSQL = "SELECT * FROM member WHERE Username = '".trim($_POST['login_user'])."' 
	and Password = '".trim($_POST['login_pass'])."'";
	$objQuery = mysql_query($strSQL);
	$objResult = mysql_fetch_array($objQuery);
	if(!$objResult)
	{
			echo "Username and Password Incorrect!";
	}
	else
	{
			$_SESSION["UserID"] = $objResult["UserID"];
			$_SESSION["Status"] = $objResult["Status"];

			session_write_close();
			
			if($objResult["Status"] == "ADMIN")
			{
				header("location:login.php");
			}
			else
			{
				header("location:login.php");
			}
	}
	mysql_close();
?>