<?php 
/**************************************************************************************/
/* list of functions
/* function show_header($title)
/* function show_footer()
/*
/*
/*
/**************************************************************************************/
function show_header($title) {
echo '<!DOCTYPE html>
<html>
  <head>
    <title>'.$title.'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/sbd.css" rel="stylesheet">
	<meta charset="UTF-8">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
	
	<div class="navbar-wrapper">
		<div class="container">
			<div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="/sbd/" class="navbar-brand">Curling</a>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<!--<li class="active"><a href="/sbd/">home</a></li>-->
							<!--<li><a href="live.php">live</a></li>-->
							<li><a href="games.php">mistrzostwa</a></li>
							<li><a href="team.php">drużyny</a></li>
							<li><a href="player.php">zawodnicy</a></li>
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">administracja <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="admin-games.php">Administracja zawodami / meczami</a></li>
									<li><a href="admin-teams.php">Administracja drużynami</a></li>
									<li><a href="admin-players.php">Administracja zawodnikami</a></li>
									<li><a href="admin-countries.php">Administracja krajami</a></li>
									<li class="divider"></li>
									<li class="dropdown-header">Szybki dostęp</li>
									<li><a href="admin-games.php">Dodaj mecz/wynik</a></li>
									<li><a href="admin-players.php?action=add">Dodaj zawodnika</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">

';

}
/**************************************************************************************/

/**************************************************************************************/
function show_footer() {
echo '
		<hr class="featurette-divider">

		<footer>
			<p class="pull-right"><a href="#">Do góry</a></p>
			<p>&copy; 2013 SBD. · <a href="#">Ustawienia prywatności</a></p>
		</footer>
	
	</div>

	
	
	  
    <!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
';
}
?>