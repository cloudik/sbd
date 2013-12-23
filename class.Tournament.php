<?php


	
/*****************************************************************************************/

class Tournament extends Baza {
/*******************************************************/

	/*******************************************************/
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
	
	/*******************************************************/
	function showTournamentData($data, $status) {
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
			
			if($i%3 == 0) {
				echo '<div class="row">';	
			}

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
			
			if(($i%3 == 2) || $i == ($total-1)) {
				echo '
					</div>	
				';
			}
				
			$i++;
		}
	}
	
	/*******************************************************/
	function showTournamentForm($data, $action) {
		if($action == 'addTournament') {
			$type = 'tournament';
			$update = 'insert';
		}	
		if($action == 'addGame') {
			$type = 'game';
			$update = 'insert';
		}
		
		
		$selectedCountry = NULL;
		if(!empty($data['tournamentCountry']))
			$selectedCountry = $data['tournamentCountry'];
		
		echo '
						<form role="form" action="admin-games.php" method="post">
						
							<div class="form-group">
								<label for="tournamentName">Nazwa turnieju:</label>
								<input type="text" class="form-control" name="tournamentName" value="'.$data['tournamentName'].'">
							</div>
							<div class="form-group">
								<label for="tournamentClass">Klasa turnieju:</label>
								<select name="tournamentClass" class="form-control">
									<option value="none"'; if($data['tournamentClass'] == 'none') { echo ' selected'; } echo '>---</option>
									<option value="European Championship"'; if($data['tournamentClass'] == 'European Championship') { echo ' selected'; } echo '>European Championship</option>
									<option value="World Championship"'; if($data['tournamentClass'] == 'World Championship') { echo ' selected'; } echo '>World Championship</option>
									<option value="friendly"'; if($data['tournamentClass'] == 'friendly') { echo ' selected'; } echo '>Turniej towarzyski</option>
								</select>
							</div>
							<div class="form-group">
								<label for="tournamentDateStart">Data startu:</label>
								<input type="date" class="form-control" name="tournamentDateStart" value="'.$data['tournamentDateStart'].'">
							</div>
							<div class="form-group">
								<label for="tournamentDateEnd">Data końca:</label>
								<input type="date" class="form-control" name="tournamentDateEnd" value="'.$data['tournamentDateEnd'].'">
							</div>
							<div class="form-group">
								<label for="tournamentCity">Miasto:</label>
								<input type="text" class="form-control" name="tournamentCity" value="'.$data['tournamentCity'].'">
							</div>
							<div class="form-group">
								<label for="tournamentCountry">Kraj:</label>
								<select name="tournamentCountry" class="form-control">
									<option value="none">---</option>
			';
			$temp = new Country($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);	
			$countryList = $temp->getCountries();

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
							/*
							<div class="form-group">
								<input type="hidden" class="form-control" name="formType" value="association">
								<input type="hidden" class="form-control" name="playerID" value="'.$data['id_zawodnik'].'">
								<input type="hidden" class="form-control" name="teamID" value="'.$id_team.'">
							</div> */
							
			echo '				
							
							<button type="submit" name="submit" class="btn btn-success">Zapisz</button>
							<a href="admin-games.php" class="btn btn-default">Anuluj</a>
						</form>
		';
	}
	
	/*******************************************************/
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
			
			if($flag)
				$this->showTournamentForm($data, 'addTournament');
			else 
				$this->updateTournament($data);
		}
		
	}

	/*******************************************************/
	function showAllGames($id) {
		$sql = 'SELECT * FROM mecz where id_turniej='.$id;
		
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		
		foreach($row as $key => $game) {
			$this->showGameInfo($game);
		}
		
		
	}
	
	/*******************************************************/
	function showGameInfo($game) {
			$id_mecz = $game['id_mecz'];
			$id_team_1 = $game['id_druzyna_1'];
			$id_team_2 = $game['id_druzyna_2'];
			
			
			$sql = 'select * from game_end_stat where id_mecz='.$id_mecz;
			$stmt = $this->pdo->query($sql);	
			$gameStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			
			$druzyna = new Team($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			$teamName1 = $druzyna->getTeamName($id_team_1);
			$teamName2 = $druzyna->getTeamName($id_team_2);
			
			$suma1 = $this->getTotalPoints($id_mecz, $id_team_1);
			$suma2 = $this->getTotalPoints($id_mecz, $id_team_2);
			
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
	
	/*******************************************************/
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
	
	/*******************************************************/
	function getGameStatus($status) {
		$sql = 'select opis from status where id_status='.$status;
		$stmt = $this->pdo->query($sql);	
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $row[0];
	}
	
	/*******************************************************/
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