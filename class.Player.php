<?php 
/**
* Player - klasa potomna dla klasy Baza, zawiera funkcje, które odpowiedzialne są za edycję, 
* dodawanie, usuwanie, walidację danych związanych z zawodnikami.
* @author Marta Chmura, Dawid Piask
* @version 1.1
*/

class Player extends Baza {
	
	/**
	* function selectAll
	* Funkcja zwraca listę wszystkich zawodników z bazy danych.
	*
	* @return array $row - tablica asocjacyjna z danymi wszystkich zawodników z bazy danych.
	*/
	function selectAll() {
		$stmt = $this->pdo->query('SELECT * FROM zawodnik');
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $row;
	}
    
	/**
	* function getName
	* Funkcja zwraca imię i nazwisko zawodnika o podanym ID.
	*
	* @param integer $id - ID zawodnika.
	* @return array $row- tablica asocjacyjna z danymi zawodnika.
	*/
    function getName($id) {
		$stmt = $this->pdo->query('SELECT imie, nazwisko FROM zawodnik where id_zawodnik='.$id);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $row;
	}
	
	/**
	* function selectPlayer
	* Funkcja wyświetla dane zawodnika o podanym ID.
	*
	* @param integer $id - ID zawodnika.
	* @return 0
	*/
	function selectPlayer($id) {
		$stmt = $this->pdo->query('select * from zawodnik where id_zawodnik='.$id);
		
		foreach ($stmt as $row) {
			//jeśli pole photo zawiera obrazek - przypisujemy go pod zmienną $src, w innym przypadku ustawiamy ogólny obrazek
			if($row['photo']) $src = 'img/av/'.$row['photo'];
				else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			echo '
					<!--<div class="col-lg-4">-->
						<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
						<h2><a href="player.php?id_player='.$row['id_zawodnik'].'">'.$row['imie'].' '.$row['nazwisko'].'</a></h2>
						<p>Data urodzenia: <strong>'.$row['data_ur'].'</strong></p>
						<p>Płeć: <strong>'.$row['plec'].'</strong></p>
						<p>Delivery: <strong>'.$row['kierunek'].'</strong></p>
						<p>Kraj pochodzenia: <strong>'.$this->getCountryName($row['id_kraj']).'</strong></p>
					<!--</div>--><!-- /.col-lg-4 -->

			';
		}
		$stmt->closeCursor();
	}
	
