<?php
include_once "index.php";
?>
<form method="POST">
	<span>Bejelentkezés</span>
			<input type="text" name="user" placeholder="Felhasználónév"><br />
			<input type="password" name="pw" placeholder="Jelszó"><br /><br />
			<button type="submit" name="login" value="submit">Bejelentkezés</button>
</form>
<?php
	if(isset($_POST['login']))
	{
		$user = $_POST['username'];
		$pw = $_POST['password'];
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
					$newsql = "SELECT * FROM money WHERE userID = '".$row['ID']."' ORDER BY date DESC LIMIT 1;"; 
					$newresult = mysqli_query($connection,$newsql);
					if(mysqli_num_rows($newresult) >= 1)
					{
						$newrow = mysqli_fetch_array($newresult);
						$_SESSION['money'] = $newrow['total'];
					}
					else
					{
						$_SESSION['money'] = "unset";
					}
					header("Location:index.php");
				}
				else
				{
					echo "A felhasználónév vagy jelszó nem egyezik!";
				}
			}
		}
	}
 ?>