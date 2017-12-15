<?php 

	session_start();
	include_once '../database/database_handler.php';
	if(isset($_POST['btnsearch']))
	{
		$theme = $_POST['theme'];
		$sql = "SELECT * FROM themes WHERE name LIKE '%$theme%' AND userID = '".$_SESSION['session']."';";
		$result = mysqli_query($connection,$sql);
		if(mysqli_num_rows($result)>=1)
		{
			while($row = mysqli_fetch_array($result))
			{
				?>
					<tr>
						<td><input type="text" name="name" value="<?php echo $row['name'] ?>" placeholder="<?php echo $row['name'] ?>" class='name'></td>
						<td style="text-align:right;"><button data-toggle="tooltip" title="Módosítás" type="submit" class="btnmod" name="btnmod" type="button">&#9881;</button>
						<button data-toggle="tooltip" title="Törlés"  type="submit" class="btndel" name="btndel" type="button">&#9940;</button>
						<input type="hidden" value="<?php echo $row['ID']; ?>" class="id" name="id"></td>
					</tr>
				<?php
			}
		}
		else
		{
			?>
				<p class="text-danger">Nincs a keresésnek megfelelő téma.</p>
			<?php
		}
	}

	if(isset($_POST['btnmod']))
	{
		$id = $_POST['id'];
		$name = mysqli_real_escape_string($connection,$_POST['name']);
		if($name != "")
		{
			$sql = "SELECT * FROM themes WHERE userID = '".$_SESSION['session']."' AND name = '".$name."';";
			$result = mysqli_query($connection,$sql);
			if(mysqli_num_rows($result)<1)
			{
				$sql = "UPDATE themes SET name = '".$name."' WHERE ID = '".$id."';";
				if ($connection->query($sql) === TRUE) {
					?>
					<p class='text-success'>Sikeres módosítás.</p>
					<?php
				}
				else
				{
					?>
					<p class='text-danger'>Sikertelen móodsítás.</p>
					<?php
				}
			}
			else
			{
				?>
				<p class='text-warning'>Ez a téma már létezik.</p>
				<?php
			}
		}
	}

	if(isset($_POST['btndel']))
	{
		$id = $_POST['id'];
		$sql = "DELETE FROM themes WHERE ID = '".$id."';";
		if ($connection->query($sql) === TRUE) {
			?>
			<p class='text-success'>Sikeres törlés.</p>
			<?php
		}
		else
		{
			?>
			<p class='text-danger'>Sikertelen törlés.</p>
			<?php
		}
	}
?>