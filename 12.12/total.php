<?php
	session_start();
	include_once 'database/database_handler.php';
	$total = $_POST['newtotal'];
	
	$sql = "INSERT INTO money (userID, value, total, date) VALUES ('".$_SESSION['session']."','".$total."','".$total."','".date("Y-m-d H:i:s")."');";
	if ($connection->query($sql) === TRUE) {
		echo "New record created successfully";
		$_SESSION['money'] = $total;
		header("Location: index.php");
	} else {
		echo "Error: " . $sql . "<br>" . $connection->error;
	}
?>