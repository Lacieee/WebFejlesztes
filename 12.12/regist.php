<?php 
include("index.php"); ?>
<main class="container" role='main'>
<div class="jumbotron">
<h1 align="center">Regisztráció</h1>
<hr><br>
<form method="POST" align="center" width="50%">
			<input type="text" name="surname" placeholder="Vezetéknév"><br /><br />
			<input type="text" name="firstname" placeholder="Keresztnév"><br /><br />
			<input type="text" name="email" placeholder="E-mail cím"><br /><br />
			<input type="text" name="username" placeholder="Felhasználónév"><br /><br />
			<input type="password" name="password" placeholder="Jelszó"><br /><br />
			<button type="submit" name="regist" value="submit">Regisztráció</button><br />
			<br />
		</form>
		<div id="ertesites" align="center">
		<?php 
			if(isset($_POST['regist']))
			{
				$surname = $_POST['surname'];
				$firstname = $_POST['firstname'];
				$email = $_POST['email'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$succes = true;
				
				
				if($surname == "")
				{
					echo "Nem adtál meg vezetéknevet!<br />";
					$succes = false;
				}
				if($firstname == "")
				{
					echo "Nem adtál meg keresztnevet!<br />";
					$succes = false;
				}
				if($email == "")
				{
					echo "Nem adtál meg e-mail címet!<br />";
					$succes = false;
				}
				else
				{
					if(!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						$succes = false;
						echo "Az e-mail cím nem jó formátumban lett beíráva!<br />";
					}
				}
				if($username == "")
				{
					echo "Nem adtál meg felhasználónevet!<br />";
					$succes = false;
				}
				if($password == "")
				{
					echo "Nem adtál meg jelszót!<br />";
					$succes = false;
				}
				if($succes)
				{
					if($connection->connect_error) {
						die("Connection failed: ". $connection->connect_error)."<br />";
					}
					else
					{
						$sql = "SELECT username FROM users WHERE username LIKE '".$username."';";
						$result = mysqli_query($connection,$sql);
						if(mysqli_num_rows($result) >= 1)
						{
							$succes = false;
							echo "Ez a felhasználónév már létezik!";
						}
						if($succes)
						{
							#echo "Connected successfully";
							$sql = "INSERT INTO users (surname,firstname,email,username,password) VALUES ('".$surname."','".$firstname."','".$email."','".$username."','".md5($password)."');";
							#echo $sql;
							if($connection->query($sql) === TRUE)
							{
								echo "Sikeres regisztráció!";
								
							}else
							{
								echo "Error: ".$sql."<br />".$connection->error;
							}
						}
					}	
				}
			}
		?>
		</div>
	</div>
</main>