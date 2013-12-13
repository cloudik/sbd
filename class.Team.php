<?php


	
/*****************************************************************************************/

class Team extends Baza {
/*******************************************************/
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
	
	function numberOfTeams() {
		$stmt = $this->pdo->query('select count(*) from druzyna');
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	function getTeamData($id_team) {
		$stmt = $this->pdo->query('SELECT * FROM druzyna where id_druzyna='.$id_team);
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $rows;
	}
	
	function getCurrentConnections($id_team) {
		$currentDate = date('Y-m-d');
		$sql = 'SELECT * FROM zawodnik_druzyna where id_druzyna='.$id_team.' and data_do is NULL';
		$stmt = $this->pdo->query($sql);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $rows;
	}
	
	function getPastConnections($id_team) {
		$currentDate = date('Y-m-d');
		$sql = 'SELECT * FROM zawodnik_druzyna where id_druzyna='.$id_team.' and data_do >'.$currentDate;
		$stmt = $this->pdo->query($sql);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $rows;
	}
	
	function showTeamForm($team) {
		$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		
		
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
							<input type="text" class="form-control" name="teamName" value="'.$teamName.'">
						</div>
						<div class="form-group">
							<label for="teamCategory">Kategoria wiekowa:</label>
								<select name="teamCategory" class="form-control">
									<option value="senior"'; if($teamCategory == 'senior') { echo ' selected'; } echo '>senior</option>
									<option value="junior"'; if($teamCategory == 'junior') { echo ' selected'; } echo '>junior</option>
								</select>
						</div>
						<div class="form-group">
							<label for="teamSex">Kategoria:</label>
								<select name="teamSex" class="form-control">
									<option value="K"'; if($teamSex == 'K') { echo ' selected'; } echo '>kobieca</option>
									<option value="M"'; if($teamSex == 'M') { echo ' selected'; } echo '>męska</option>
									<option value="X"'; if($teamSex == 'X') { echo ' selected'; } echo '>mixtowa</option>
								</select>
						</div>
						<div class="form-group">
							<label for="teamPhoto">Zdjęcie:</label>
							<input type="text" class="form-control" name="teamPhoto" value="'.$teamPhoto.'">
						</div>
						
						<div class="form-group">
							<label for="teamID"></label>
							<input type="hidden" class="form-control" name="teamID" value="'.$teamID.'">
						</div>
						
						<div class="form-group">
							<label for="formType"></label>
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
		
			if(@$_GET['action'] != 'add') {
			echo ' <div class="col-lg-4">';
			echo '
					<hr class="featurette-divider">
					<!--<h2>Heading</h2>-->
					<p>Aby usunąć drużynę wciśnij poniższy przycisk. Uwaga: usunięcie drużyny jest nieodwracalne.</p>
					<a href="?action=delete&id_team='.$teamID.'" class="btn btn-danger">Usuń drużynę</a>
					<hr class="featurette-divider">
			';
			echo '</div>	';
			}
	}
	
	/****************************************************************/
	/* function validate($team)
	/* 
	/* $team must me provided
	/****************************************************************/
	function validate($team, $formType) {
		if($formType == 'teamform') {
			$flag = 0;
			foreach ($team as $key => $value) {
				if(empty($value) && ($key !='teamID')) {
					echo '
						<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona</div>
					';
					$flag = 1;
				}
			}
			if($flag) {
				$this->showTeamForm($team);
			}
			else
				$this->updateTeam($team);
		}		
		if($formType == 'association') {
			$flag = 0;
			
			$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			$name = $zawodnik->getName($team['playerID']);
			
			foreach ($team as $key => $value) {
				
					if((empty($value)) && (($key =='dateFrom') || ($key =='position'))) {
						
						echo '
							<div class="alert alert-danger">Wartość <strong>'.$key.'</strong> nie została wypełniona dla zawodnika '.$name['imie'].' '.$name['nazwisko'].'</div>
						';
						$flag = 1;
					}

			}
			if($flag) {
				$this->editTeamMembers($team['teamID']);
			}
			else
				$this->changeConnection($team);
		}
	}
	/********************************************************************/
	function changeConnection($data) {
		
		if(isset($data['delete'])) {
				try {
					$sql = 'delete from zawodnik_druzyna where id_zawodnik='.$data['playerID'].' and id_druzyna='.$data['teamID'];
					//echo $sql; 
					$result = $this->pdo->exec($sql);
					if($result > 0) {
						
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
			elseif(isset($data['submit'])) {
				try {
					if(empty($data['dateTo']))
						$dateTo = 'NULL';
					else
						$dateTo = '\''.$data['dateTo'].'\'';
						
					if($data['function'] == 'none') 
						$function = 'NULL';
					else
						$function = '\''.$data['function'].'\'';	
					
					
					//check if this player is already in the team
					$test = $this->connectionExists($data['teamID'], $data['playerID']);
					
					if($test) 
						$sql = 'update  zawodnik_druzyna set `id_zawodnik`=\''.$data['playerID'].'\', `id_druzyna`=\''.$data['teamID'].'\', `data_od`=\''.$data['dateFrom'].'\', `data_do`='.$dateTo.', `pozycja`=\''.$data['position'].'\', `funkcja`='.$function.' where id_druzyna='.$data['teamID'].' and id_zawodnik='.$data['playerID'];
					else 
						$sql = 'insert into zawodnik_druzyna (`id_zawodnik`, `id_druzyna`, `data_od`, `data_do`, `pozycja`, `funkcja`) values (\''.$data['playerID'].'\', \''.$data['teamID'].'\', \''.$data['dateFrom'].'\', '.$dateTo.', \''.$data['position'].'\', '.$function.') ';	

					$result = $this->pdo->exec($sql);
					if($result > 0) {
						$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
						$name = $zawodnik->getName($data['playerID']);
						echo '
						<div class="alert alert-success">
							<p>Pomyślnie edytowano powiązanie zawodnika: '.$name['imie'].' '.$name['nazwisko'].'</p>
							<p>Powrót do edycji <a href="'.$data['teamID'].'">drużyny</a>.</p>
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
	
	function connectionExists($id_team, $id_player) {
		$stmt = $this->pdo->query('select count(*) from zawodnik_druzyna where id_zawodnik='.$id_player.' and id_druzyna='.$id_team);
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	/****************************************************************/
	/* function updatePlayer($team)
	/* 
	/* $team must me provided
	/****************************************************************/
	function updateTeam($team) {
	

		if(empty($team['teamID']))
			$action = 'insert';
		else 
			$action = 'edit'; 			

		$teamName = $team['teamName'];
		$teamCategory = $team['teamCategory'];
		$teamSex = $team['teamSex'];
		$teamPhoto = $team['teamPhoto'];
		$teamID = $team['teamID'];
		
		
		if($action == 'insert') {
			try {
				$sql = 'insert into druzyna (`nazwa`, `typ`, `plec`, `photo`) values (\''.$teamName.'\', \''.$teamCategory.'\', \''.$teamSex.'\', \''.$teamPhoto.'\')';
				//echo $sql; 
				$result = $this->pdo->exec($sql);
				if($result > 0) {
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
		elseif($action == 'edit') {
			try {
				$sql = 'update  druzyna set `nazwa`=\''.$teamName.'\', `typ`=\''.$teamCategory.'\', `plec`=\''.$teamSex.'\', `photo`=\''.$teamPhoto.'\' where id_druzyna='.$teamID;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result > 0) {
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
			
		
		echo '
			<div>Powrót do <a href="admin-teams.php">strony administracyjnej drużynami</a>.</div>
		';
		
	}
	
	
	function selectTeams($param) {
		$stmt = $this->pdo->query('SELECT id_druzyna, nazwa, photo FROM druzyna');
		$i = 0;
		$total_rows = $this->numberOfTeams();
		
		foreach($stmt as $row) {
			if($i%3) { 
				//echo '<div class="row">';
			}
			
			if($row['photo']) $src = $row['photo'];
				else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			echo '
					<div class="col-lg-4">
						<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">';
			if($param == 'edit') {
				echo '			
						<h2><a href="?id_team='.$row['id_druzyna'].'&action='.$param.'">'.$row['nazwa'].'</a></h2>
						<p><a href="?action=edit_members&id_team='.$row['id_druzyna'].'" class="btn btn-default">Edytuj powiązania »</a>
				';
						
			}
			else {
				echo '			
						<h2><a href="?id_team='.$row['id_druzyna'].'">'.$row['nazwa'].'</a></h2>
						<!--<p>Donec sed odio dui.</p>-->';
			}
			
			if($param == 'edit') {
				echo '<a class="btn btn-default" href="?id_team='.$row['id_druzyna'].'&action='.$param.'" role="button">Edytuj dane »</a></p>';
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
			
			//echo '<a href="?id_player='.$row['id_zawodnik'].'">'.$row['imie'].' '.$row['nazwisko'].'</a><br />';
			$i++;
		}
		$stmt->closeCursor();
	}
	
	function getTeamName($id) {
		$stmt = $this->pdo->query('select nazwa from druzyna where id_druzyna='.$id);
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	function selectSingleTeam($id) {
		
		$team = $this->getTeamData($id);
		$currentPlayer = $this->getCurrentConnections($id);
		$pastPlayer = $this->getPastConnections($id);
		
		if(empty($team['photo'])) {
			$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
		}
		else $src = $team['photo'];
		
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
		
		$total = count($currentPlayer);
		
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

				$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
				$zawodnik->selectPlayer($value['id_zawodnik']);
				
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
		
		$total = count($pastPlayer);
		
		if($total > 0){
			$i = 0;
			foreach ($pastPlayer as $key => $value) {
				if($i == 0) {
					echo '
						<hr class="featurette-divider">
						<div class="row"><h3 class="ctr">Byli zawodnicy:</h3></div>';
				}	
				if($i%3 == 0) {
					echo '<div class="row">';	
				}
				
				echo '<div class="col-lg-4">';

				$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
				$zawodnik->selectPlayer($value['id_zawodnik']);
				
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

	}
	
	
	function editSingleTeam($id, $param) {
	// call for data from database
		$stmt = $this->pdo->query('select * from druzyna where id_druzyna='.$id);
		
		foreach ($stmt as $row) {
			//$sex = $row['plec'];
			
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
			
		
			
			$this->showTeamForm($team);
	
		}
		$stmt->closeCursor();
	}

	function confirmRemoveTeam($id_team, $confirm) {
		
		if($confirm != '1') {
			//$this->selectTeam($id_team);
			echo '
				<div class="col-lg-4">
					<p>Czy na pewno <strong>chcesz usunąć</strong> tę drużynę?</p>
					<p><strong>Uwaga:</strong> zostaną także usunięte dane dotyczące drużyny oraz jej powiązań z zawodnikami. Może to skutkować niepełnymi danymi w innych wynikach.</p>
					<a type="button" href="?action=delete&id_team='.$id_team.'&confirm=1" class="btn btn-danger">Usuń (brak cofnięcia akcji)</a>
					<a type="button" href="?action=edit&id_team='.$id_team.'" class="btn btn-default">Anuluj</a>
				</div>';
		}	
		else {
			$this->removeTeam($id_team);
		}
	}		
	
	function removeTeam($id_team) {
	
		// check if team is connected to any players
		$try_sql = 'select count(*) from druzyna where id_druzyna='.$id_team;
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		
		if($row[0] >= 1) {
			try {
				$sql = 'delete from zawodnik_druzyna where id_druzyna='.$id_team;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result >= 0) {
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
		
		if($row[0] >= 1) {
			try {
				$sql = 'delete from druzyna where id_druzyna='.$id_team;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result > 0) {
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
		
		
		echo '
			<div>Powrót do <a href="admin-teams.php">strony administracyjnej drużynami</a>.</div>
		';
		
	}
	
	function editTeamMembers($id_team, $action) {
		if($action == 'edit_members') {
			$current = $this->getCurrentConnections($id_team);
			$total = count($current);
			foreach($current as $key => $value) {
				
				$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			
				if(!($key%3)) {
						echo '<div class="row">';
				}	
				
				
				echo '
					
					<div class="col-lg-4">';
					$zawodnik->selectPlayer($value['id_zawodnik']);
				echo '	
						<form role="form" action="admin-teams.php" method="post">
						
							<div class="form-group">
								<label for="dateFrom">Gra w drużynie od:</label>
								<input type="text" class="form-control" name="dateFrom" value="'.$value['data_od'].'">
							</div>
							<div class="form-group">
								<label for="dateTo">Grał(a) w drużynie do:</label>
								<input type="text" class="form-control" name="dateTo" value="'.$value['data_do'].'">
							</div>
							<div class="form-group">
								<label for="position">Pozycja:</label>
									<select name="position" class="form-control">
										<option value="1"'; if($value['pozycja'] == '1') { echo ' selected'; } echo '>1</option>
										<option value="2"'; if($value['pozycja'] == '2') { echo ' selected'; } echo '>2</option>
										<option value="3"'; if($value['pozycja'] == '3') { echo ' selected'; } echo '>3</option>
										<option value="4"'; if($value['pozycja'] == '4') { echo ' selected'; } echo '>4</option>
										<option value="A"'; if($value['pozycja'] == 'A') { echo ' selected'; } echo '>A</option>
									</select>
							</div>
							<div class="form-group">
								<label for="function">Funkcja:</label>
									<select name="function" class="form-control">
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
				
				
				if(($key%3 == 2) || $key == ($total-1)) {
						echo '
							</div>	
						';
				}
					
			
			}
			
			
		}
		elseif($action == 'add_member') {
			$zawodnik = new Player($this->_dbms, $this->_host, $this->_database, $this->_port, $this->_username, $this->_password);
			$all = $zawodnik->selectAll();
			
			echo '
					
					<div class="col-lg-4">
						<form role="form" action="admin-teams.php" method="post">
							<div class="form-group">
								<label for="position">Zawodnik:</label>
									<select name="playerID" class="form-control">
									
			';
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
								<input type="text" class="form-control" name="dateFrom" value="">
							</div>
							<div class="form-group">
								<label for="dateTo">Grał(a) w drużynie do:</label>
								<input type="text" class="form-control" name="dateTo" value="">
							</div>
							<div class="form-group">
								<label for="position">Pozycja:</label>
									<select name="position" class="form-control">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="A">A</option>
									</select>
							</div>
							<div class="form-group">
								<label for="function">Funkcja:</label>
									<select name="function" class="form-control">
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