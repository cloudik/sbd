<?php
require('namespace.php');

$title = 'Admin the countries';
show_header($title);

@$action = htmlspecialchars($_GET["action"]);
@$id_country = htmlspecialchars($_GET["id_country"]);
@$confirm = htmlspecialchars($_GET["confirm"]);

if(empty($_POST) && empty($action)) {

?>
			<div class="jumbotron">
				<h1>Administracja krajami</h1>
				<p>W tym miejscu możesz edytować listę krajów, dodawać nowe oraz usuwać już istniejące.</p>
				<p><a href="?action=add" class="btn btn-primary btn-lg" role="button">Dodaj nowy kraj</a></p>
			</div>
			
			<hr class="featurette-divider">
<?php
}
?>
	
	
		<div class="marketing">
<?php
		$country = new Country($dbms, $host, $database, $port, $username, $password);
		
		if(empty($_POST)) {

			if($action == 'edit' && !empty($id_country)) {
				$countryData = $country->getCountryData($id_country);
				$country->showCountryForm($countryData);
			}
			elseif($action == 'add') {
				@$country->showCountryForm();
			}
			elseif($action == 'delete' &&  !empty($id_country)) {
				$country->confirmRemoveCountry($id_country, $confirm);
			}
			else {
				$countryList = $country->getCountries();
				$country->showCountries($countryList);
			}
		
		}
		else {
		
			$countryArr['nazwa'] = $_POST['countryName'];
			$countryArr['img'] = $_POST['countryFlag'];
			$countryArr['akronym'] = $_POST['countryAcronym'];
			$countryArr['id_kraj'] = $_POST['countryID'];
			
			$country->validate($countryArr);
		
		}
		
?>
		</div>
	
	<div class="clr"></div>
	
<?php
show_footer();
	
?>