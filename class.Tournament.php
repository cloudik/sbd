<?php


/**
* Tournament - klasa potomna dla klasy Baza, zawiera funkcje, które odpowiedzialne są za edycję, 
* dodawanie, usuwanie, walidację danych związanych z zawodami sportowymi.
* @author Marta Chmura, Dawid Piask
* @version 1.1
*/

class Tournament extends Baza {

	/**
	* function showAll
	* Funkcja zwraca listę turniejów, które są w bazie danych w zależności od podanego parametru oraz daty dzisiejszej
	*
	* @param string $status - typ turnieju jaki wyszukujemy (aktywny, zakończony)
	*						  w przypadku braku parametru - funkcja zwróci wszystkie turnieje z bazy
	* @return array - tablica z danymi turniejów
	*/
	function showAll($status) {
		$currentDate = date('Y-m-d');
		
		if(empty($status))
			$sql = 'SELECT * FROM turniej';
		elseif($status == 'active') 
			$sql = 'select * from turniej where data_do is null or data_do > \''.$currentDate.'\'';
		elseif($status == 'past') 
			$sql = 'select * from turniej where data_do < \''.$currentDate.'\'';
			
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $row;
	}
	
	/**
	* function showTournamentData
	* Funkcja wyświetla listę z podstawowymi danymi dotyczącymi turniejów
	*
	* @param array $data - tablica zawierające dane dot. turniejów
	* @param string $status - status turnieju (aktywny, zakończony)
	* @return 0
	*/
	function showTournamentData($data, $status) {
		//w zależności od statusu wyświetlamy odpowiednią informację
		if($status == 'active')
			$msg = 'Aktywne i przyszłe turnieje';
		elseif($status == 'past')
			$msg = 'Zakończone turnieje';
		else 
			$msg = 'Wszystkie turnieje';
		echo '
			<div class="row"><h3 class="ctr">'.$msg.'</h3></div>
		';
		
		$i = 0;
		$total = count($data);
		
		foreach ($data as $key => $tournament) {	
			//dla każdego pierwszego elementu z trzech otwieramy diva "wierszowego"
			if($i%3 == 0) {
				echo '<div class="row">';	
			}
			//nawiązujemy połączenie i pobieramy nazwę kraju goszczącego zawody
			$temp = new Country($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);	
			$hostCountry = $temp->getCountryData($tournament['kraj']);
			
			echo '
				<div class="col-lg-4">
					<a href="?id_tournament='.$tournament['id_turniej'].'"><img alt="140x140" data-src="holder.js/140x140" class="img-circle" style="width: 140px; height: 140px;" src="'.$hostCountry['img'].'"></a>
					<h2><a href="?id_tournament='.$tournament['id_turniej'].'">'.$tournament['nazwa'].'</a></h2>
					<p>Miasto: <strong>'.$tournament['miasto'].'</strong></p>
					<p>Kraj: <strong>'.$hostCountry['nazwa'].'</strong></p>
				</div>
				
			';
			//dla 3. (oraz jego krotności) lub ostatniego elementu z tablicy zamykamy div "wierszowy"
			if(($i%3 == 2) || $i == ($total-1)) {
				echo '
					</div>	
				';
			}
				
			$i++;
		}
	}
	
