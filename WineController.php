<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class WineController {
	private $sqlite3 = null;
	function __construct() {	
		$this->sqlite3 = new PDO('sqlite:messaging.sqlite3');	
	}
	 
	function getAllWine() {
		$wines = null;
		try{
				$sql = "select * from wines";
				$this->sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->sqlite3->query($sql);
				$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
					
		 } catch (PDOException $e) {
		    echo $e->getMessage();
		 }	
		return json_encode($wines, true);					
	}
	
}