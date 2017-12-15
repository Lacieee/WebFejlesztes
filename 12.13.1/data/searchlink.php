<?php 

	session_start();
	include_once '../database/database_handler.php';
	if(isset($_POST['btnsearch']))
	{
		$sql = "SELECT * FROM links WHERE userID = '".$_SESSION['session']."' LIMIT 10;";
		$result = mysqli_query($connection,$sql);
		if(mysqli_num_rows($result)>=1)
		{
			while($row = mysqli_fetch_array($result))
			{
				?>
					<tr>
									  <td><?php echo $row['name']; ?></td>
									  <?php 
										$newsql = "SELECT * FROM themes WHERE userID = '".$_SESSION['session']."' AND ID = '".$row['themeID']."'";
										$newresult = mysqli_query($connection,$newsql);
										if(mysqli_num_rows($newresult) == 1)
										{
											while($newrow = mysqli_fetch_array($newresult))
											{
												?>
												<td><?php echo $newrow['name']; ?></td>
												<?php
											}
										}
										else
										{
											?>
											<td>-</td>
											<?php
										}
									  ?>
									  <td><a target="_blank" title="<?php echo $row['link']; ?>" href="<?php echo $row['link']; ?>"><?php if(strlen($row['link'])>40){ echo substr($row['link'],0,47)."...";} else { echo $row['link']; } ?></a></td>
									  <td><?php echo $row['page']; ?></td>
									  <td><span><?php echo $row['date']; ?></span></td>
									  <td><button style="right:0;" data-toggle="tooltip" title="Módosítás" type="submit" class="btnmod" name="btnmod" type="button">&#9881;</button>
									<button style="right:0;" data-toggle="tooltip" title="Törlés"  type="submit" class="btndel" name="btndel" type="button">&#9940;</button>
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

	if(isset($_POST['btndel']))
	{
		$id = $_POST['id'];
		$sql = "DELETE FROM links WHERE ID = '".$id."';";
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