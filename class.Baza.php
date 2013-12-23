<?php

/**
* Baza - klasa bazowa odpowiadająca za nawiązanie połączenia z bazą danych oraz zawierająca pomocne funkcje np. debuggujące
* @author Marta Chmura, Dawid Piask
* @version 1.1
*/

class Baza
{    
	protected $_dbms; 
	protected $_host;
	protected $_database;
	protected $_port; 
	protected $_username; 
	protected $_password; 

	/**
	* function __construct
	* Nawiązuje połączenie z bazą danych poprzez bibliotekę PDO
	*
	* @param string $dbms - typ silnika zarządzający bazą danych
	* @param string $host - host na którym znajduje się DBMS
	* @param string $database - nazwa bazy danych
	* @param string $port - port na którym następuję połączenie
	* @param string $username - nazwa użytkownika
	* @param string $password - hasło użytkownika
	* @return 0
	*/
	function __construct($dbms, $host, $database, $port, $username, $password)
	{
		try {
			$this->pdo = new PDO($dbms.':host='.$host.';dbname='.$database.';port='.
			  $port, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->_dbms = $dbms;
			$this->_host = $host;
			$this->_database = $database;
			$this->_port = $port;
			$this->_username = $username;
			$this->_password = $password;
		}
		catch(PDOException $e) {
			echo 'Połączenie nie mogło zostać utworzone:<br> ' . $e->getMessage();
		}
	}
	
	/**
	* function debug
	* Funkcja wyświetla w sposób czytelny dane przekazane do funkcji
	*
	* @param string/array/object $i - obiekt, który chcemy debuggować/wyświetlić
	* @return 0
	*/
	function debug($i) {
		echo '<pre>';
		print_r($i);
		echo '</pre>';
	}
	
	/**
	* function numberOfResults
	* Funkcja wyświetla ilość wierszy w danej tabeli
	*
	* @param string $table - nazwa tabeli z której chcemy uzyskać informację
	* @return integer - ilość wierszy
	*/
	function numberOfResults($table) {
		$stmt = $this->pdo->query('select count(*) from '.$table);
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
	/**
	* function getCountryName
	* Funkcja zwraca nazwę kraju o podanym ID bądź "nieznany", jeśli nie znaleziono kraju o podanym identyfikatorze
	*
	* @param string $id - id kraju
	* @return string - nazwa kraju
	*/
	function getCountryName($id) {
		try {
			$stmt = $this->pdo->query('select nazwa from kraj where id_kraj='.$id);
			$rows = $stmt->fetch(PDO::FETCH_NUM);
			$stmt->closeCursor();
		}
		catch(PDOException $e) {
			$rows[0] = 'nieznany';
		}
		return $rows[0];
	}
	
    /**
	* function getCountries
	* Funkcja zwraca w postaci tablicy asocjacynej wszystkie kraje jakie znajdują się w bazie danych
	*
	* @return array - tablica z krajami
	*/
     function getCountries() {
        $stmt = $this->pdo->query('select * from kraj');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
    }
}


	
?>