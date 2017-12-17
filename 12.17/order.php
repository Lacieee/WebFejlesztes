<?php
session_start();
include_once 'database/database_handler.php';
if(isset($_POST['orderbtn']))
{
	# Egyedi ID - KL0011217 | K - vezeték név első betűje | L - keresztnév első betűje | XXX - userID | XX - óra | XX - perc
	$ID = "";
	$sql = "SELECT * FROM users WHERE ID = '".$_SESSION['session']."';";
	$result = mysqli_query($connection,$sql);
	if(mysqli_num_rows($result)==1)
	{
			$row = mysqli_fetch_array($result);
			$ID .= $row['surname'][0];
			$ID .= $row['firstname'][0];
			$userID = "000";
			$userID = substr($userID,0,strlen($userID)-strlen($row['ID']));
			$userID .= $row['ID'];
			$ID .= $userID;
			$ID .= date('H');
			$ID .= date('i');
			//echo $ID;
			$name = $row['surname']." ".$row['firstname'];
	}
	else
	{
		echo "Hiba történt";
		header("Location: index.php");
	}
	if(strlen($ID) == 9)
	{
		$total = 0;
		$text = "";
		for($i = 0; $i < count($_SESSION['pizza']);$i++)
		{
			$total = $total + (intval($_SESSION['pizza'][$i][0]) * intval($_SESSION['pizza'][$i][2]));
			$text .= $_SESSION['pizza'][$i][0]." x ".$_SESSION['pizza'][$i][3]." pizza ".($_SESSION['pizza'][$i][0] * $_SESSION['pizza'][$i][2])." Ft<br>";
		}
		$_SESSION['order'] = [$ID,$total,$text];
	}
}
?>
<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Megrendelés - Online pizza rendelés</title>
	<link rel="shortcut icon" href="../favicon.ico">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body>
  <main role='main' class='container' style='padding-top: 70px;'>
      <div class='class="col-sm-8 mx-auto' align="center">
			<div style="background-color:#eee;border:1px solid black; border-radius: 4px;">	
				<h1>Megrendelés</h1>
				<br>
				<form method="POST">
					<br>
					<input type="hidden" value="<?php echo (isset($id))?$id:'';?>" name="id">
					<div class="input-group" style="width:40%;">
						<span class="input-group-addon" id="basic-addon1">Név</span>
						<input type="text" class="form-control" placeholder="..." value="<?php echo (isset($name))?$name:''; ?>" aria-describedby="basic-addon1" name="name" style="width:400px;">
					 </div><br>
					 <div class="input-group" style="width:40%;">
						<span class="input-group-addon" id="basic-addon1">Cím</span>
						<input type="text" class="form-control" placeholder="..." aria-describedby="basic-addon1" name="add" style="width:400px;">
					 </div><br>
					<div class="input-group" style="width:40%;">
						<span class="input-group-addon" id="basic-addon1">Rendelés</span>
						<h2 class="form-control" aria-describedby="basic-addon1" name="text" style="width:400px;"><?php echo (isset($text))?$text:''; ?></h2>
					</div><br>
					<div class="input-group" style="width:40%;">
						<span class="input-group-addon" id="basic-addon1">Végösszesen</span>
						<h2 class="form-control" aria-describedby="basic-addon1" name="total" style="width:400px;"><?php echo (isset($total))?$total:''; ?> Ft</h2>
					</div>
					<input type="hidden" value="<?php echo (isset($ID))?$ID:''; ?>">
					<br>
					<button class='btn btn-outline-danger my-2 my-sm-0' type='submit' name='set'>Megrendelés</button>
					<br><br>
				</form>
			</div>
			<br>
			<a href="index.php" class="text-danger">Vissza a főoldalra</a>
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
if(isset($_POST['set']))
{
	$name = mysqli_real_escape_string($connection,$_POST['name']);
	$add = mysqli_real_escape_string($connection,$_POST['add']);
	
	if($add!= "")
	{
		if($name!= "")
		{
			#STATUS 0 - Készítés alatt | 1 - Szállítás alatt | 2 - Kézbesítve
			$sql = "INSERT INTO orders (ID,userID,name,address,date,message,total,status) VALUES ('".$_SESSION['order'][0]."','".$_SESSION['session']."','$name','$add','".date("Y-m-d H:i:s")."','".$_SESSION['order'][2]."','".$_SESSION['order'][1]."',0);";
			if ($connection->query($sql) === TRUE) {
				echo "<script>alert('Sikeres megrendelés! A rendelési azonosítód: ".$_SESSION['order'][0]."');</script>";
				unset($_SESSION['order']);
				unset($_SESSION['pizza']); 				
			}
			else
			{
				echo "Sikertelen megrendelés!";
			}
		}
		else
		{
			echo "Adj meg nevet!";
		}
	}
	else
	{
		echo "Adj meg címet!";
	}
}
?>