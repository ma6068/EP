<?php
	$servername = "localhost";
	$username = "root";
	$password = "ep";
	$dbname = "baza";
        
        function iscisti($data){
            $data=trim($data);
            $data=stripcslashes($data);
            $data=htmlspecialchars($data);
            $data=strip_tags($data);
            return $data;
        }
        
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	error_reporting(E_ERROR); 
        
	if (!$conn) {
		 die("Connection failed: " . mysqli_connect_error());
	}
	if (!mysqli_set_charset($conn, "utf8")) {
		echo mysqli_error($conn);
		exit();
	}
?>