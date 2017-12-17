<?php
session_start();
include_once "../database/database_handler.php";
	if(isset($_POST['login']))
	{
		$user = mysqli_real_escape_string($connection,$_POST['username']);
		$pw = mysqli_real_escape_string($connection,$_POST['password']);
		$suc = true;
		if($user == "")
		{
			echo "Nem adtál meg felhasználónevet!<br />";
			$suc = false;
		}
		if($pw == "")
		{
			echo "Nem adtál meg jelszót!<br />";
			$suc = false;
		}
		if($suc)
		{
			if($connection->connect_error) {
				die("Connection failed: ". $connection->connect_error)."<br />";
			}
			else
			{
				$sql = "SELECT ID, surname, firstname FROM users WHERE username LIKE '".$user."' AND password LIKE '".md5($pw)."';";
				$result = mysqli_query($connection,$sql);
				if(mysqli_num_rows($result) == 1)
				{
					$row = mysqli_fetch_array($result);
					$_SESSION['session'] = $row['ID'];
					$_SESSION['name'] = $row['surname']." ".$row['firstname'];
					header("Location:../index.php");
				}
				else
				{
					echo "A felhasználónév vagy jelszó nem egyezik!";
				}
			}
		}
	}
 ?>