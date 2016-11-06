<?php
	class connect{
		function getConnection(){
			/*$hostname = "localhost";
			$user = "root";
			$pass = "root";
			$dbname = "thesis";
			$con = new mysqli($hostname,$user,$pass,$dbname);
			if($con -> connect_error){
				die("Connection failed: " . $con -> connect_error);
			}

			echo "Connect successfully!!!!!! <br>";
			echo $hostname,$user,$pass,$dbname;
			return $con;
		}*/

		$hostname = "localhost";
			$user = "root";
			$pass = "";
			$dbname = "thesis";
			$con = mysqli_connect($hostname,$user,$pass,$dbname);
			if(!$con){
				die("Connection failed: " . mysqli_connect_error());
			}

			return $con;
		}

	}

?>
