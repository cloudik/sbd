<?php

/*****************************************************************************************/
	
	
/*****************************************************************************************/
class Baza
{    

	protected $_dbms; // = $dbms;
	protected $_host; // = $host;
	protected $_database; // = $database;
	protected $_port; // = $port;
	protected $_username; // = $username;
	protected $_password; // = $password; 

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
	
	function debug($i) {
		echo '<pre>';
		print_r($i);
		echo '</pre>';
	}
	
	function numberOfResults($table) {
		$stmt = $this->pdo->query('select count(*) from '.$table);
		$rows = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rows[0];
	}
	
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
    
     function getCountries() {
        $stmt = $this->pdo->query('select * from kraj');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
    }
}


	
?>