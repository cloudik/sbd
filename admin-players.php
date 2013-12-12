<?php
require('namespace.php');

$title = 'Admin the players';
show_header($title);

@$action = htmlspecialchars($_GET["action"]);
@$id_player = htmlspecialchars($_GET["id_player"]);
@$confirm = htmlspecialchars($_GET["confirm"]);

 
if(empty($_POST) && empty($action)) {
?>
			<div class="jumbotron">
				<h1>Administracja zawodnikami</h1>
				<p>W tej części możesz administrować zawodnikami: dodawać, usuwać lub po prostu wyświetlić ich dane.</p>
				<p>Możesz też wybrać zawodnika z <a href="#list">poniższej listy</a>.</p>
				<p><a class="btn btn-primary btn-lg" href="?action=add" role="button">Dodaj zawodnika</a></p>
			</div>
<?php
}
else {
	if ($action == 'add') {
?>
			<div class="jumbotron">
				<h1>Dodaj nowego zawodnika</h1>
				<p>Uzupełnij dane dotyczące nowego zawodnika. Wszystkie pola są obowiązkowe.</p>
				<p>Dodawanie zdjęć przez formularz jest w tej chwili wyłączone. Aby dodać nowe zdjęcie - skontaktuj się z administratorem.</p>
			</div>
<?php
	}
	if ($action == 'edit') {
	
	}
} // end of 'else' for empty($_POST); jumbotron section
?>

		
		<div class="marketing" id="list">
<?php


	$zawodnik = new Player($dbms, $host, $database, $port, $username, $password);

	
	if(($action == 'edit') && ($id_player != '')) {
		$zawodnik->editSinglePlayer($id_player, $action);
	}
	
	elseif(empty($_POST)) {
		switch($action) {
			case 'edit':
				$zawodnik->selectSurnames($action);
				break;
			case 'add':
				@$zawodnik->showPlayerForm();
				break;
			case 'delete';
				$zawodnik->confirmRemovePlayer($id_player, $confirm);
				break;
			default:
				$zawodnik->selectSurnames('edit');
				break;
		}
	}	
		
		
	if(!empty($_POST)) {
		$zawodnik->validate($_POST);
	}
?>
		</div>
	
	<div class="clr"></div>
	
<?php


show_footer();
	
?>