	/**
	* function showTournamentForm
	* Funkcja wyświetla formularz dot. turniejów, w zależności od akcji (addTournament, addGame)
	* generuje formularz z innymi parametrami
	*
	* @param array $data - tablica zawierające dane do wyświetlenia w formularzu
	* @param string $action - akcja wybrana w formularzu  (addTournament, addGame)
	* @return 0
	*/
	function showTournamentForm($data, $action) {
		if($action == 'addTournament') {
			$type = 'tournament';
			$update = 'insert';
		}	
		if($action == 'addGame') {
			$type = 'game';
			$update = 'insert';
		}
		
		//$selectedCountry przypisujemy NULL, jeśli $data nie było puste przepisujemy jego wartość
		$selectedCountry = NULL;
		if(!empty($data['tournamentCountry']))
			$selectedCountry = $data['tournamentCountry'];
		//wyświetlamy formularz, jeśli $data nie było puste, to uzupełniamy pola danymi
		echo '
						<form role="form" action="admin-games.php" method="post">
						
							<div class="form-group">
								<label for="tournamentName">Nazwa turnieju:</label>
								<input type="text" class="form-control" name="tournamentName" id="tournamentName" value="'.$data['tournamentName'].'">
							</div>
							<div class="form-group">
								<label for="tournamentClass">Klasa turnieju:</label>
								<select name="tournamentClass" id="tournamentClass" class="form-control">
									<option value="none"'; if($data['tournamentClass'] == 'none') { echo ' selected'; } echo '>---</option>
									<option value="European Championship"'; if($data['tournamentClass'] == 'European Championship') { echo ' selected'; } echo '>European Championship</option>
									<option value="World Championship"'; if($data['tournamentClass'] == 'World Championship') { echo ' selected'; } echo '>World Championship</option>
									<option value="friendly"'; if($data['tournamentClass'] == 'friendly') { echo ' selected'; } echo '>Turniej towarzyski</option>
								</select>
							</div>
							<div class="form-group">
								<label for="tournamentDateStart">Data startu:</label>
								<input type="date" class="form-control" id="tournamentDateStart" name="tournamentDateStart" value="'.$data['tournamentDateStart'].'">
							</div>
							<div class="form-group">
								<label for="tournamentDateEnd">Data końca:</label>
								<input type="date" class="form-control" id="tournamentDateEnd" name="tournamentDateEnd" value="'.$data['tournamentDateEnd'].'">
							</div>
							<div class="form-group">
								<label for="tournamentCity">Miasto:</label>
								<input type="text" class="form-control" id="tournamentCity" name="tournamentCity" value="'.$data['tournamentCity'].'">
							</div>
							<div class="form-group">
								<label for="tournamentCountry">Kraj:</label>
								<select name="tournamentCountry" id="tournamentCountry" class="form-control">
									<option value="none">---</option>
			';
			//nawiązujemy nowe połączenie i pobieramy liste wszystkich krajów
			$temp = new Country($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);	
			$countryList = $temp->getCountries();
			//wyświetlamy listę i jeśli dany kraj odpowiada $selectedCountry - oznaczamy jako 'selected'
			foreach($countryList as $country) {
								echo '
                                   <option value="'.$country['id_kraj'].'"'; 
										if($country['id_kraj'] == $selectedCountry) echo ' selected';
                                   echo '>'.$country['nazwa'].'</option>
                                    ';
            }
			echo '
								</select>
							</div>
							<input type="hidden" class="form-control" name="formType" value="'.$type.'">
							<input type="hidden" class="form-control" name="updateType" value="'.$update.'">
			';
			echo '				
							
							<button type="submit" name="submit" class="btn btn-success">Zapisz</button>
							<a href="admin-games.php" class="btn btn-default">Anuluj</a>
						</form>
		';
	}
	
	/**
	* function validate
	* Funkcja sprawdza czy wybrane pola formularza nie są puste
	*
	* @param array $data - tablica zawierające dane do sprawdzenia
	* @param string $formType - typ formularza
	* @return 0
	*/
	function validate($data, $formType) {
		$flag = 0;
		if($formType == 'tournament') {
			foreach ($data as $key => $value) {
				if((empty($value)) && (($key !='submit'))) {
					echo '
						<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona.</div>
					';
					$flag = 1;
					
				}
			}
			//jeśli jest ustawiona flaga - znaczy został wykryty błąd i pokazujemy jeszcze raz formularz z danymi
			if($flag)
				$this->showTournamentForm($data, 'addTournament');
			else 
				$this->updateTournament($data);
		}
		
	}

	/**
	* function showAllGames
	* Funkcja wyświetla dane wszystkich meczy z danego turnieju
	*
	* @param string $id - ID turnieju
	* @return 0
	*/
	function showAllGames($id) {
		$sql = 'SELECT * FROM mecz where id_turniej='.$id;
		
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		
		foreach($row as $key => $game) {
			$this->showGameInfo($game);
		}
		
		
	}
	
