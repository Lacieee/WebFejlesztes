<?php 
	include_once 'database/database_handler.php';
	session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Linktár</title>
	<link rel="shortcut icon" href="favicon.ico">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body style='padding-bottom:5rem;padding-top: 4rem;'>
	<header>
		<nav class='navbar navbar-expand-md fixed-top navbar-dark bg-dark'>
		  <a class='navbar-brand' href='index.php'>Linktár</a>
		  <div class='collapse navbar-collapse' id='navbarsExampleDefault'>
			<ul class='navbar-nav mr-auto'>
			  <li class='nav-item active'>
				<?php 
				if(!isset($_SESSION['session']))
				{	
					?>
						<a class='nav-link' href='user/regist.php'>Regisztráció</a>
					<?php
				}
				?>
			  </li>
			</ul>
			<?php 
			if(!isset($_SESSION['session']))
			{
				$homeurl = '/12.13.1/user/regist.php';                               
				$currentpage = $_SERVER['REQUEST_URI'];
				$action = "user/login.php";
				if($currentpage == $homeurl) {
				
					$action = "login.php";
				}
				?>
			<form class='form-inline my-2 my-lg-0' method='POST' action='<?php echo $action; ?>'>
			  <input class='form-control mr-sm-2' type='text' placeholder='Felhasználónév' name='username'>
			  <input class='form-control mr-sm-2' type='password' placeholder='Jelszó' name='password'>
			  <button class='btn btn-outline-info my-2 my-sm-0' type='submit' name='login'>Bejelentkezés</button>
			</form>
				<?php
			}
			else
			{
				?>
				<!-- ÚJ LINK HOZZÁADÁSA -->
				<form class='form-inline'  method='POST' action='data/newlink.php' style="margin-right: 300px;">
					<div class="input-group" style="margin-right: 10px;">
						<span class="input-group-addon" id="basic-addon1">URL</span>
						<input type="text" name="newurl" class="form-control" placeholder="Link" aria-describedby="basic-addon1" style="width:400px;">
					</div> 
				    <button class='btn btn-outline-info my-2 my-sm-0' type="submit" name='newlink' >Hozzáadás</button>
				</form>
				<ul class='navbar-nav'>
					<li class='nav-item'>
						<a class='nav-link'>Jó, hogy újra itt vagy <?php echo $_SESSION['name']; ?></a>
					</li>
					<li>
						<a class='nav-link' href='user/logout.php'>Kijelentkezés</a>
					</li>
				</ul>
				<?php
			}
			?>
		  </div>
		</nav>
	</header>
	<?php 
			$homeurl = '/12.13.1/index.php';                               
			$homepage = '/12.13.1/';
			$currentpage = $_SERVER['REQUEST_URI'];
			if($currentpage == $homepage or $currentpage == $homeurl) {
				if(!isset($_SESSION['session']))
				{
					?>
					<div class='jumbotron'>
						<h1>Üdvözöllek a linktárban.</h1>
						<p>Jelentkezz be vagy regisztrálj, hogy használhasd a funkciókat.</p>
					</div>
					<?php
				}
				else
				{
					//HA BEJELENTKEZEL
				?>
	<div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar" id="sidenav">
          <ul class="nav nav-pills flex-column" >
			<!-- AZ AKTÍV GOMB A BTN A NEM AKTÍV A BTN-OUTLINE -->
            <li class="nav-item">
              <a class="nav-link btn-info" href="index.php">Összes</a>
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
								?>
								<li class="nav-item">
								  <a class="nav-link btn-outline-info menubtn" name="menubtn" href="#"><?php echo $row['name']; ?></a>
								  <input type="hidden" value="<?php echo $row['ID']; ?>" class="menuid">
								</li>
								<?php
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
        </nav>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <!--<h1>Legújabb linkek</h1>
          <section class="row text-center placeholders">
		  
            <div class="col-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Oldal ikonja">
              <h4>Név</h4>
              <div class="text-muted">Téma</div>
            </div>
          </section>
		<br>-->
			<!-- A TÉMA, ITT VÁLTOZIK -->
          <h2 id="themetag">Összes</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Név</th>
                  <th>Téma</th>
                  <th>Link</th>
				  <th>Oldal neve</th>
                  <th>Dátum</th>
				  <th>Műveletek</th>
                </tr>
              </thead>
			  <div id="message">
			  </div>
              <tbody id="list">
				<?php 
					if(isset($_SESSION['session']))
					{
						$sql = "SELECT * FROM links WHERE userID = '".$_SESSION['session']."' ORDER BY ID DESC LIMIT 10;";
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
              </tbody>
            </table>
			<div align="center">
				<!-- TÖBB LINK A LINKTÁRBÓL -->
				<button type="button" class="btn btn-outline-dark" id="morebtn" href="#">Több</button>
			</div>
			<br>
          </div>
		  <?php
		  				}
			}
		  ?>
      </div>
        </main>
      </div>
    </div>
    <footer style='z-index:1; position:fixed; display:block; right: 0; bottom: 0; left: 0; color: #333; background-color: #EEE; padding-left: 20px'>
		<hr>
      <p>&copy; Copyright - Kőváry László 2017</p>
    </footer>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js' integrity='sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script>		
		$(document).on('click', '.btndel', function(event){
					event.preventDefault();
					var id = $( this ).parent().find('[class*="id"]').first().val();
					var btndel = $('button[name=btndel]').val();
					$('#message').load('data/searchlink.php',{
						id:id,
						btndel: btndel
					});
					var btnsearch = "set";
					$('#list').load('data/searchlink.php',{
						btnsearch: btnsearch
					});
		});
		
		$(document).ready(function() {
				var commentCount = 10;
				$('#morebtn').click(function(){
					commentCount = commentCount +  10;
					$('#list').load('data/more.php',{
						commentNewCount: commentCount
					});
				});
		});
		
		
		$(document).on('click', '.menubtn', function(event){
					event.preventDefault();
					var id = $( this ).parent().find('[class*="menuid"]').first().val();
					var menubtn = $('a[name=menubtn]').val();
					$('#sidenav').load('menu.php',{
						id:id,
						menubtn: menubtn
					});
					var btntop = "set";
					$('#themetag').load('menu.php',{
						id:id,
						btntop: btntop
					});
					var btnsearch = "set";
					$('#list').load('menu.php',{
						id:id,
						btnsearch: btnsearch
					});
				});
	</script>
  </body>
</html>