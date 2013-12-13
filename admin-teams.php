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
	if ($action == 'edit_members') {
?>

			<div class="jumbotron">
				<h1>Dodaj zawodnika do drużyny</h1>
				<p></p>
				<p><a class="btn btn-primary btn-lg" href="?action=add_member&id_team=<?php echo $id_team;?>" role="button">Dodaj zawodnika</a></p>
			</div>
<?php	
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
				$druzyna->editTeamMembers($id_team, $action);
				break;
			case 'add_member';
				$druzyna->editTeamMembers($id_team, $action);
				break;
			default:
				$druzyna->selectTeams('edit');
				break;
		}
	}	
		
		
	if(!empty($_POST) && !empty($_POST['formType'])) {
		$druzyna->validate($_POST, $_POST['formType']);
		
		/*
		if($_POST['formType'] == 'teamform') 
			$druzyna->validate($_POST, $_POST['formType']);
		elseif($_POST['formType'] == 'association') {
			$druzyna->validate($_POST, $_POST['formType']);
		*/
	
	}
	

?>
		</div>
	
	<div class="clr"></div>
	
<?php
show_footer();
	
?>