<?php
include_once 'database/database_handler.php';
session_start();
if(isset($_POST['menubtn']))
{
	$id = mysqli_real_escape_string($connection,$_POST['id']);
	?>
	<!-- AZ AKTÍV GOMB A BTN A NEM AKTÍV A BTN-OUTLINE -->
		<ul class="nav nav-pills flex-column" >
            <li class="nav-item">
              <a class="nav-link btn-outline-info" href="index.php">Összes</a>
            </li>
			<!-- IDE KERÜL A PHP AMI BETÖLTI A TÉMÁKAT -->
			<?php 
					if(isset($_SESSION['session']))
					{
						$sql = "SELECT * FROM themes WHERE userID = '".$_SESSION['session']."' ORDER BY ID;";
						$result = mysqli_query($connection,$sql);
						if(mysqli_num_rows($result)>=1)
						{
							while($row = mysqli_fetch_array($result))
							{
								if($row['ID'] == $id)
								{
									?>
									<li class="nav-item">
									  <a class="nav-link btn-info menubtn" name="menubtn" href="#"><?php echo $row['name']; ?></a>
									  <input type="hidden" value="<?php echo $row['ID']; ?>" class="menuid">
									</li>
									<?php
								}
								else
								{
								?>
								<li class="nav-item">
								  <a class="nav-link btn-outline-info menubtn" name="menubtn" href="#"><?php echo $row['name']; ?></a>
								  <input type="hidden" value="<?php echo $row['ID']; ?>" class="menuid">
								</li>
								<?php
								}
							}
						}
					}
				?>
			<li class="nav-item">
              <a class="nav-link btn-outline-dark" href="data/theme.php">&#9729; Új téma</a>
            </li>
			<li class="nav-item">
              <a class="nav-link btn-outline-dark" href="data/settheme.php">&#9881; Téma módosítása</a>
            </li>
		</ul>
	<?php
}

if(isset($_POST['btntop']))
{
	$id = mysqli_real_escape_string($connection,$_POST['id']);
	$sql = "SELECT * FROM themes WHERE userID = '".$_SESSION['session']."' AND ID = '".$id."';";
	$result = mysqli_query($connection,$sql);
	if(mysqli_num_rows($result)==1)
	{
		$row = mysqli_fetch_array($result);
		echo $row['name'];
	}
}

if(isset($_POST['btnsearch']))
	{
		$id = mysqli_real_escape_string($connection,$_POST['id']);
		$sql = "SELECT * FROM links WHERE userID = '".$_SESSION['session']."' AND themeID = '".$id."';";
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
?>