<?php


/**
* Country - klasa potomna dla klasy Baza, zawiera funkcje, które odpowiedzialne są za edycję, 
* dodawanie, usuwanie, walidację danych związanych z krajami.
* @author Marta Chmura, Dawid Piask
* @version 1.1
*/
	
class Country extends Baza {
	/**
	* function getCountries
	* Funkcja zwraca tablicę asocjacyjną ze wszystkim krajami w bazie danych
	*
	* @return array $rows - tablica z danymi krajów
	*/
    function getCountries() {
        $stmt = $this->pdo->query('select * from kraj');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
    }
	
	/**
	* function showCountries
	* Funkcja wyświetla i formatuje dane wszystkich krajów
	*
	* @param array $list - tablica zawierające dane dot. turniejów
	* @return 0
	*/
	function showCountries($list) {
		
		foreach ($list as $key => $value) {
			
			echo '
					<div class="col-lg-4">
						<img src="'.$value['img'].'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
						<h2><a href="?id_country='.$value['id_kraj'].'&amp;action=edit">'.$value['nazwa'].'</a></h2>
						<p><!--Donec sed odio dui.--></p>
			';		
			
				echo '
						<p><a class="btn btn-default" href="?id_country='.$value['id_kraj'].'&amp;action=edit" role="button">Zobacz więcej »</a></p>
				';
			
			echo '
					</div><!-- /.col-lg-4 -->

			';
		}
	
	}
	
	/**
	* function getCountryData
	* Funkcja zwraca dane dotyczące danego kraju
	*
	* @param integer $id_country - ID kraju
	* @return array $list - tablica asocjacyjna z danymi dot. kraju
	*/
	function getCountryData($id_country) {
		$stmt = $this->pdo->query('select * from kraj where id_kraj='.$id_country);
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
	}
	
	/**
	* function showCountryForm
	* Funkcja wyświetlająca formularz związany z edycją lub dodawaniem informacji nt. kraju
	*
	* @param array $country - tablica z danymi
	* @return 0
	*/
	function showCountryForm($country) {
		//url do generowanego obrazka; potrzebne w przypadku braku url-a do flagi danego kraju lub w przypadku dodawania nowego kraju do bazy
		$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		
		//jeśli był podany url do flagi - nadpisujemy $src z właściwym linkowaniem
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
										<input type="text" value="'.$country['nazwa'].'" name="countryName" id="countryName" class="form-control">
									</div>
									<div class="form-group">
										<label for="countryFlag">Adres pliku:</label>
										<input type="text" value="'.$country['img'].'" name="countryFlag" id="countryFlag" class="form-control">
									</div>
									<div class="form-group">
										<label for="countryAcronym">Akronym:</label>
										<input type="text" value="'.$country['akronym'].'" name="countryAcronym" id="countryAcronym" class="form-control">
									</div>
									
									
									<div class="form-group">
										<input type="hidden" value="'.$country['id_kraj'].'" name="countryID" id="countryID" class="form-control">
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
		//jeśli nie jesteśmy w formularzu dodającym kraj, możemy wyświetlić opcję usunięcia kraju z bazy
		if($_GET['action'] != 'add') {
			echo '
		
							<div class="col-lg-4">
									<hr class="featurette-divider">
									<!--<h2>Heading</h2>-->
									<p>Aby usunąć kraj wciśnij poniższy przycisk. Uwaga: usunięcie kraju jest nieodwracalne.</p>
									<a class="btn btn-danger" href="?action=delete&amp;id_country='.$country['id_kraj'].'">Usuń kraj</a>
									<hr class="featurette-divider">
							</div>
			';
		}
	}
	