	/**
	* function showGameInfo
	* Funkcja wyświetla dane meczu
	*
	* @param array $game - tablica zawierające dane dotyczące danego meczu
	* @return 0
	*/
	function showGameInfo($game) {
			$id_mecz = $game['id_mecz'];
			$id_team_1 = $game['id_druzyna_1'];
			$id_team_2 = $game['id_druzyna_2'];
			
			//pobieramy dane statystyczne danego meczu
			$sql = 'select * from game_end_stat where id_mecz='.$id_mecz;
			$stmt = $this->pdo->query($sql);	
			$gameStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			
			//pobieramy pełne nazwy drużyn biorących udział w meczu
			$druzyna = new Team($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			$teamName1 = $druzyna->getTeamName($id_team_1);
			$teamName2 = $druzyna->getTeamName($id_team_2);
			
			//wyliczamy sumę punktów zdobytych
			$suma1 = $this->getTotalPoints($id_mecz, $id_team_1);
			$suma2 = $this->getTotalPoints($id_mecz, $id_team_2);
			
			//pobieramy status meczu
			$status = $this->getGameStatus($game['status']);
			
			echo '
			<hr class="featurette-divider">
			';
			
			
			echo '
			<div class="row">
				<div class="col-lg-4">
					<p><strong>Data:</strong> '.$game['data'].'</p>
					<p><strong>Sheet:</strong> '.$game['sheet'].'</p>
					<p><strong>Status:</strong> '.$status.'</p>
				</div>
			</div>';
			
			echo '
			<div class="row">
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th>#</th>
						<th>Hammer</th>
						<th>End 1</th>
						<th>End 2</th>
						<th>End 3</th>
						<th>End 4</th>
						<th>End 5</th>
						<th>End 6</th>
						<th>End 7</th>
						<th>End 8</th>
						<th>End 9</th>
						<th>End 10</th>
			';	
				//jeśli nie jest pusta wartość od 11 endu wyświetlamy dodatkową kolumnę
				if(!empty($gameStats[0]['end_11'])) {
					echo '
						<th>End 11</th>
					';	
				}	
			echo '	
						<th>Suma:</th>
					</tr>
					<tr>
						<td><a href="team.php?id_team='.$id_team_1.'">'.$teamName1.'</a></td>
			';
			//jeśli drużyna #1 zdobyła hammera/wygrała LSD wyświetlamy * oraz odleglość
			if($id_team_1 == $game['hammer']) {
				echo '
						<td>* / '.$game['LSD'].'cm</td>
				';
			}
			else {
				echo '
						<td></td>
				';
			}	
			
			echo '
						<td>'.$gameStats[0]['end_1'].'</td>
						<td>'.$gameStats[0]['end_2'].'</td>
						<td>'.$gameStats[0]['end_3'].'</td>
						<td>'.$gameStats[0]['end_4'].'</td>
						<td>'.$gameStats[0]['end_5'].'</td>
						<td>'.$gameStats[0]['end_6'].'</td>
						<td>'.$gameStats[0]['end_7'].'</td>
						<td>'.$gameStats[0]['end_8'].'</td>
						<td>'.$gameStats[0]['end_9'].'</td>
						<td>'.$gameStats[0]['end_10'].'</td>
						<td>'.$suma1.'</td>
					</tr>
					<tr>
						<td><a href="team.php?id_team='.$id_team_2.'">'.$teamName2.'</a></td>
			';
			//jeśli drużyna #2 zdobyła hammera/wygrała LSD wyświetlamy * oraz odleglość
			if($id_team_2 == $game['hammer']) {
				echo '
						<td>* / '.$game['LSD'].'cm</td>
				';
			}
			else {
				echo '
						<td></td>
				';
			}
			
			echo '	
						<td>'.$gameStats[1]['end_1'].'</td>
						<td>'.$gameStats[1]['end_2'].'</td>
						<td>'.$gameStats[1]['end_3'].'</td>
						<td>'.$gameStats[1]['end_4'].'</td>
						<td>'.$gameStats[1]['end_5'].'</td>
						<td>'.$gameStats[1]['end_6'].'</td>
						<td>'.$gameStats[1]['end_7'].'</td>
						<td>'.$gameStats[1]['end_8'].'</td>
						<td>'.$gameStats[1]['end_9'].'</td>
						<td>'.$gameStats[1]['end_10'].'</td>
						<td>'.$suma2.'</td>
					</tr>
				</table>
			</div>
			</div>
			';
	
	}
	
	/**
	* function getTotalPoints
	* Funkcja wylicza ilość punktów zdobytych w danym meczu przez daną drużynę
	*
	* @param string $id_game - ID meczu
	* @param string $id_team - ID drużyny
	* @return integer $suma - suma zdobytych punktów
	*/
	function getTotalPoints($id_game, $id_team) {
		$sql = 'select end_1, end_2, end_3, end_4, end_5, end_6, end_7, end_8, end_9, end_10, end_11 from game_end_stat where id_mecz='.$id_game.' and id_druzyna='.$id_team;
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		
		$suma = 0;
		if(!empty($row)) {
			foreach($row as $key => $value) {
				if(($value == 'X') || ($value == NULL))
					$end = 0;
				else 
					$end = $value;
					
				$suma += $end;
			}
		}	
		return $suma;
	}
	
	/**
	* function getGameStatus
	* Funkcja zwraca słowny opis (live, running)
	*
	* @param integer $status - ID statusu
	* @return string $suma - słowny opis
	*/
	function getGameStatus($status) {
		$sql = 'select opis from status where id_status='.$status;
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $row[0];
	}
	
	/**
	* function getGamesWithStatus
	* Funkcja wyświetla wszystkie mecze o podanym statusie (live lub running)
	*
	* @param string $status - nazwa statusu
	* @return 0
	*/
	function getGamesWithStatus($status) {
		if($status == 'live')
			$id_status = 1;
		else 
			$id_status = 2;
		
		$sql = 'select * from mecz where status ='.$id_status;
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		//return $row[0];

		foreach($row as $key => $value) {
		
			$this->showGameInfo($value);
		}
		
	}
}	
?>