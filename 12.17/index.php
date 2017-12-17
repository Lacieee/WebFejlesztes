<?php 
	include_once 'database/database_handler.php';
	session_start();
	#session_destroy();
?>
<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Online pizza rendelés</title>
	<link rel="shortcut icon" href="favicon.ico">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body style='padding-bottom:5rem;padding-top: 4rem;'>
	<header>
		<nav class='navbar navbar-expand-md fixed-top navbar-light bg-light'>
		  <a class='navbar-brand' href='index.php'>Online pizza rendelés</a>
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
			  <button class='btn btn-outline-danger my-2 my-sm-0' type='submit' name='login'>Bejelentkezés</button>
			</form>
				<?php
			}
			else
			{
				?>
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
			$homeurl = '/12.17/index.php';                               
			$homepage = '/12.17/';
			$currentpage = $_SERVER['REQUEST_URI'];
			if($currentpage == $homepage or $currentpage == $homeurl) {
			?>
	<main role="main" class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-12 col-md-9">
		  <section class="jumbotron text-center">
			<div class="container">
			  <h1 class="jumbotron-heading text-danger">Laci pizzázója</h1>
			  <p class="lead text-muted">Online pizzarendelési felület. Regisztrálj és jelentkezz be a kényelmes rendelésért.</p>
			</div>
		  </section>

		  <div class="album text-muted">
			<div class="container">

			  <div class="row">
				<?php
					$sql = "SELECT * FROM pizzas ORDER BY name LIMIT 10;";
					$result = mysqli_query($connection,$sql);
					if(mysqli_num_rows($result)>0)
					{
						$num = 1;
						while($row = mysqli_fetch_array($result))
						{
					
						?>
							<div class="col-6 col-lg-4" style="position: relative; text-aling: center; word-break: break-all; height: 325px;" align="center">
							  <img style="width:200px;border-radius:50%;" src="pizza/<?php echo $row['image'] ?>" alt="<?php echo $row['name'] ?>">
							  <h2 class="card-text"><?php echo $row['name'] ?></h2>
							  <p class="card-text"><?php echo $row['data'] ?></p>
							  <div class="input-group" style="position: absolute; bottom: 15px; left: 25%;">
								  <span class="input-group-addon" id="basic-addon<?php echo $num; ?>"><?php echo $row['price'] ?> Ft</span>
								  <input type="submit" class="btn btn-outline-danger menubtn" name="menubtn" aria-describedby="basic-addon<?php echo $num; ?>">
								  <input type="hidden" value="<?php echo $row['ID'] ?>" class="menuid" name="id">
							  </div>
							</div>
						<?php
						$num++;
						}
					}
				?>
			  </div>

			</div>
		  </div>
	  </div>
		  <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
			  <div class="list-group" id="sidenav">
				<a href="#" class="btn btn-danger">Kosár</a>
				<?php
				if(isset($_SESSION['pizza']))
				{
					for($i = 0; $i < count($_SESSION['pizza']);$i++)
						{
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
						?>
						<form method="POST" action="order.php"><button type="submit" name="orderbtn" class='btn btn-danger orderbtn'>Megrendelem</button></form>
						<?php
				}
				else
				{
					?>
						<a href="#" class="list-group-item text-danger">A kosár még üres</a>
					<?php
				}?>
			  </div>
			</div><!--/span-->
		  </div><!--/row-->
	  </div>
    </main>
	<?php
	}
	?>
    <footer style='z-index:1; position:fixed; display:block; right: 0; bottom: 0; left: 0; color: #333; background-color: #EEE; padding-left: 20px'>
		<hr>
      <p>&copy; Copyright - Kőváry László 2017</p>
    </footer>
	<script>
				$(document).on('click', '.menubtn', function(event){
					event.preventDefault();
					var id = $( this ).parent().find('[class*="menuid"]').first().val();
					var menubtn = $( this ).parent().find('[class*="menubtn"]').first().val();
					$('#sidenav').load('pizza.php',{
						id:id,
						menubtn: menubtn
					});
				});
	</script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js' integrity='sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  </body>
</html>