	/**
	* function validate
	* Funkcja sprawdza czy wybrane pola formularza nie są puste
	*
	* @param array $country - tablica zawierające dane do sprawdzenia
	* @return 0
	*/
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
		//jeśli jest ustawiona flaga - znaczy został wykryty błąd i pokazujemy jeszcze raz formularz z danymi
		if($flag) {
			$this->showCountryForm($country);
		}
		else
			$this->updateCountry($country);
			
	}
	
	/**
	* function updateCountry
	* Funkcja edytuje albo dodaje nowe dane do bazy SQL dotyczące kraju
	*
	* @param array $country - tablica zawierające dane do sprawdzenia
	* @return 0
	*/
	function updateCountry($country) {
		//jeśli zmienna id_kraj jest puste - oznacza to, że dodajemy nowy kraj
		if(empty($country['id_kraj'])) {
			$action = 'insert';
		} //jeśli istnieje - jest to edycja danych
		else 
			$action = 'edit';
		//akcje dla dodania danych
		if ($action == 'insert') {
			try {
				/* 
				$sql = 'insert into kraj (`nazwa`, `img`, `akronym`) values (\''.$country['nazwa'].'\', \''.$country['img'].'\', \''.$country['akronym'].'\')';
				$result = $this->pdo->exec($sql); 
				*/
				
				$result = $this->pdo->prepare('insert into kraj (`nazwa`, `img`, `akronym`) values (:nazwa, :img, :akronym)');
				$result->bindValue(':nazwa', $country['nazwa'], PDO::PARAM_STR);
				$result->bindValue(':img', $country['img'], PDO::PARAM_STR);
				$result->bindValue(':akronym', $country['akronym'], PDO::PARAM_STR);
				$sucess = $result->execute();
				
				if($sucess) {
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
		//akcje dla edycji
		elseif ($action == 'edit') {
			try {
				/*
				$sql = 'update  kraj set `nazwa`=\''.$country['nazwa'].'\', `img`=\''.$country['img'].'\', `akronym`=\''.$country['akronym'].'\' where id_kraj='.$country['id_kraj'];
				$result = $this->pdo->exec($sql); 
				*/
				
				$result = $this->pdo->prepare('update  kraj set `nazwa`= :nazwa, `img`= :img, `akronym`= :akronym where id_kraj= :id_kraj');
				$result->bindValue(':nazwa', $country['nazwa'], PDO::PARAM_STR);
				$result->bindValue(':img', $country['img'], PDO::PARAM_STR);
				$result->bindValue(':akronym', $country['akronym'], PDO::PARAM_STR);
				$result->bindValue(':id_kraj', $country['id_kraj'], PDO::PARAM_STR);
				$sucess = $result->execute();
				
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie edytowano kraj: '.$country['nazwa'].'</div>
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
	}
	
	/**
	* function confirmRemoveCountry
	* Funkcja wyświetla pytanie o potwierdzenie, czy użytkownik jest pewien, że chce usunąć dane z bazy
	*
	* @param string $id_country - ID kraju do usunięcia
	* @param string $confirm - jest ustawione potwierdzenie
	* @return 0
	*/
	function confirmRemoveCountry($id_country, $confirm) {
		//wartość confirm nie pozwala na usunięcie
		if($confirm != '1') {
			echo '
				<div class="col-lg-4">
					<p>Czy na pewno <strong>chcesz usunąć</strong> ten kraj?</p>
					<p><strong>Uwaga:</strong> zostaną także usunięte dane dotyczące użytkownika oraz jego powiązań z drużynami w których grał. Może to skutkować niepełnymi danymi w innych wynikach.</p>
					<a type="button" href="?action=delete&amp;id_country='.$id_country.'&amp;confirm=1" class="btn btn-danger">Usuń (brak cofnięcia akcji)</a>
					<a type="button" href="?action=edit&amp;id_country='.$id_country.'" class="btn btn-default">Anuluj</a>
				</div>';
		}	
		else {
			$this->removeCountry($id_country);
		}
	}
	
	/**
	* function removeCountry
	* Funkcja usuwa kraj o podanym ID z bazy danych.
	*
	* @param string $id_country - ID kraju do usunięcia
	* @return 0
	*/
	function removeCountry($id_country) {
		// check if there are any players associated with this country
		$try_sql = 'select count(*) from zawodnik where id_kraj='.$id_country;
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		//clean field of country id for player
		if($row[0] >= 1) {
			try {
				/*
				$sql = 'update zawodnik set `id_kraj`=NULL where id_kraj='.$id_country;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('update zawodnik set `id_kraj`=NULL where id_kraj= :id_kraj');
				$result->bindValue(':id_kraj', $id_country, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
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
				/*
				$sql = 'delete from kraj where id_kraj='.$id_country;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('delete from kraj where id_kraj= :id_kraj');
				$result->bindValue(':id_kraj', $id_country, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
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