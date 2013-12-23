<?php
require('namespace.php');

$title = 'Show the games';
show_header($title);

@$id_tournament = htmlspecialchars($_GET["id_tournament"]);
@$id_game = htmlspecialchars($_GET["id_game"]);
@$show = htmlspecialchars($_GET["show"]);

if(empty($id_tournament)) {
?>
			<div class="jumbotron">
				<h1>Turnieje i mistrzostwa</h1>
				<p>Sprawdź wyniki!</p>
				<p></p>
				<a class="btn btn-primary btn-lg" href="?show=active" role="button">Pokaż aktywne</a>
				<a class="btn btn-primary btn-lg" href="?show=past" role="button">Pokaż zakończone</a>
				<a class="btn btn-primary btn-lg" href="?show=all" role="button">Pokaż wszystkie</a>
			</div>
<?php
}		
			?>			
			
			<div class="marketing">
			

<?php
$zawody = new Tournament($dbms, $host, $database, $port, $username, $password);

	if(!empty($id_tournament)) {
		$zawody->showAllGames($id_tournament);
	
	}

	if(!empty($show)) {
		if($show == 'active')
			$status = 'active';
		elseif($show == 'past')
			$status = 'past';
		else 
			$status = NULL;
			
		@$activeTourmanets = $zawody->showAll($status);
		
		$zawody->showTournamentData($activeTourmanets, $status);
	}




?>
			</div>
<?php	
	show_footer();
	
?>