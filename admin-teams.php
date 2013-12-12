<?php
require('namespace.php');

$title = 'Edit the teams';
show_header($title);

@$action = htmlspecialchars($_GET["action"]);
@$id_team = htmlspecialchars($_GET["id_team"]);
@$confirm = htmlspecialchars($_GET["confirm"]);

 
if(empty($_POST) && empty($action)) {
?>
			<div class="jumbotron">
				<h1>Administracja drużynami</h1>
				<p>W tej części możesz administrować drużynami: dodawać, usuwać lub po prostu wyświetlić ich dane.</p>
				<p>Możesz też wybrać drużynę z <a href="#list">poniższej listy</a>.</p>
				<p><a class="btn btn-primary btn-lg" href="?action=add" role="button">Dodaj drużynę</a></p>
			</div>
<?php
}
else {
	if ($action == 'add') {
?>
			<div class="jumbotron">
				<h1>Dodaj nową drużynę</h1>
				<p>Uzupełnij dane dotyczące nowej drużyny. Wszystkie pola są obowiązkowe.</p>
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
	$druzyna = new Team($dbms, $host, $database, $port, $username, $password);

	
	if(($action == 'edit') && ($id_team != '')) {
		$druzyna->editSingleTeam($id_team, $action);
	}
	
	elseif(empty($_POST)) {
		switch($action) {
			case 'edit':
				$druzyna->selectTeams($action);
				break;
			case 'add':
				@$druzyna->showTeamForm();
				break;
			case 'delete';
				$druzyna->confirmRemoveTeam($id_team, $confirm);
				break;
			case 'edit_members';
				$druzyna->editTeamMembers($id_team);
				break;
			default:
				$druzyna->selectTeams('edit');
				break;
		}
	}	
		
		
	if(!empty($_POST)) {
		
		if($_POST['formType'] == 'teamform') 
			$druzyna->validate($_POST, $_POST['formType']);
		elseif($_POST['formType'] == 'association') {
			$druzyna->validate($_POST, $_POST['formType']);

			
			
		}	
	}
	

?>
		</div>
	
	<div class="clr"></div>
	
<?php
show_footer();
	
?>