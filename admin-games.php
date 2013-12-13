<?php
require('namespace.php');

$title = 'Admin the games';
show_header($title);

@$action = htmlspecialchars($_GET["action"]);
@$id_tournament = htmlspecialchars($_GET["id_tournament"]);
@$confirm = htmlspecialchars($_GET["confirm"]);
@$show = htmlspecialchars($_GET["show"]);
?>

			<div class="jumbotron">
				<h1>Administracja zawodami</h1>
				<p>W tej części możesz administrować zawodami: dodawać, usuwać lub po prostu wyświetlić ich dane.</p>
				<p></p>
				<a class="btn btn-primary btn-lg" href="?action=addTournament" role="button">Dodaj zawody</a>
				<a class="btn btn-primary btn-lg" href="?show=active" role="button">Pokaż aktywne</a>
				<a class="btn btn-primary btn-lg" href="?show=past" role="button">Pokaż zakończone</a>
				<a class="btn btn-primary btn-lg" href="?show=all" role="button">Pokaż wszystkie</a>
			</div>
			<div class="marketing">
<?php
	$zawody = new Tournament($dbms, $host, $database, $port, $username, $password);
	
	if(!empty($_POST)) {
		$zawody->debug($_POST);
		if(isset($_POST['submit'])) {
			$zawody->validate($_POST, $_POST['formType']);
			}
		if(isset($_POST['delete']))
			$zawody->showTournamentForm($_POST, 'delete');	
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
	if(!empty($action)) {
		if(!empty($_POST)) 
			$data = $_POST;
		else 
			$data = NULL;
			
		$zawody->showTournamentForm($data, $action);
	}
	//$zawody->debug($activeTourmanets);
?>
			</div>
<?php	
	show_footer();
	
?>