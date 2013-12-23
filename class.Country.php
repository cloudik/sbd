<?php

/*****************************************************************************************/
	
class Country extends Baza {
    function getCountries() {
        $stmt = $this->pdo->query('select * from kraj');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
    }
	
	function showCountries($list) {
		
		foreach ($list as $key => $value) {
			
			echo '
					<div class="col-lg-4">
						<img src="'.$value['img'].'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
						<h2><a href="?id_country='.$value['id_kraj'].'&action=edit">'.$value['nazwa'].'</a></h2>
						<p><!--Donec sed odio dui.--></p>
			';		
			
				echo '
						<p><a class="btn btn-default" href="?id_country='.$value['id_kraj'].'&action=edit" role="button">Zobacz więcej »</a></p>
				';
			
			echo '
					</div><!-- /.col-lg-4 -->

			';
		}
	
	}
	
	function getCountryData($id_country) {
		$stmt = $this->pdo->query('select * from kraj where id_kraj='.$id_country);
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
	}
	
	function showCountryForm($country) {
		
		$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		
		if(!empty($country)) 
			$src = $country['img'];
		
		echo '
						<div class="col-lg-4">
							<img alt="140x140" data-src="holder.js/140x140" class="img-circle" style="width: 140px; height: 140px;" src="'.$src.'">
							<h2>'.$country['nazwa'].'</h2>
						</div>
		
		';
		
		echo '
						<div class="col-lg-4">
							
								<form method="post" action="admin-countries.php" role="form">
								
									<div class="form-group">
										<label for="countryName">Nazwa:</label>
										<input type="text" value="'.$country['nazwa'].'" name="countryName" class="form-control">
									</div>
									<div class="form-group">
										<label for="countryFlag">Adres pliku:</label>
										<input type="text" value="'.$country['img'].'" name="countryFlag" class="form-control">
									</div>
									<div class="form-group">
										<label for="countryAcronym">Akronym:</label>
										<input type="text" value="'.$country['akronym'].'" name="countryAcronym" class="form-control">
									</div>
									
									
									<div class="form-group">
										<label for="countryID"></label>
										<input type="hidden" value="'.$country['id_kraj'].'" name="countryID" class="form-control">
									</div>
									
									<div class="form-group">
										<label for="fileInput">Dodaj nowe zdjęcie:</label>
										<input type="file" disabled="" id="fileInput">
										<p class="help-block">W tej chwili opcja jest niedostępna. Aby dodać zdjęcie skontaktuj się z administratorem.</p>
									</div>
								
									
								
									<button class="btn btn-success" type="submit">Zapisz</button>
									<a class="btn btn-default" href="admin-countries.php">Anuluj</a>
								</form>
									
							</div>
		
		';
		if($_GET['action'] != 'add') {
			echo '
		
							<div class="col-lg-4">
									<hr class="featurette-divider">
									<!--<h2>Heading</h2>-->
									<p>Aby usunąć kraj wciśnij poniższy przycisk. Uwaga: usunięcie kraju jest nieodwracalne.</p>
									<a class="btn btn-danger" href="?action=delete&id_country='.$country['id_kraj'].'">Usuń kraj</a>
									<hr class="featurette-divider">
							</div>
			';
		}
	}
	
	function validate($country) {

		$flag = 0;
		foreach ($country as $key => $value) {
			if(empty($value) && $key !='id_kraj') {
				echo '
					<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona</div>
				';
				$flag = 1;
			}
		}
		
		if($flag) {
			$this->showCountryForm($country);
		}
		else
			$this->updateCountry($country);
			
	}
	
	function updateCountry($country) {
		
		if(empty($country['id_kraj'])) {
			$action = 'insert';
		}
		else 
			$action = 'edit';
	
		if ($action == 'insert') {
			try {
				$sql = 'insert into kraj (`nazwa`, `img`, `akronym`) values (\''.$country['nazwa'].'\', \''.$country['img'].'\', \''.$country['akronym'].'\')';
				//$result
				$result = $this->pdo->exec($sql);
				if($result > 0) {
					echo '
					<div class="alert alert-success">Pomyślnie dodano kraj: '.$country['nazwa'].'</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas dodawania rekorów.</div>
					';
				}
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
		}
		elseif ($action == 'edit') {
			try {
				$sql = 'update  kraj set `nazwa`=\''.$country['nazwa'].'\', `img`=\''.$country['img'].'\', `akronym`=\''.$country['akronym'].'\' where id_kraj='.$country['id_kraj'];
				
				$result = $this->pdo->exec($sql);
				if($result > 0) {
					echo '
					<div class="alert alert-success">Pomyślnie dodano kraj: '.$country['nazwa'].'</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas edytowania rekorów.</div>
					';
				}
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
		}
		echo '
			<div>Powrót do <a href="admin-countries.php">strony administracyjnej krajami</a>.</div>
		';
		//echo $sql;
	}
	
	function confirmRemoveCountry($id_country, $confirm) {
		
		if($confirm != '1') {
			//$this->selectCountry($id_country);
			echo '
				<div class="col-lg-4">
					<p>Czy na pewno <strong>chcesz usunąć</strong> ten kraj?</p>
					<p><strong>Uwaga:</strong> zostaną także usunięte dane dotyczące użytkownika oraz jego powiązań z drużynami w których grał. Może to skutkować niepełnymi danymi w innych wynikach.</p>
					<a type="button" href="?action=delete&id_country='.$id_country.'&confirm=1" class="btn btn-danger">Usuń (brak cofnięcia akcji)</a>
					<a type="button" href="?action=edit&id_country='.$id_country.'" class="btn btn-default">Anuluj</a>
				</div>';
		}	
		else {
			$this->removeCountry($id_country);
		}
	}

	function removeCountry($id_country) {
		// check if there are any players associated with this country
		$try_sql = 'select count(*) from zawodnik where id_kraj='.$id_country;
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		//clean field of country id for player
		if($row[0] >= 1) {
			try {
				$sql = 'update zawodnik set `id_kraj`=NULL where id_kraj='.$id_country;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result > 0) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto powiązania zawodników z krajem.</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas usuwania rekorów.</div>
					';
				}
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
		}
		
		// check if country exists
		$try_sql = 'select count(*) from kraj where id_kraj='.$id_country;
		
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		if($row[0] >= 1) {
			try {
				$sql = 'delete from kraj where id_kraj='.$id_country;
				
				$result = $this->pdo->exec($sql);
				if($result > 0) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto kraj.</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas usuwania rekorów.</div>
					';
				}
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
		}
		
		
		
		$stmt->closeCursor();
		echo '
			<div>Powrót do <a href="admin-countries.php">strony administracyjnej krajami</a>.</div>
		';
	}
}
?>