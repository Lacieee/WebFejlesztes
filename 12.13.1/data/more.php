<?php 
session_start();
include_once '../database/database_handler.php';
	$commentNewCount = $_POST['commentNewCount'];
					if(isset($_SESSION['session']))
					{
						$sql = "SELECT * FROM links WHERE userID = '".$_SESSION['session']."' ORDER BY ID DESC LIMIT $commentNewCount;";
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
									  <td>
										  <form method="POST" action="data/setlink.php">
											  <button data-toggle="tooltip" title="Módosítás" name="btnmod" type="submit">&#9881;</button>
											  <button data-toggle="tooltip" title="Törlés" class="btndel" name="btndel">&#9940;</button>
											  <input type="hidden" value="<?php echo $row['ID']; ?>" class="id" name="id">
										  </form>
										  
									  </td>
									</tr>
								<?php
							}
						}
						else
						{
							?>
								<div class='text-danger'><p>Nincsenek linkek</p></div>
							<?php
						}
					}
?>