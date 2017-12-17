<?php 
	include_once 'database/database_handler.php';
	session_start();
?>
<!doctype html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Pénzügyek</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body style='padding-bottom:50px;'>
    <nav class='navbar navbar-expand-md fixed-top navbar-dark bg-dark'>
      <a class='navbar-brand' href='index.php'>Főoldal</a>
      <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarsExampleDefault' aria-controls='navbarsExampleDefault' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
      </button>
      <div class='collapse navbar-collapse' id='navbarsExampleDefault'>
        <ul class='navbar-nav mr-auto'>
          <li class='nav-item active'>
			<?php 
			if(!isset($_SESSION['session']))
			{	
				echo "
					<a class='nav-link' href='regist.php'>Regisztráció <span class='sr-only'>(current)</span></a>";
			}
			?>
          </li>
        </ul>
		<?php 
		if(!isset($_SESSION['session']))
		{
			echo "
        <form class='form-inline my-2 my-lg-0' method='POST' action='login.php'>
          <input class='form-control mr-sm-2' type='text' placeholder='Felhasználónév' name='username'>
		  <input class='form-control mr-sm-2' type='password' placeholder='Jelszó' name='password'>
          <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='login'>Bejelentkezés</button>
        </form>";
		}
		else
		{
			echo "<ul class='navbar-nav'><li class='nav-item'><a class='nav-link'>Jó, hogy újra itt vagy ".$_SESSION['name']."</a></li><li><a class='nav-link' href='logout.php'>Kijelentkezés <span class='sr-only'>(current)</span></a></li></ul>";
		}
		?>
      </div>
    </nav>
    <main role='main' class='container' style='padding-top: 70px;'>
      <div class='class="col-sm-8 mx-auto' align="center">
			<?php 
			$homeurl = '/12.12/index.php';                               
			$homepage = '/12.12/';
			$currentpage = $_SERVER['REQUEST_URI'];
			if($currentpage == $homepage or $currentpage == $homeurl) {
				if(!isset($_SESSION['session']))
				{
					echo "
					<div class='jumbotron'>
						<h1>Üdvözöllek a pénzügyi kezelőfelületen.</h1>
						<p>Jelentkezz be vagy regisztrálj, hogy használhasd a funkciókat.</p>
					</div>";
				}
				else
				{
					if($_SESSION['money'] == "unset")
					{
						echo "<div class='jumbotron'><h3>Add meg a kezdőösszeget, hogy használhasd a funkciókat.</h3>
								<form align='center' class='form-inline' method='POST' action='total.php'>
								  <p style='width:100%;'>
									<input class='form-control mr-sm-2' type='text' placeholder='Összeg' name='newtotal'>
									<button id='btn-total' name='btn-submit' class='btn btn-info'>Hozzáad</button>
								  </p>
								</form></div>";	
					}
					else
					{
						$total = $_SESSION['money'];
						echo "
							<div class='jumbotron'>
								<h2 id='total-mon'>Jelenlegi összeg: ".$total." .-HUF</h2><br><hr><br>
								<form align='center' class='form-inline' method='POST' action='money.php'>
								  <p style='width:100%;'>
									<input class='form-control mr-sm-2' type='text' placeholder='Összeg' name='upmoney'>
									<button id='btn-up' name='btn-up' class='btn btn-info'>Befizetés</button>
								  </p>
								  <p style='width:100%;'>
									<input class='form-control mr-sm-2' type='text' placeholder='Összeg' name='downmoney'>
									<button id='btn-down' name='btn-down' class='btn btn-danger'>Levonás</button>
								  </p>
								</form>
							</div>"; 
					}
				}
			}
		  ?>
		<?php 
		if(isset($_SESSION['session']))
		{
			?>
		<div class='table-responsive'>
            <table class='table table-striped'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Dátum</th>
                  <th>Pénzfolyás</th>
                  <th>Teljes összeg</th>
                </tr>
              </thead>
              <tbody id='mon-data'>
				<?php
					$x = 1;
					$sql = "SELECT * FROM money WHERE userID = '".$_SESSION['session']."' ORDER BY date DESC LIMIT 10;";
					$result = mysqli_query($connection,$sql);
					if(mysqli_num_rows($result)>=1)
					{
						while($row = mysqli_fetch_assoc($result))
						{
				echo '
                <tr>
                  <td>'.$x.'</td>
                  <td>'.$row['date'].'</td>
                  <td>'.$row['value'].'</td>
                  <td>'.$row['total'].'</td>
                </tr>
				';
					$x = $x + 1;
						}
					}
				?>
              </tbody>
            </table>
          </div>
		  <?php 
		  }
		  ?>
		<script>
			$(document).ready(function() {
				$('#btn-up').click(function(event){
					event.preventDefault();
					var money = $('input[name=upmoney]').val();
					var btnup = $('button[name=btn-up]').val();
					$('#mon-data').load('money.php',{
						money:money,
						btnup: btnup
						
					});
					var btnfresh = "Fresh";
					$('#total-mon').load('money.php',{
						btnfresh:btnfresh
					});
				});
			});
	</script>
	<script>
			$(document).ready(function() {
				$('#btn-down').click(function(event){
					event.preventDefault();
					var money = $('input[name=downmoney]').val();
					var btndown = $('button[name=btn-down]').val();
					$('#mon-data').load('money.php',{
						money:money,
						btndown: btndown
					});
					var btnfresh = "Fresh";
					$('#total-mon').load('money.php',{
						btnfresh:btnfresh
					});
				});
			});
	</script>
      </div>	  
    </main>
    <footer style='z-index:1; position:fixed; display:block; right: 0; bottom: 0; left: 0; color: #333; background-color: #EEE; padding-left: 20px'>
		<hr>
      <p>&copy; Copyright - Kőváry László 2017</p>
    </footer>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js' integrity='sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ' crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js' integrity='sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh' crossorigin='anonymous'></script>
  </body>
</html>