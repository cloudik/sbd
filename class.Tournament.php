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

}	
?>