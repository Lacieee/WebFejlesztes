<?php 
session_start();
include_once '../database/database_handler.php';
?>
<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Új téma - Linktár</title>
	<link rel="shortcut icon" href="../favicon.ico">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body>
  <main role='main' class='container' style='padding-top: 70px;'>
      <div class='class="col-sm-8 mx-auto' align="center">
			<div style="background-color:#eee;border:1px solid black; border-radius: 4px;">	
				<h1>Új téma hozzáadása</h1>
				<br>
				<form method="POST">
					<div class="input-group" style="width:40%;">
						<span class="input-group-addon" id="basic-addon1">Téma</span>
						<input type="text" class="form-control" placeholder="..." aria-describedby="basic-addon1" name="theme" style="width:400px;">
					</div> 
					<br>
					<button class='btn btn-outline-info my-2 my-sm-0' type='submit' name='submit'>Hozzáadás</button>
					<br><br>
				</form>
			</div>
			<br>
			<a href="../">Vissza a főoldalra</a>
		</div>
		
	</main>
	
	<footer style='z-index:1; position:fixed; display:block; right: 0; bottom: 0; left: 0; color: #333; background-color: #EEE; padding-left: 20px'>
		<hr>
      <p>&copy; Copyright - Kőváry László 2017</p>
    </footer>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js' integrity='sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  </body>
</html>
<?php 
	if(isset($_POST['submit']))
	{
		$name = mysqli_real_escape_string($connection,$_POST['theme']);
		//csekkoljuk bent-van e már
		if($name != "")
		{
			$sql = "SELECT * FROM themes WHERE name LIKE '$name';";
			$result = mysqli_query($connection,$sql);
			if(mysqli_num_rows($result) == 0)
			{
				$sql = "INSERT INTO themes (name,userID) VALUES ('".$name."','".$_SESSION['session']."');";
				if ($connection->query($sql) === TRUE) {
					echo "Sikeres feltöltés. Átirányítás a főoldalra...";
					header("Location: ../");
				}
				else
				{
					echo "Sikertelen feltöltés.";
				}
			}
			else
			{
				echo "Ez a téma már létezik!";
			}
		}
	}
	
?>