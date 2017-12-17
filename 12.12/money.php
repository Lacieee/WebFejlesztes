<?php 
session_start();
include_once 'database/database_handler.php';
if(isset($_POST['btnup']))
	{
		$money = $_POST['money'];
		$newsql = "INSERT INTO money (userID,value,total,date) VALUES ('".$_SESSION['session']."','".$money."','".($_SESSION['money'] + $money)."','".date("Y-m-d H:i:s")."');";
		if ($connection->query($newsql) === TRUE) {
		echo "New record created successfully";
			$_SESSION['money'] = ($_SESSION['money'] + $money);
			$x = 1;
			$sql = "SELECT * FROM money WHERE userID = '".$_SESSION['session']."' ORDER BY date DESC LIMIT 10;";
			$result = mysqli_query($connection,$sql);
			if(mysqli_num_rows($result)>=1)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					echo "
					<tr>
						<td>".$x."</td>
						<td>".$row['date']."</td>
						<td>".$row['value']."</td>
						<td>".$row['total']."</td>
					</tr>";
					$x = $x + 1;
				}
			}
		} else {
			echo "Error: " . $newsql . "<br>" . $connection->error;
		}
	}
	
	if(isset($_POST['btndown']))
	{
		$money = $_POST['money'];
		$money = 0 - $money;
		$newsql = "INSERT INTO money (userID,value,total,date) VALUES ('".$_SESSION['session']."','".$money."','".($_SESSION['money'] + $money)."','".date("Y-m-d H:i:s")."');";
		if ($connection->query($newsql) === TRUE) {
		echo "New record created successfully";
			$_SESSION['money'] = ($_SESSION['money'] + $money);
			$x = 1;
			$sql = "SELECT * FROM money WHERE userID = '".$_SESSION['session']."' ORDER BY date DESC LIMIT 10;";
			$result = mysqli_query($connection,$sql);
			if(mysqli_num_rows($result)>=1)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					echo "
					<tr>
						<td>".$x."</td>
						<td>".$row['date']."</td>
						<td>".$row['value']."</td>
						<td>".$row['total']."</td>
					</tr>";
					$x = $x + 1;
				}
			}
		} else {
			echo "Error: " . $newsql . "<br>" . $connection->error;
		}
	}
	
	if(isset($_POST['btnfresh']))
	{
		echo "Jelenlegi összeg: ".$_SESSION['money']." .-HUF";
	}
?>