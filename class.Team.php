<?php

/**
* Team - klasa potomna dla klasy Baza, zawiera funkcje, które odpowiedzialne są za edycję, 
* dodawanie, usuwanie, walidację danych związanych z drużynami.
* @author Marta Chmura, Dawid Piask
* @version 1.1
*/

class Team extends Baza {
	
	/**
	* function selectAll
	* Funkcja zwraca listę wszystkich drużyn z bazy danych.
	*
	* @return array $row - tablica asocjacyjna z danymi wszystkich drużyn z bazy danych.
	*/
	function selectAll() {
		$stmt = $this->pdo->query('SELECT * FROM druzyna');
		//$stmt = $stmt->fetch(PDO::FETCH_ASSOC);
		foreach ($stmt as $row) {
			echo '<pre>';
			print_r($row);
			echo '</pre>';
		}
		$stmt->closeCursor();
	}
	
	/**
	* function numberOfTeams
	* Funkcja wyświetla ilość drużyn w bazie danych
	*
	* @return integer - ilość wierszy
	*/
	function numberOfTeams() {
		$stmt = $this->pdo->query('select count(*) from druzyna');
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	/**
	* function getTeamData
	* Funkcja pobiera i zwraca dane drużyny o podanym ID
	*
	* @param integer $id_team - ID drużyny, której dane chcemy pobrać
	* @return array $rows - tablica asocjacyjna z danymi drużyny
	*/
	function getTeamData($id_team) {
		$stmt = $this->pdo->query('SELECT * FROM druzyna where id_druzyna='.$id_team);
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $rows;
	}
	
	/**
	* function getCurrentConnections
	* Funkcja pobiera i zwraca jacy zawodnicy są powiązani nadal z daną drużyny względem dzisiejszej daty
	*
	* @param integer $id_team - ID drużyny, której dane chcemy pobrać
	* @return array $rows - tablica asocjacyjna z danymi powiązanych zawodników
	*/
	function getCurrentConnections($id_team) {
		$currentDate = date('Y-m-d');
		$sql = 'SELECT * FROM zawodnik_druzyna where id_druzyna='.$id_team.' and data_do is NULL or data_do > \''.$currentDate.'\'';
		$stmt = $this->pdo->query($sql);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $rows;
	}
	
	/**
	* function getPastConnections
	* Funkcja pobiera i zwraca jacy zawodnicy byli powiązani nadal z daną drużyny względem dzisiejszej daty
	*
	* @param integer $id_team - ID drużyny, której dane chcemy pobrać
	* @return array $rows - tablica asocjacyjna z danymi powiązanych zawodników
	*/
	function getPastConnections($id_team) {
		$currentDate = date('Y-m-d');
		$sql = 'SELECT * FROM zawodnik_druzyna where id_druzyna='.$id_team.' and data_do < \''.$currentDate.'\'';
		$stmt = $this->pdo->query($sql);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $rows;
	}
	
	/**
	* function showTeamForm
	* Funkcja wyświetla formularz z danymi drużyny, jeśli $team nie jest puste, w innym przypadku wyświetla formularz dodania drużyny
	*
	* @param array $team - dane drużyny do wyświetlenia
	* @return 0
	*/
	function showTeamForm($team) {
        //szary defaultowy obrazek
		$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		
		//jesli zostaly przekazane dane - przepisanie zmiennych do takich o prostszych nazwach
		if(!empty($team)) {
			$teamID = $team['teamID'];
			$teamName = $team['teamName'];
			$teamCategory = $team['teamCategory'];
			$src = $teamPhoto = $team['teamPhoto'];
			$teamSex = $team['teamSex'];
		}
		
			echo '
						<div class="col-lg-4">
							<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
							<h2>'.$teamName.'</h2>
						</div>	
				';		
			echo '
				
				<div class="col-lg-4">
				
					<form role="form" action="admin-teams.php" method="post">
					
						<div class="form-group">
							<label for="teamName">Nazwa:</label>
							<input type="text" class="form-control" name="teamName" id="teamName" value="'.$teamName.'">
						</div>
						<div class="form-group">
							<label for="teamCategory">Kategoria wiekowa:</label>
								<select name="teamCategory" id="teamCategory" class="form-control">
									<option value="senior"'; if($teamCategory == 'senior') { echo ' selected'; } echo '>senior</option>
									<option value="junior"'; if($teamCategory == 'junior') { echo ' selected'; } echo '>junior</option>
								</select>
						</div>
						<div class="form-group">
							<label for="teamSex">Kategoria:</label>
								<select name="teamSex" id="teamSex" class="form-control">
									<option value="K"'; if($teamSex == 'K') { echo ' selected'; } echo '>kobieca</option>
									<option value="M"'; if($teamSex == 'M') { echo ' selected'; } echo '>męska</option>
									<option value="X"'; if($teamSex == 'X') { echo ' selected'; } echo '>mixtowa</option>
								</select>
						</div>
						<div class="form-group">
							<label for="teamPhoto">Zdjęcie:</label>
							<input type="text" class="form-control" name="teamPhoto" id="teamPhoto" value="'.$teamPhoto.'">
						</div>
						
						<div class="form-group">
							<input type="hidden" class="form-control" name="teamID" value="'.$teamID.'">
						</div>
						
						<div class="form-group">
							<input type="hidden" class="form-control" name="formType" value="teamform">
						</div>
						
						<div class="form-group">
							<label for="fileInput">Dodaj nowe zdjęcie:</label>
							<input type="file" id="fileInput" disabled>
							<p class="help-block">W tej chwili opcja jest niedostępna. Aby dodać zdjęcie skontaktuj się z administratorem.</p>
						</div>
					
						
					
						<button type="submit" class="btn btn-success">Zapisz</button>
						<a href="admin-teams.php" class="btn btn-default">Anuluj</a>
					</form>
						
				</div>	
			';
		//jesli akcja jest rozna od "dodaj"
			if(@$_GET['action'] != 'add') {
			echo ' <div class="col-lg-4">';
			echo '
					<hr class="featurette-divider">
					<!--<h2>Heading</h2>-->
					<p>Aby usunąć drużynę wciśnij poniższy przycisk. Uwaga: usunięcie drużyny jest nieodwracalne.</p>
					<a href="?action=delete&amp;id_team='.$teamID.'" class="btn btn-danger">Usuń drużynę</a>
					<hr class="featurette-divider">
			';
			echo '</div>	';
			}
	}
	
	/**
	* function validate
	* Funkcja sprawdza czy wybrane pola formularza nie są puste
	*
	* @param array $data - tablica zawierające dane do sprawdzenia
	* @param string $formType - typ formularza
	* @return 0
	*/
	function validate($team, $formType) {
		//jesli formularz byl typu 'teamform' - dotyczacy tylko druzyny (opis, avatar, typ, zenska/meska)
		if($formType == 'teamform') {
			$flag = 0;
			foreach ($team as $key => $value) {
				//sprawdzamy czy przekazywane pola nie są puste (nie dotyczy teamID, które może być puste w przypadku dodawania nowej drużyny)
				if(empty($value) && ($key !='teamID')) {
					echo '
						<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona</div>
					';
					$flag = 1;
				}
			} //jeśli flaga z błędem została ustawiona - wyświetl ponownie formularz z danymi
			if($flag) {
				$this->showTeamForm($team);
			} //update danych dotyczących drużyny
			else
				$this->updateTeam($team);
		}		
		//jesli formularz byl typu 'association' - dotyczy powiazan zawodnikow z druzynami
		if($formType == 'association') {
			$flag = 0;
			//pomocnicze dane do wyświetlenia błędów - pobieramy imię i nazwisko zawodnika przy którego zapytaniu wystąpił błąd
			$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			$name = $zawodnik->getName($team['playerID']);
			//sprawdzamy czy przekazywane pola nie są puste (nie dotyczy dateFrom oraz position, które mogą być puste)
			foreach ($team as $key => $value) {
				
					if((empty($value)) && (($key =='dateFrom') || ($key =='position'))) {
						
						echo '
							<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona dla zawodnika '.$name['imie'].' '.$name['nazwisko'].'</div>
						';
						$flag = 1;
					}

			} //jeśli została ustawiona flaga błędu, to wyświetlamy ponownie formularz dla drużyny o zadanym ID
			if($flag) {
				$this->editTeamMembers($team['teamID']);
			} //zmieniamy powiązania dla drużyny
			else
				$this->changeConnection($team);
		}
	}
	
	/**
	* function changeConnection
	* Funkcja zmienia powiązania (w tym usunięcie) pomiędzy zawodnikiem a drużyną
	*
	* @param array $data - tablica zawierające dane do zmiany/usunięcia
	* @return 0
	*/
	function changeConnection($data) {
		//w formularzu istnialo pole "delete", także dotyczy to usunięcie powiązania zawodnika z drużyną
		if(isset($data['delete'])) {
				try {
					/*
					$sql = 'delete from zawodnik_druzyna where id_zawodnik='.$data['playerID'].' and id_druzyna='.$data['teamID'];
					$result = $this->pdo->exec($sql);
					*/
					$result = $this->pdo->prepare('delete from zawodnik_druzyna where id_zawodnik= :id_zawodnik and id_druzyna=:id_druzyna');
					$result->bindValue(':id_zawodnik', $data['playerID'], PDO::PARAM_STR);
					$result->bindValue(':id_druzyna', $data['teamID'], PDO::PARAM_STR);
					$sucess = $result->execute();
					if($sucess) {
						//pomocnicze zmienne dla ładnego wyświetlenia alertu
						$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
						$name = $zawodnik->getName($data['playerID']);
					
						echo '
						<div class="alert alert-success">Pomyślnie usunięto powiązanie '.$name['imie'].' '.$name['nazwisko'].'.</div>
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

			}
            //w formularzy wybrano opcje "submit" - dodanie nowego rekordu do bazy
			elseif(isset($data['submit'])) {
				try {
                    //w przypadku pustych pull - przypisanie wartosci NULL do zmiennych - poprawna forma zapytania SQL
					if(empty($data['dateTo']))
						$dateTo = NULL;
					else
						$dateTo = $data['dateTo'];
						
					if($data['function'] == 'none') 
						$function = NULL;
					else
						$function = $data['function'];	
					
					
					//check if this player is already in the team
					$test = $this->connectionExists($data['teamID'], $data['playerID']);
					
					if($test) {
						//$sql = 'update  zawodnik_druzyna set `id_zawodnik`=\''.$data['playerID'].'\', `id_druzyna`=\''.$data['teamID'].'\', `data_od`=\''.$data['dateFrom'].'\', `data_do`='.$dateTo.', `pozycja`=\''.$data['position'].'\', `funkcja`='.$function.' where id_druzyna='.$data['teamID'].' and id_zawodnik='.$data['playerID'];
						$result = $this->pdo->prepare('update zawodnik_druzyna set `id_zawodnik`= :id_zawodnik, `id_druzyna`= :id_druzyna, `data_od`= :data_od, `data_do`= :data_do, `pozycja` = :pozycja, `funkcja` = :funkcja where id_zawodnik= :id_zawodnik');
						$result->bindValue(':id_zawodnik', $data['playerID'], PDO::PARAM_STR);
						$result->bindValue(':id_druzyna', $data['teamID'], PDO::PARAM_STR);
						$result->bindValue(':data_od', $data['dateFrom'], PDO::PARAM_STR);
						$result->bindValue(':data_do', $dateTo, PDO::PARAM_STR);
						$result->bindValue(':pozycja', $data['position'], PDO::PARAM_STR);
						$result->bindValue(':funkcja', $function, PDO::PARAM_STR);
						$result->bindValue(':id_zawodnik', $data['playerID'], PDO::PARAM_STR);
						$sucess = $result->execute();
					}	
					else {
						//$sql = 'insert into zawodnik_druzyna (`id_zawodnik`, `id_druzyna`, `data_od`, `data_do`, `pozycja`, `funkcja`) values (\''.$data['playerID'].'\', \''.$data['teamID'].'\', \''.$data['dateFrom'].'\', '.$dateTo.', \''.$data['position'].'\', '.$function.') ';	
						$result = $this->pdo->prepare('insert into zawodnik_druzyna (`id_zawodnik`, `id_druzyna`, `data_od`, `data_do`, `pozycja`, `funkcja`) values (:id_zawodnik, :id_druzyna, :data_od, :data_do, :pozycja, :funkcja)');
						$result->bindValue(':id_zawodnik', $data['playerID'], PDO::PARAM_STR);
						$result->bindValue(':id_druzyna', $data['teamID'], PDO::PARAM_STR);
						$result->bindValue(':data_od', $data['dateFrom'], PDO::PARAM_STR);
						$result->bindValue(':data_do', $dateTo, PDO::PARAM_STR);
						$result->bindValue(':pozycja', $data['position'], PDO::PARAM_STR);
						$result->bindValue(':funkcja', $function, PDO::PARAM_STR);
						$sucess = $result->execute();
					}
					//$result = $this->pdo->exec($sql);
					if($sucess) {
						$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
						$name = $zawodnik->getName($data['playerID']);
						echo '
						<div class="alert alert-success">
							<p>Pomyślnie edytowano powiązanie zawodnika: '.$name['imie'].' '.$name['nazwisko'].'</p>
							<p>Powrót do edycji <a href="?action=edit_members&amp;id_team='.$data['teamID'].'">drużyny</a>.</p>
						</div>
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
			}
	}
	
	/**
	* function connectionExists
	* Funkcja sprawdza i zwraca ilość powiązań zawodnika z drużyną
	*
	* @param string $id_team - ID drużyny
	* @param string $id_player - ID zawodnika
	* @return string $rows[0] - ilość powiązań
	*/
	function connectionExists($id_team, $id_player) {
		$stmt = $this->pdo->query('select count(*) from zawodnik_druzyna where id_zawodnik='.$id_player.' and id_druzyna='.$id_team);
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	/**
	* function updateTeam
	* Funkcja dokonuje zmian dotyczących drużyny w bazie danych (edycja albo dodanie)
	*
	* @param array $team - dane dotyczące drużyny
	* @return string $rows[0] - ilość powiązań
	*/
	function updateTeam($team) {
	
		//jeśli ID drużyny jest puste - oznacza to dodanie nowej drużyny
		if(empty($team['teamID']))
			$action = 'insert';
		//jeśli istnieje ID drużyny - oznacza to edycję już istniejącej drużyny
		else
			$action = 'edit'; 			
		//przypisanie krótszych nazw
		$teamName = $team['teamName'];
		$teamCategory = $team['teamCategory'];
		$teamSex = $team['teamSex'];
		$teamPhoto = $team['teamPhoto'];
		$teamID = $team['teamID'];
		
		//dodajemy wpis o drużynie
		if($action == 'insert') {
			try {
				/*
				$sql = 'insert into druzyna (`nazwa`, `typ`, `plec`, `photo`) values (\''.$teamName.'\', \''.$teamCategory.'\', \''.$teamSex.'\', \''.$teamPhoto.'\')';
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('insert into druzyna (`nazwa`, `typ`, `plec`, `photo`) values (:nazwa, :typ, :plec, :photo)');
				$result->bindValue(':nazwa', $teamName, PDO::PARAM_STR);
				$result->bindValue(':typ', $teamCategory, PDO::PARAM_STR);
				$result->bindValue(':plec', $teamSex, PDO::PARAM_STR);
				$result->bindValue(':photo', $teamPhoto, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie dodano zawodnika: '.$teamName.'</div>
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
			

		}
		//edytujemy wpis o drużynie
		elseif($action == 'edit') {
			try {
				/*
				$sql = 'update  druzyna set `nazwa`=\''.$teamName.'\', `typ`=\''.$teamCategory.'\', `plec`=\''.$teamSex.'\', `photo`=\''.$teamPhoto.'\' where id_druzyna='.$teamID;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('update  druzyna set `nazwa`=:nazwa, `typ`=:typ, `plec`=:plec, `photo`=:photo where id_druzyna=:id_druzyna');
				$result->bindValue(':nazwa', $teamName, PDO::PARAM_STR);
				$result->bindValue(':typ', $teamCategory, PDO::PARAM_STR);
				$result->bindValue(':plec', $teamSex, PDO::PARAM_STR);
				$result->bindValue(':photo', $teamPhoto, PDO::PARAM_STR);
				$result->bindValue(':id_druzyna', $teamID, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie edytowano zawodnika: '.$teamName.'</div>
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
			
		//link nawigacyjny
		echo '
			<div>Powrót do <a href="admin-teams.php">strony administracyjnej drużynami</a>.</div>
		';
		
	}
	
	/**
	* function selectTeams
	* Funkcja zwraca i wyświetla listę wszystkich drużyn w bazie danych.
	*
	* @param string $param - parametr charakteryzujący czy jest to widok do przeglądania danych czy do ich edycji
	* @return 0
	*/
	function selectTeams($param) {
		$stmt = $this->pdo->query('SELECT id_druzyna, nazwa, photo FROM druzyna');
		$i = 0;
		//dodatkowo pobieramy ile jest w sumie drużyn w bazie danych
		$total_rows = $this->numberOfTeams();
		
		foreach($stmt as $row) {
			if($i%3) { 
				//echo '<div class="row">';
			}
			//jeśli pole photo zawiera obrazek - przypisujemy go pod zmienną $src, w innym przypadku ustawiamy ogólny obrazek
			if($row['photo']) $src = $row['photo'];
				else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			echo '
					<div class="col-lg-4">
						<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">';
			//jeśli jest parametr świadczący o edycji, to zmieniamy URL
			if($param == 'edit') {
				echo '			
						<h2><a href="?id_team='.$row['id_druzyna'].'&amp;action='.$param.'">'.$row['nazwa'].'</a></h2>
						<p><a href="?action=edit_members&amp;id_team='.$row['id_druzyna'].'" class="btn btn-default">Edytuj powiązania »</a>
				';
						
			}
			else {
				echo '			
						<h2><a href="?id_team='.$row['id_druzyna'].'">'.$row['nazwa'].'</a></h2>
						<!--<p>Donec sed odio dui.</p>-->';
			}
			//jeśli jest parametr świadczący o edycji, to zmieniamy URL
			if($param == 'edit') {
				echo '<a class="btn btn-default" href="?id_team='.$row['id_druzyna'].'&amp;action='.$param.'" role="button">Edytuj dane »</a></p>';
			}
			else {
				echo '<p><a class="btn btn-default" href="?id_team='.$row['id_druzyna'].'" role="button">Zobacz więcej »</a></p>';
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
	* function getTeamName
	* Funkcja zwraca nazwę drużyny o podanym ID.
	*
	* @param integer $id - ID drużyny.
	* @return string $row - nazwa drużyny
	*/
	function getTeamName($id) {
		$stmt = $this->pdo->query('select nazwa from druzyna where id_druzyna='.$id);
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	/**
	* function selectSingleTeam
	* Funkcja pobiera i wyświetla dane dotyczące pojedynczen drużyny; w tym jej nazwę, typ, kategorię wiekową,
	* dodatkowo wyświetla też informację dotyczącą zawodników, którzy w niej występują lub występowali.
	*
	* @param integer $id - ID drużyny.
	* @return 0
	*/
	function selectSingleTeam($id) {
		//pobieramy dane dot. drużyny
		$team = $this->getTeamData($id);
		//pobieramy dane dotyczące zawodników, którzy grają obecnie w drużynie
		$currentPlayer = $this->getCurrentConnections($id);
		//pobieramy dane dotyczące zawodników, którzy grali w przeszłości w drużynie
		$pastPlayer = $this->getPastConnections($id);
		//jeśli pole photo zawiera obrazek - przypisujemy go pod zmienną $src, w innym przypadku ustawiamy ogólny obrazek
		if(empty($team['photo'])) {
			$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		}
		else $src = $team['photo'];
		//w zależności od wartości skrótowej zmiennej wypisujemy pełną nazwę typu drużyny
		switch($team['plec']) {
			case 'K':
				$sex = 'kobieca';
				break;
			case 'M':
				$sex = 'męska';
				break;
			case 'X':
				$sex = 'mixtowa';
				break;
			default:
				$sex = '';
				break;
		}
		
		echo '
			<div class="row">
				<div class="col-lg-4">
					<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
					<h2>'.$team['nazwa'].'</h2>
					<p><strong>Kategoria wiekowa: </strong>'.$team['typ'].'</p>
					<p><strong>Typ drużyny: </strong>'.$sex.'</p>
				</div>	
			</div>	
			
			
		';
		//wyliczamy ile jest powiązań obecnych zawodników względem drużyny
		$total = count($currentPlayer);
		//jeśli powiązania istnieją, to wyświetlamy każdego zawodnika spełniającego warunek
		if($total > 0){
			$i = 0;
			foreach ($currentPlayer as $key => $value) {
				if($i == 0) {
					echo '
						<hr class="featurette-divider">
						<div class="row"><h3 class="ctr">Obecni zawodnicy:</h3></div>';
				}	
				if($i%3 == 0) {
					echo '<div class="row">';	
				}
				
				echo '<div class="col-lg-4">';
				//wyświetlamy dane szczegółowe zawodnika (imię, nazwisko, prawo- lub leworęczność)
				$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
				$zawodnik->selectPlayer($value['id_zawodnik']);
				//dalsze szczegóły dotyczące związku zawodnika z drużyną
				if(!empty($value['data_od']))
					echo '<p>Gra w drużyne od: <strong>'.$value['data_od'].'</strong></p>';
				if(!empty($value['data_do']))
					echo '<p>Gra w drużyne do: <strong>'.$value['data_do'].'</strong></p>';
				if(!empty($value['pozycja']))	
					echo '<p>Pozycja: <strong>'.$value['pozycja'].'</strong></p>';
				if(!empty($value['funkcja']))
					echo '<p>Funkcja: <strong>'.$value['funkcja'].'</strong></p>';
				
				echo '</div>'; // <!-- end col-lg-4 -->
				
				
				if(($i%3 == 2) || $i == ($total-1)) {
					echo '
						</div>	
					';
				}
				
				$i++;
			}
	
		}
		//wyliczamy ile jest powiązań byłych zawodników względem drużyny
		$total = count($pastPlayer);
		//jeśli powiązania istnieją, to wyświetlamy każdego zawodnika spełniającego warunek
		if($total > 0){
			$i = 0;
			foreach ($pastPlayer as $key => $value) {
				if($i == 0) {
					echo '
						<hr class="featurette-divider">
						<div class="row"><h3 class="ctr">Byli zawodnicy:</h3></div>';
				}	
				//dla każdego pierwszego elementu z trzech otwieramy diva "wierszowego"
				if($i%3 == 0) {
					echo '<div class="row">';	
				}
				
				echo '<div class="col-lg-4">';
				//wyświetlamy dane szczegółowe zawodnika (imię, nazwisko, prawo- lub leworęczność)
				$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
				$zawodnik->selectPlayer($value['id_zawodnik']);
				//dalsze szczegóły dotyczące związku zawodnika z drużyną
				if(!empty($value['data_od']))
					echo '<p>Gra w drużyne od: <strong>'.$value['data_od'].'</strong></p>';
				if(!empty($value['data_do']))
					echo '<p>Gra w drużyne do: <strong>'.$value['data_do'].'</strong></p>';
				if(!empty($value['pozycja']))	
					echo '<p>Pozycja: <strong>'.$value['pozycja'].'</strong></p>';
				if(!empty($value['funkcja']))
					echo '<p>Funkcja: <strong>'.$value['funkcja'].'</strong></p>';
				
				echo '</div>'; // <!-- end col-lg-4 -->
				
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
	
	/**
	* function editSingleTeam
	* Funkcja pobiera dane dotyczące drużyny, formatuje je i przekazuje do wyświetlenia w postaci formularza
	*
	* @param string $id - ID szukanej drużyny
	* @param string $param - parametr decydujący o edycji lub dodaniu
	* @return 0
	*/
	function editSingleTeam($id, $param) {
	// call for data from database
		$stmt = $this->pdo->query('select * from druzyna where id_druzyna='.$id);
		
		foreach ($stmt as $row) {
			//$sex = $row['plec'];
			//jeśli pole photo zawiera obrazek - przypisujemy go pod zmienną $src, w innym przypadku ustawiamy ogólny obrazek
			if($row['photo']) 
				$src = $row['photo'];
			
			else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			// prepare array for passing to function			
			$team['teamName'] = $row['nazwa'];
			$team['teamCategory'] = $row['typ'];
			$team['teamSex'] = $row['plec'];
			$team['teamPhoto'] = $row['photo'];
			$team['teamID'] = $id;
			//$team['fileInput'] = $src;
			//przekazujemy dane do funkcji odpowiedzialnej za wyświetlanie ich
			$this->showTeamForm($team);
	
		}
		$stmt->closeCursor();
	}

	/**
	* function confirmRemoveTeam
	* Funkcja wyświetla prośbę o potwierdzenie chęci usunięca drużyny z bazy danych lub odsyła do funkcji usuwającej dane
	*
	* @param string $id_team - ID drużyny
	* @param string $confirm - istnieje potwierdzenie usunięcia
	* @return 0
	*/
	function confirmRemoveTeam($id_team, $confirm) {
		//jeśli wartość $confirm jest różna od '1' wyświetla dane
		if($confirm != '1') {
			//$this->selectTeam($id_team);
			echo '
				<div class="col-lg-4">
					<p>Czy na pewno <strong>chcesz usunąć</strong> tę drużynę?</p>
					<p><strong>Uwaga:</strong> zostaną także usunięte dane dotyczące drużyny oraz jej powiązań z zawodnikami. Może to skutkować niepełnymi danymi w innych wynikach.</p>
					<a type="button" href="?action=delete&amp;id_team='.$id_team.'&amp;confirm=1" class="btn btn-danger">Usuń (brak cofnięcia akcji)</a>
					<a type="button" href="?action=edit&amp;id_team='.$id_team.'" class="btn btn-default">Anuluj</a>
				</div>';
		}	
		else {
			$this->removeTeam($id_team);
		}
	}		
	
	/**
	* function removeTeam
	* Funkcja sprawdza czy drużyna istnieje i usuwa ją z bazy danych
	*
	* @param string $id_team - ID drużyny
	* @return 0
	*/
	function removeTeam($id_team) {
	
		// check if team is connected to any players
		$try_sql = 'select count(*) from druzyna where id_druzyna='.$id_team;
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		//jeśli są - usuwamy powiązania zawodników z usuwaną drużyną
		if($row[0] >= 1) {
			try {
				/*
				$sql = 'delete from zawodnik_druzyna where id_druzyna='.$id_team;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('delete from zawodnik_druzyna where id_druzyna= :id_druzyna');
				$result->bindValue(':id_druzyna', $id_team, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto powiązania zawodnika z drużyną.</div>
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
		
		// check if team really exists
		$try_sql = 'select count(*) from druzyna where id_druzyna='.$id_team;
		
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		//jeśli podana drużyna istnieje
		if($row[0] >= 1) {
			try {
				/*
				$sql = 'delete from druzyna where id_druzyna='.$id_team;
				$result = $this->pdo->exec($sql);
				*/
				$result = $this->pdo->prepare('delete from druzyna where id_druzyna= :id_druzyna');
				$result->bindValue(':id_druzyna', $id_team, PDO::PARAM_STR);
				$sucess = $result->execute();
				if($sucess) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto drużynę.</div>
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
		
		//link nawigacyjny
		echo '
			<div>Powrót do <a href="admin-teams.php">strony administracyjnej drużynami</a>.</div>
		';
		
	}
	
	/**
	* function editTeamMembers
	* Funkcja zmienia powiązania bądź je dodaje pomiędzy wybranym zawodnikiem a drużyny z którą jest lub ma być powiązany
	*
	* @param string $id_team - ID drużyny
	* @param string $action - akcja (edycja członków drużyny lub dodanie członka drużyny) 
	* @return 0
	*/
	function editTeamMembers($id_team, $action) {
        //wybrano edycje powiazan
		if($action == 'edit_members') {
            //tablice z uzytkownikami przynalezacymi do druzyny
			$current = $this->getCurrentConnections($id_team);
            $past = $this->getPastConnections($id_team);
            //laczymy tablice w jedna   
            $temp = array_merge($current, $past);
			$total = count($temp);
            //w petli wyswietlamy dane wszystkich uzytkownikow
			foreach($temp as $key => $value) {
				//ponowne polaczenie z baza danych poprzez obiekt Player
				$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
				//dla każdego pierwszego elementu z trzech otwieramy diva "wierszowego"
				if(!($key%3)) {
						echo '<div class="row">';
				}	
				//unikalny ciąg znaków potrzebny do wygenerowania ID dla label oraz odpowiadających im pól
				$uniqueID = $id_team.$value['id_zawodnik'];
				echo '
					
					<div class="col-lg-4">';
					$zawodnik->selectPlayer($value['id_zawodnik']);
				echo '	
						<form role="form" action="admin-teams.php" method="post">
						
							<div class="form-group">
								<label for="dateFrom'.$uniqueID.'">Gra w drużynie od:</label>
								<input type="date" class="form-control" name="dateFrom" id="dateFrom'.$uniqueID.'" value="'.$value['data_od'].'">
							</div>
							<div class="form-group">
								<label for="dateTo'.$uniqueID.'">Grał(a) w drużynie do:</label>
								<input type="date" class="form-control" name="dateTo" id="dateTo'.$uniqueID.'" value="'.$value['data_do'].'">
							</div>
							<div class="form-group">
								<label for="position'.$uniqueID.'">Pozycja:</label>
									<select name="position" id="position'.$uniqueID.'" class="form-control">
										<option value="1"'; if($value['pozycja'] == '1') { echo ' selected'; } echo '>1</option>
										<option value="2"'; if($value['pozycja'] == '2') { echo ' selected'; } echo '>2</option>
										<option value="3"'; if($value['pozycja'] == '3') { echo ' selected'; } echo '>3</option>
										<option value="4"'; if($value['pozycja'] == '4') { echo ' selected'; } echo '>4</option>
										<option value="A"'; if($value['pozycja'] == 'A') { echo ' selected'; } echo '>A</option>
									</select>
							</div>
							<div class="form-group">
								<label for="function'.$uniqueID.'">Funkcja:</label>
									<select name="function" id="function'.$uniqueID.'" class="form-control">
										<option value="S"'; if($value['funkcja'] == 'S') { echo ' selected'; } echo '>skip</option>
										<option value="V"'; if($value['funkcja'] == 'V') { echo ' selected'; } echo '>viceskip</option>
										<option value="none"';  if(empty($value['funkcja'])) { echo ' selected'; } echo '>---</option>
									</select>
							</div>
							
							<div class="form-group">
								<input type="hidden" class="form-control" name="formType" value="association">
								<input type="hidden" class="form-control" name="playerID" value="'.$value['id_zawodnik'].'">
								<input type="hidden" class="form-control" name="teamID" value="'.$id_team.'">
							</div>
							
						
							<button type="submit" name="submit" class="btn btn-success">Zapisz</button>
							<button type="submit" name="delete" class="btn btn-danger">Usuń powiązanie</button>
							<a href="admin-teams.php" class="btn btn-default">Anuluj</a>
						</form>
							
					</div>	
				';
				
				//dla 3. (oraz jego krotności) lub ostatniego elementu z tablicy zamykamy div "wierszowy"
				if(($key%3 == 2) || $key == ($total-1)) {
						echo '
							</div>	
						';
				}
					
			
			}
			
			
		}
         //wybrano akcje dodania zawodnika do drużyny
		elseif($action == 'add_member') {
        
            //pobieramy liste wszystkich zawodnikow w bazie
			$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			$all = $zawodnik->selectAll();
			
			echo '
					
					<div class="col-lg-4">
						<form role="form" action="admin-teams.php" method="post">
							<div class="form-group">
								<label for="playerID">Zawodnik:</label>
									<select name="playerID" id="playerID" class="form-control">
									
			';
            //zawodnikow wyswietlamy w formie listy
			foreach ($all as $key => $value) {
				echo '
					<option value="'.$value['id_zawodnik'].'"'; if($value['id_zawodnik'] == 'none') { echo ' selected'; } echo '>'.$value['imie'].' '.$value['nazwisko'].'</option>
					
				';
			
			}
			echo '
								</select>
							</div>	
							<div class="form-group">
								<label for="dateFrom">Gra w drużynie od:</label>
								<input type="date" class="form-control" name="dateFrom" id="dateFrom" value="">
							</div>
							<div class="form-group">
								<label for="dateTo">Grał(a) w drużynie do:</label>
								<input type="date" class="form-control" name="dateTo" id="dateTo" value="">
							</div>
							<div class="form-group">
								<label for="position">Pozycja:</label>
									<select name="position" class="form-control" id="position">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="A">A</option>
									</select>
							</div>
							<div class="form-group">
								<label for="function">Funkcja:</label>
									<select name="function" class="form-control" id="function">
										<option value="S">skip</option>
										<option value="V">viceskip</option>
										<option value="none">---</option>
									</select>
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control" name="formType" value="association">
								<input type="hidden" class="form-control" name="teamID" value="'.$id_team.'">
							</div>
						
							
						
							<button type="submit" name="submit" class="btn btn-success">Zapisz</button>
							<a href="admin-teams.php" class="btn btn-default">Anuluj</a>
			
								
						
						</form>		
					</div>	
			';
		}
	}	
}

?>