	/**
	* function numberOfPlayers
	* Funkcja zwraca liczbę wszystkich zawodników w bazie danych.
	*
	* @return string $row[0] - liczba zawodników.
	*/
	function numberOfPlayers() {
		$stmt = $this->pdo->query('select count(*) from zawodnik');
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	/**
	* function selectSurnames
	* Funkcja zwraca i wyświetla listę wszystkich zawodników w bazie danych.
	*
	* @param string $param - parametr charakteryzujący czy jest to widok do przeglądania danych czy do ich edycji
	* @return string $row[0] - liczba zawodników.
	*/
	function selectSurnames($param) {
		$stmt = $this->pdo->query('SELECT id_zawodnik, imie, nazwisko, photo FROM zawodnik');
		$i = 0;
		$total_rows = $this->numberOfPlayers();
		
		foreach($stmt as $row) {
			if($i%3) { 
				//echo '<div class="row">';
			}
			//jeśli pole photo zawiera obrazek - przypisujemy go pod zmienną $src, w innym przypadku ustawiamy ogólny obrazek
			if($row['photo']) $src = 'img/av/'.$row['photo'];
				else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			echo '
					<div class="col-lg-4">
						<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
						<h2><a href="?id_player='.$row['id_zawodnik'].'&amp;action='.$param.'">'.$row['imie'].' '.$row['nazwisko'].'</a></h2>
						<p><!--Donec sed odio dui.--></p>
			';
			//jeśli jest parametr świadczący o edycji, to zmieniamy URL
			if($param == 'edit') {
				echo '
						<p><a class="btn btn-default" href="?id_player='.$row['id_zawodnik'].'&amp;action='.$param.'" role="button">Edytuj dane »</a></p>
				';		
			}			
			else {
				echo '
						<p><a class="btn btn-default" href="?id_player='.$row['id_zawodnik'].'" role="button">Zobacz więcej »</a></p>
				';
			}
			echo '
					</div><!-- /.col-lg-4 -->

			';
			
			if($i%3 || $i == $total_rows) { 
				//echo '</div>';
			}
			
			$i++;
		}
		$stmt->closeCursor();
	}
	
	/**
	* function editSinglePlayer
	* Funkcja pobiera dane dotyczące zawodnika, formatuje je i przekazuje do wyświetlenia w postaci formularza
	*
	* @param string $id - ID szukanego zawodnika
	* @param string $param - parametr decydujący o edycji lub 
	* @return 0
	*/
	function editSinglePlayer($id, $param) {
		// call for data from database
		$stmt = $this->pdo->query('select * from zawodnik where id_zawodnik='.$id);
		//pobieramy listę krajów z bazy
		$countryList = $this->getCountries();
		
		foreach ($stmt as $row) {
			$sex = $row['plec'];
			
			if($row['photo']) $src = 'img/av/'.$row['photo'];
			
			else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			// prepare array for passing to function			
			$player['nameInput'] = $row['imie'];
			$player['surnameInput'] = $row['nazwisko'];
			$player['birthdayInput'] = $row['data_ur'];
			$player['deliveryInput'] = $row['kierunek'];
			$player['sexInput'] = $row['plec'];
			$player['countryInput'] = $row['id_kraj'];
			$player['idPlayer'] = $id;
			$player['fileInput'] = $src;
			
			//przekazujemy dane do wyświetlania
			$this->showPlayerForm($player);
	
		}
		$stmt->closeCursor();
	}

	/**
	* function showPlayerForm
	* Funkcja wyświetla dane zawodnika w postaci formularza dane 
	*
	* @param array $player - tablica zawierająca wcześniej przygotowane dane dot. zawodnika
	* @return 0
	*/
	function showPlayerForm($player) {
		//ustawiamy defautlowy obrazek w przypadku gdyby nie było przekazane zdjęcie zawodnika
		$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		
		//nie została przekazana pusta tablica player - wyświetlamy niepusty formularz
		if(!empty($player)) {
			$name = $player['nameInput'];
			$surname = $player['surnameInput'];
			$birth = $player['birthdayInput'];
			$delivery = $player['deliveryInput'];
			$sex = $player['sexInput'];
			$playerCountry = $player['countryInput'];
			$src = $player['fileInput'];
			$idPlayer = $player['idPlayer'];
		}
		else $name = $surname = $birth = '';
		//pobieramy listę krajów
		$countryList = $this->getCountries();
		
			echo '
						<div class="col-lg-4">
							<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
							<h2>'.$name.' '.$surname.'</h2>
							
						</div>	
				';		
			echo '
				
				<div class="col-lg-4">
				
					<form role="form" action="admin-players.php" method="post">
					
						<div class="form-group">
							<label for="nameInput">Imię:</label>
							<input type="text" class="form-control" name="nameInput" id="nameInput" value="'.$name.'">
						</div>
						<div class="form-group">
							<label for="surnameInput">Nazwisko:</label>
							<input type="text" class="form-control" name="surnameInput" id="surnameInput" value="'.$surname.'">
						</div>
						<div class="form-group">
							<label for="birthdayInput">Data urodzenia (rrrr-mm-dd):</label>
							<input type="date" class="form-control" name="birthdayInput" id="birthdayInput" value="'.$birth.'">
						</div>
						<div class="form-group">
							<label for="deliveryInput">Delivery:</label>
								<select name="deliveryInput" id="deliveryInput" class="form-control">
									<option value="L"'; if($delivery == 'L') { echo ' selected'; } echo '>Leworęczny</option>
									<option value="R"'; if($delivery == 'R') { echo ' selected'; } echo '>Praworęczny</option>
								</select>
						</div>
						<div class="form-group">
							<label for="sexInput">Płeć:</label>
								<select name="sexInput" id="sexInput" class="form-control">
									<option value="K"'; if($sex == 'K') { echo ' selected'; } echo '>Kobieta</option>
									<option value="M"'; if($sex == 'M') { echo ' selected'; } echo '>Mężczyzna</option>
								</select>
						</div>
						<div class="form-group">
							<label for="countryInput">Kraje:</label>
								<select name="countryInput" id="countryInput" class="form-control">
									<option value="none">---</option>';
                                foreach($countryList as $country) {
             
                                    echo '
                                   <option value="'.$country['id_kraj'].'"'; 
										
										if($country['id_kraj'] == $playerCountry) echo ' selected';
                                 
                                   echo '>'.$country['nazwa'].'</option>
                                    ';
            }
                                
                        echo '        
								</select>
						</div>
						
						<div class="form-group">
							<input type="hidden" class="form-control" name="idPlayer" value="'.$idPlayer.'">
						</div>
						
						<div class="form-group">
							<label for="fileInput">Dodaj nowe zdjęcie:</label>
							<input type="file" id="fileInput" disabled>
							<p class="help-block">W tej chwili opcja jest niedostępna. Aby dodać zdjęcie skontaktuj się z administratorem.</p>
						</div>
					
						
					
						<button type="submit" class="btn btn-success">Zapisz</button>
						<a href="admin-players.php" class="btn btn-default">Anuluj</a>
					</form>
						
				</div>	
			';
			//jeśli nie jest to formularz dodania zawodnika - pokazujemy opcję usunięcia zawodnika z bazy
			if($_GET['action'] != 'add') {
			echo ' <div class="col-lg-4">';
			echo '
					<hr class="featurette-divider">
					<!--<h2>Heading</h2>-->
					<p>Aby usunąć zawodnika wciśnij poniższy przycisk. Uwaga: usunięcie zawodnika jest nieodwracalne.</p>
					<a href="?action=delete&amp;id_player='.$idPlayer.'" class="btn btn-danger">Usuń zawodnika</a>
					<hr class="featurette-divider">
			';
			echo '</div>	';
			}
	
	}
	
	/**
	* function validate
	* Funkcja sprawdza czy wybrane pola formularza nie są puste
	*
	* @param array $player - tablica zawierające dane do sprawdzenia
	* @return 0
	*/
	function validate($player) {

		$flag = 0;
		foreach ($player as $key => $value) {
			if(empty($value) && ($key !='idPlayer')) {
				echo '
					<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona</div>
				';
				$flag = 1;
			}
		}
		if($flag) {
			$this->showPlayerForm($player);
		}
		else
			$this->updatePlayer($player);
	}
	
	/**
	* function updatePlayer
	* Funkcja w zależności od przekazywanych danych - edytuje bądź dodaje dane dotyczące zawodnika
	*
	* @param array $player - tablica zawierające dane zawodnika
	* @return 0
	*/
	function updatePlayer($player) {
	
		//jeśli nie jest puste idPlayer, to oznacza to, że dodajemy nowego zawodnika
		if(empty($player['idPlayer']))
			$action = 'insert';
		else 
			$action = 'edit'; 
		//tworzenie skróconych nazw	
		$name = $player['nameInput'];
		$surname = $player['surnameInput'];
		$birth = $player['birthdayInput'];
		$delivery = $player['deliveryInput'];
		$sex = $player['sexInput'];
		//jeśli nie został wybrany kraj z listy
		if($player['countryInput'] == 'none') 
			$playerCountry = NULL;
		else
			$playerCountry = $player['countryInput'];
		$idPlayer = $player['idPlayer'];
		
		//dodajemy zawodnika do bazy
		if($action == 'insert') {
			try {
				/*
				$sql = 'insert into zawodnik (`imie`, `nazwisko`, `data_ur`, `plec`, `kierunek`, `id_kraj`) values (\''.$name.'\', \''.$surname.'\', \''.$birth.'\', \''.$sex.'\', \''.$delivery.'\', '.$playerCountry.')';
				$result = $this->pdo->exec($sql);
				*/
				
				$result = $this->pdo->prepare('insert into zawodnik (`imie`, `nazwisko`, `data_ur`, `plec`, `kierunek`, `id_kraj`) values (:imie, :nazwisko, :data_ur, :plec, :kierunek, :id_kraj)');
				$result->bindValue(':imie', $name, PDO::PARAM_STR);
				$result->bindValue(':nazwisko', $surname, PDO::PARAM_STR);
				$result->bindValue(':data_ur', $birth, PDO::PARAM_STR);
				$result->bindValue(':plec', $sex, PDO::PARAM_STR);
				$result->bindValue(':kierunek', $delivery, PDO::PARAM_STR);
				$result->bindValue(':id_kraj', $playerCountry, PDO::PARAM_STR);
				$sucess = $result->execute();
				//zapytanie zostalo wykonanie poprawnie
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie dodano zawodnika: '.$name.' '.$surname.'</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas dodawania rekorów.</div>
					';
				}
				//$result->closeCursor();
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
			

		}	//edytujemy zawodnika
		elseif($action == 'edit') {
			try {
				/*
				$sql = 'update  zawodnik set `imie`=\''.$name.'\', `nazwisko`=\''.$surname.'\', `data_ur`=\''.$birth.'\', `plec`=\''.$sex.'\', `kierunek`=\''.$delivery.'\', `id_kraj`='.$playerCountry.' where id_zawodnik='.$idPlayer;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('update zawodnik set `imie`= :imie, `nazwisko`= :nazwisko, `data_ur`= :data_ur, `plec`= :plec, `kierunek` = :kierunek, `id_kraj` = :id_kraj where id_zawodnik= :id_zawodnik');
				$result->bindValue(':imie', $name, PDO::PARAM_STR);
				$result->bindValue(':nazwisko', $surname, PDO::PARAM_STR);
				$result->bindValue(':data_ur', $birth, PDO::PARAM_STR);
				$result->bindValue(':plec', $sex, PDO::PARAM_STR);
				$result->bindValue(':kierunek', $delivery, PDO::PARAM_STR);
				$result->bindValue(':id_kraj', $playerCountry, PDO::PARAM_STR);
				$result->bindValue(':id_zawodnik', $idPlayer, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie edytowano zawodnika: '.$name.' '.$surname.'</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas edytowania rekorów.</div>
					';
				}
				//$result->closeCursor();
				
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
			
		}
			
		
		echo '
			<div>Powrót do <a href="admin-players.php">strony administracyjnej zawodnikami</a>.</div>
		';
		
	}
	
	/**
	* function confirmRemovePlayer
	* Funkcja wyświetla prośbę o potwierdzenie chęci usunięca zwodnika z bazy danych lub odsyła do funkcji usuwającej dane
	*
	* @param string $id_player - ID zawodnika
	* @param string $confirm - istnieje potwierdzenie usunięcia
	* @return 0
	*/
	function confirmRemovePlayer($id_player, $confirm) {
		//jeśli wartość $confirm jest różna od '1' wyświetla dane
		if($confirm != '1') {
			$this->selectPlayer($id_player);
			echo '
				<div class="col-lg-4">
					<p>Czy na pewno <strong>chcesz usunąć</strong> tego zawodnika?</p>
					<p><strong>Uwaga:</strong> zostaną także usunięte dane dotyczące użytkownika oraz jego powiązań z drużynami w których grał. Może to skutkować niepełnymi danymi w innych wynikach.</p>
					<a type="button" href="?action=delete&amp;id_player='.$id_player.'&amp;confirm=1" class="btn btn-danger">Usuń (brak cofnięcia akcji)</a>
					<a type="button" href="?action=edit&amp;id_player='.$id_player.'" class="btn btn-default">Anuluj</a>
				</div>';
		}	
		else {
			$this->removePlayer($id_player);
		}
	}		
	
	/**
	* function removePlayer
	* Funkcja sprawdza czy zawodnik jest powiązany z jakimiś drużynami, które w razie potrzeby również usuwa, po czym usuwa dane zawodnika z bazy
	*
	* @param string $id_player - ID zawodnika
	* @return 0
	*/
	function removePlayer($id_player) {
	
		// check if player was/is participating in any teams
		$try_sql = 'select count(*) from zawodnik_druzyna where id_zawodnik='.$id_player;
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		//zawodnik jest przypisany do druzyny, w takim wypadku musimy usunąć powiązania
		if($row[0] >= 1) {
			try {
				/*
				$sql = 'delete from zawodnik_druzyna where id_zawodnik='.$id_player;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('delete from zawodnik_druzyna where id_zawodnik= :id_zawodnik');
				$result->bindValue(':id_zawodnik', $id_player, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto powiązania zawodnika z drużynami.</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas usuwania rekorów.</div>
					';
				}
				//$result->closeCursor();
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
		}
		
		// check if player really exists
		$try_sql = 'select count(*) from zawodnik where id_zawodnik='.$id_player;
		
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		//zapytanie zwrociło nam zawodnika
		if($row[0] >= 1) {
			try {
				/*
				$sql = 'delete from zawodnik where id_zawodnik='.$id_player;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('delete from zawodnik where id_zawodnik= :id_zawodnik');
				$result->bindValue(':id_zawodnik', $id_player, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto zawodnika.</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas usuwania rekorów.</div>
					';
				}
				//$result->closeCursor();
			}
			catch(PDOException $e)
			{
                echo '<div class="alert alert-danger">Wystąpił błąd biblioteki PDO: ' . $e->getMessage().'</div>';
			}
			
		}
		
		
		echo '
			<div>Powrót do <a href="admin-players.php">strony administracyjnej zawodnikami</a>.</div>
		';
		
	}
	
	/**
	* function searchPlayer
	* Funkcja wyszukuje (po kolumnie 'nazwisko'), który zawodnik jest zgodny z wyszukiwanym ciągiem znaków
	*
	* @param string $input - wyszukiwana nazwa
	* @return 0
	*/
	function searchPlayer($input) {
		$sql = 'select id_zawodnik from zawodnik where nazwisko like \'%'.$input.'%\'';
		
		$stmt = $this->pdo->query($sql);
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		$i = 0;
		//ilość rezultatów
		$total = count($row);
		//dla znalezionych rezultatów wyświetlamy
		foreach($row as $key => $value) {
			//dla każdego pierwszego elementu z trzech otwieramy diva "wierszowego"
			if($i%3 == 0) {
				echo '<div class="row">';	
			}
			//wywołujemy funkcję odpowiadającą za wyświetlanie danych o zadanym ID zawodnika
			echo '<div class="col-lg-4">';
			$this->selectPlayer($value['id_zawodnik']);
			echo '</div>';
			//dla 3. (oraz jego krotności) lub ostatniego elementu z tablicy zamykamy div "wierszowy"
			if(($i%3 == 2) || $i == ($total-1)) {
				echo '
					</div>	
				';
			}
				
			$i++;
		}
	}
	
}


/*****************************************************************************************/
	?>