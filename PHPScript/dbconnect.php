<?php
//======= For Production ================
//$db_host = "mydb-pj.sit.kmutt.ac.th";
//$db_username = "s55441319swe700";
//$db_password = "NRH7HQZ2";
//$db_name = "ss55441319swe700db";

//======= For TEST!! ====================
/*$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "thesisdb";

$objConnect = mysql_connect($db_host,$db_username,$db_password) or die ('ERROR: ' . mysql_error());
$objDB = mysql_select_db("$db_name") or die ('DB ERROR: ' . mysql_error());
mysql_query("SET NAMES utf8", $objConnect);*/
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "thesis";

$objConnect = mysqli_connect($db_host,$db_username,$db_password) or die ('ERROR: ' . mysqli_error());
$objDB =mysqli_select_db($objConnect, "$db_name")or die ('DB ERROR: ' . mysqli_error());
 mysqli_query($objConnect, "SET NAMES utf8") or die("SELECT ERROR: ". mysqli_error($objConnect));
/*mysqli_query("SET NAMES utf8", $objConnect) or die("SELECT ERROR: ". mysqli_error($objConnect));*/
?>

