<?php 
/*****************************************************************************************/
class Player extends Baza {
	
	/*******************************************************/
	function selectAll() {
		$stmt = $this->pdo->query('SELECT * FROM zawodnik');
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $row;
	}
    
    function getName($id) {
		$stmt = $this->pdo->query('SELECT imie, nazwisko FROM zawodnik where id_zawodnik='.$id);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $row;
	}
	
	/*******************************************************/
	function selectPlayer($id) {
		$stmt = $this->pdo->query('select * from zawodnik where id_zawodnik='.$id);
		
		foreach ($stmt as $row) {
			
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

	/*******************************************************/
	function numberOfPlayers() {
		$stmt = $this->pdo->query('select count(*) from zawodnik');
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		return $rows[0];
		$stmt->closeCursor();
	}
	
	/*******************************************************/
	function selectSurnames($param) {
		$stmt = $this->pdo->query('SELECT id_zawodnik, imie, nazwisko, photo FROM zawodnik');
		$i = 0;
		$total_rows = $this->numberOfPlayers();
		
		foreach($stmt as $row) {
			if($i%3) { 
				//echo '<div class="row">';
			}
			
			if($row['photo']) $src = 'img/av/'.$row['photo'];
				else $src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
			
			echo '
					<div class="col-lg-4">
						<img src="'.$src.'" style="width: 140px; height: 140px;" class="img-circle" data-src="holder.js/140x140" alt="140x140">
						<h2><a href="?id_player='.$row['id_zawodnik'].'&action='.$param.'">'.$row['imie'].' '.$row['nazwisko'].'</a></h2>
						<p><!--Donec sed odio dui.--></p>
			';		
			if($param == 'edit') {
				echo '
						<p><a class="btn btn-default" href="?id_player='.$row['id_zawodnik'].'&action='.$param.'" role="button">Edytuj dane »</a></p>
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
			
			//echo '<a href="?id_player='.$row['id_zawodnik'].'">'.$row['imie'].' '.$row['nazwisko'].'</a><br />';
			$i++;
		}
		$stmt->closeCursor();
	}
	
	function editSinglePlayer($id, $param) {
		// call for data from database
		$stmt = $this->pdo->query('select * from zawodnik where id_zawodnik='.$id);
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
			
			$this->showPlayerForm($player);
	
		}
		$stmt->closeCursor();
	}

	/****************************************************************/
	/* function showPlayerForm($player)
	/* 
	/* if $player (array) is not provided function will simply output
	/* a form with empty fields to fill out
	/****************************************************************/
	function showPlayerForm($player) {
		
		$src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAACeklEQVR4nO3YMXKjWBRA0d7/UsjISMjIFCpnCWyBjmA0GnW5b5U9bdQnOFXCyPVVfpcP8o9t23b4XT/+9AfgWgRDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIXmLYKZp2odheHnufr/vwzDsy7KcP1vXdR+G4bSu67de7zu5fDCPg3h1fhzH/wxwHMd9nudz+OM4ftv1vpvLBvN41R5Den7PsiznbnAM8NgBbrfbvm3bfrvd9mEY9vv9fp47hrssy3nuK9b703/Dvy6Y40p9dYs4Bvx8i3ge2HF8DHSe5/O28RjPV613NZcN5tGrAU7TtM/zfA7yVwN83gG27ePbzmevdyVvGcwxpHVdPxzgqyv+2GWO3eWr17uStwzmOH42TdOHzxTH+eM55dWzxmeudzVvGcyj5yt+27Z/7R7P31rGcTyPH19/1XpX81cG86v/izx+K9q2f3aDx9/9zPWu6C2C4f8jGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQCIZEMCSCIREMiWBIBEMiGBLBkAiGRDAkgiERDIlgSARDIhgSwZAIhkQwJIIhEQyJYEgEQyIYEsGQ/ARf9kfKnj/wOwAAAABJRU5ErkJggg==';
	
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
							<input type="text" class="form-control" name="nameInput" value="'.$name.'">
						</div>
						<div class="form-group">
							<label for="surnameInput">Nazwisko:</label>
							<input type="text" class="form-control" name="surnameInput" value="'.$surname.'">
						</div>
						<div class="form-group">
							<label for="birthdayInput">Data urodzenia (rrrr-mm-dd):</label>
							<input type="text" class="form-control" name="birthdayInput" type="date" value="'.$birth.'">
						</div>
						<div class="form-group">
							<label for="deliveryInput">Delivery:</label>
								<select name="deliveryInput" class="form-control">
									<option value="L"'; if($delivery == 'L') { echo ' selected'; } echo '>Leworęczny</option>
									<option value="R"'; if($delivery == 'R') { echo ' selected'; } echo '>Praworęczny</option>
								</select>
						</div>
						<div class="form-group">
							<label for="sexInput">Płeć:</label>
								<select name="sexInput" class="form-control">
									<option value="K"'; if($sex == 'K') { echo ' selected'; } echo '>Kobieta</option>
									<option value="M"'; if($sex == 'M') { echo ' selected'; } echo '>Mężczyzna</option>
								</select>
						</div>
						<div class="form-group">
							<label for="countryInput">Kraje:</label>
								<select name="countryInput" class="form-control">
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
							<label for="idPlayer"></label>
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
		
			if($_GET['action'] != 'add') {
			echo ' <div class="col-lg-4">';
			echo '
					<hr class="featurette-divider">
					<!--<h2>Heading</h2>-->
					<p>Aby usunąć zawodnika wciśnij poniższy przycisk. Uwaga: usunięcie zawodnika jest nieodwracalne.</p>
					<a href="?action=delete&id_player='.$idPlayer.'" class="btn btn-danger">Usuń zawodnika</a>
					<hr class="featurette-divider">
			';
			echo '</div>	';
			}
	
	}
	
	/****************************************************************/
	/* function validate($player)
	/* 
	/* $player must me provided
	/****************************************************************/
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
	
	/****************************************************************/
	/* function updatePlayer($player)
	/* 
	/* $player must me provided
	/****************************************************************/
	function updatePlayer($player) {
	

		if(empty($player['idPlayer']))
			$action = 'insert';
		else 
			$action = 'edit'; 			

		$name = $player['nameInput'];
		$surname = $player['surnameInput'];
		$birth = $player['birthdayInput'];
		$delivery = $player['deliveryInput'];
		$sex = $player['sexInput'];
		if($player['countryInput'] == 'none') 
			$playerCountry = 'NULL';
		else
			$playerCountry = '\''.$player['countryInput'].'\'';
		$idPlayer = $player['idPlayer'];
		
		
		if($action == 'insert') {
			try {
				$sql = 'insert into zawodnik (`imie`, `nazwisko`, `data_ur`, `plec`, `kierunek`, `id_kraj`) values (\''.$name.'\', \''.$surname.'\', \''.$birth.'\', \''.$sex.'\', \''.$delivery.'\', '.$playerCountry.')';
				//echo $sql; 
				$result = $this->pdo->exec($sql);
				if($result > 0) {
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
			

		}		
		elseif($action == 'edit') {
			try {
				$sql = 'update  zawodnik set `imie`=\''.$name.'\', `nazwisko`=\''.$surname.'\', `data_ur`=\''.$birth.'\', `plec`=\''.$sex.'\', `kierunek`=\''.$delivery.'\', `id_kraj`='.$playerCountry.' where id_zawodnik='.$idPlayer;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result > 0) {
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
	
	function confirmRemovePlayer($id_player, $confirm) {
		
		if($confirm != '1') {
			$this->selectPlayer($id_player);
			echo '
				<div class="col-lg-4">
					<p>Czy na pewno <strong>chcesz usunąć</strong> tego zawodnika?</p>
					<p><strong>Uwaga:</strong> zostaną także usunięte dane dotyczące użytkownika oraz jego powiązań z drużynami w których grał. Może to skutkować niepełnymi danymi w innych wynikach.</p>
					<a type="button" href="?action=delete&id_player='.$id_player.'&confirm=1" class="btn btn-danger">Usuń (brak cofnięcia akcji)</a>
					<a type="button" href="?action=edit&id_player='.$id_player.'" class="btn btn-default">Anuluj</a>
				</div>';
		}	
		else {
			$this->removePlayer($id_player);
		}
	}		
	
	function removePlayer($id_player) {
	
		// check if player was/is participating in any teams
		$try_sql = 'select count(*) from zawodnik_druzyna where id_zawodnik='.$id_player;
		$stmt = $this->pdo->query($try_sql);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		
		
		if($row[0] >= 1) {
			try {
				$sql = 'delete from zawodnik_druzyna where id_zawodnik='.$id_player;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result > 0) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto powiązania zawodnika z drużynami.</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas usuwania rekorów.</div>
					';
				}
				$result->closeCursor();
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
		
		if($row[0] >= 1) {
			try {
				$sql = 'delete from zawodnik where id_zawodnik='.$id_player;
				//echo $sql;
				$result = $this->pdo->exec($sql);
				if($result > 0) {
					echo '
					<div class="alert alert-success">Pomyślnie usunięto zawodnika.</div>
					';
				}
				else {
					echo '
						<div class="alert alert-danger">Wystąpił błąd podczas usuwania rekorów.</div>
					';
				}
				$result->closeCursor();
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
	
}


/*****************************************************************************************/
	?>