<?php
require('namespace.php');

$title = 'Meet the teams';
show_header($title);

@$id_team = htmlspecialchars($_GET["id_team"]);

if(empty($id_team)) {
?>


<div class="jumbotron">
				<h1>Drużyny</h1>
				<p>Poniżej znajdują się wszystkie drużyny, aby dowiedzieć się wiecej - typ drużyny, obecni i byli zawodnicy - po prostu wybierz interesującą cię drużynę.</p>
				<p><a class="btn btn-primary btn-lg" href="#list" role="button">Więcej</a></p>
			</div>

		<hr class="featurette-divider">

<?php
}		
?>		
		<div class="marketing" id="list">
	
<?php
$druzyna = new Team($dbms, $host, $database, $port, $username, $password);

if($id_team)
	$druzyna->selectSingleTeam($id_team);
else
	@$druzyna->selectTeams();

?>	
	</div>
	
	<div class="clr"></div>
	
<?php
show_footer();
	
?>