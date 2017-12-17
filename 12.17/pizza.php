<?php
session_start();
include_once 'database/database_handler.php';

if(isset($_POST['menubtn']))
{
	if(isset($_SESSION['pizza']))
	{
		$id = mysqli_real_escape_string($connection,$_POST['id']);
		?>
		<a href="#" class="btn btn-danger">Kosár</a>
		<?php
		$hozza = true;
		for($i = 0; $i < count($_SESSION['pizza']);$i++)
		{
			if($_SESSION['pizza'][$i][1] == $id)
			{
				$_SESSION['pizza'][$i][0]++;
				$hozza = false;
			}
			else
			{
				
			}
			$sql = "SELECT * FROM pizzas WHERE ID = '".$_SESSION['pizza'][$i][1]."';";
			$result = mysqli_query($connection,$sql);
			if(mysqli_num_rows($result)==1)
			{
				$row = mysqli_fetch_array($result)
				?>
				<a class="list-group-item text-danger"><?php echo $_SESSION['pizza'][$i][0]; ?>x <?php echo $row['name']; ?> pizza</a>
				<?php
			}
			else
			{
				echo "Hiba történt";
			}
		}
		if($hozza)
		{
			$sql = "SELECT * FROM pizzas WHERE ID = '$id';";
			$result = mysqli_query($connection,$sql);
			if(mysqli_num_rows($result)==1)
			{
				$row = mysqli_fetch_array($result)
				?>
				<a class="list-group-item text-danger"><?php echo "1"; ?>x <?php echo $row['name']; ?> pizza</a>
				<?php
				# 0 - mennyiség || 1 - pizzaID 
				$_SESSION['pizza'][count($_SESSION['pizza'])] = array(1,$row['ID'],$row['price'],$row['name']);
			}
			else
			{
				echo "Hiba történt";
			}
		}
		?>
		<form method="POST" action="order.php"><button type="submit" name="orderbtn" class='btn btn-danger orderbtn'>Megrendelem</button></form>
		<?php
	}
	else
	{
		
		$id = mysqli_real_escape_string($connection,$_POST['id']);
		$sql = "SELECT * FROM pizzas WHERE ID = $id;";
		$result = mysqli_query($connection,$sql);
		if(mysqli_num_rows($result)==1)
		{
			$row = mysqli_fetch_array($result);
			?>
			<a href="#" class="btn btn-danger">Kosár</a>
			<a class="list-group-item text-danger"><?php echo "1"; ?>x <?php echo $row['name']; ?> pizza</a>
			<form method="POST" action="order.php"><button type="submit" name="orderbtn" class='btn btn-danger orderbtn'>Megrendelem</button></form>
			<?php
			# 0 - mennyiség || 1 - pizzaID || 2 - egységár || 3 - név
			$_SESSION['pizza'][0] = array(1,$row['ID'],$row['price'],$row['name']);
		}
		else
		{
			echo "Hiba történt";
		}
	}	
}
?>