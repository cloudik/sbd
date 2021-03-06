<?php
require('namespace.php');

@$id_player = htmlspecialchars($_GET["id_player"]);
if(!is_numeric($id_player)) 
	$id_player = 'all';

$title = 'Meet the players';
show_header($title);

if(!is_numeric($id_player)) {
?>
			<div class="jumbotron">
				<h1>Zawodnicy</h1>
				<p>W tym miejscu możesz sprawdzić szczegóły dotyczące zawodników.</p>
				<p><a class="btn btn-primary btn-lg" href="#list" role="button">Więcej</a></p>
				<p>
					<form role="form" action="player.php" method="post">
					  <div class="form-group">
						<input type="text" class="form-control" name="nameSearch" id="nameInput" placeholder="Nazwisko zawodnika">
					  </div>
					  <button type="submit" class="btn btn-default">Szukaj</button>
					</form>
				<p>	
			</div>

		<hr class="featurette-divider">
<?php
}
?>	
		<div class="marketing" id="list">
	
<?php


$zawodnik = new Player($dbms, $host, $database, $port, $username, $password);


$total = $zawodnik->numberOfPlayers();

if(!empty($_POST)) {
	$searchName = htmlspecialchars($_POST['nameSearch']);
	if(!empty($searchName)) {
		$zawodnik->searchPlayer($searchName);
	}	
}
else {
	// && ($id_player <= $total)
	if(is_numeric($id_player)) {
		echo '
			<div class="col-lg-4">
		';
			$zawodnik->selectPlayer($id_player);
		echo '
			</div>
		';	
	}
	else {
		//$zawodnik->selectAll();
		@$zawodnik->selectSurnames();
	}
}
?>	
	</div>
	
	<div class="clr"></div>
	
<?php
show_footer();
	
?>