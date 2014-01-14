<?php
require_once 'WineDaoPdo.php';
use Symfony\Component\HttpFoundation\Request;

class WineController {
	private $sqlite3 = null;
	private $wineDao = null;
	function __construct() {	
		$this->sqlite3 = new PDO('sqlite:messaging.sqlite3');	
		$this->wineDao = new WineDaoPdo();
	}
	 
	function getAllWine() {
		$wines = $this->wineDao->getAllWine();
		return json_encode($wines, true);					
	}
	

	function deleteWine($id) {
	  try{
			$this->wineDao->deleteWine($id);		
		}catch(PDOException $e){
			return json_encode("delete is not successful", true);		
		}
		return json_encode("success", true);		
	}
	
	function insertWine() {
		$request = new Request();
		$data = json_decode($request->getContent(), true);
		try{
			$this->wineDao->insertWine($data);
		}catch(PDOExection $e){
			return json_encode("insert is not successful", true);		
		}
		return json_encode("success", true);
	}
	
	function updateWine($id) {
		$request = new Request();
		$data = json_decode($request->getContent(), true);
		$data["id"] = $id;
		try{
			$this->wineDao->updateWine($data);
		}catch(PDOExection $e){
			return json_encode("update is not successful", true);		
		}
			return json_encode("success", true);					
	}
	
	function searchWine() {
		$wines = null;
		$request = new Request();
	 	$data = json_decode($request->getContent(), true);
		try{
				$sql = "select * from wines where title like :title";				
				$this->sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->sqlite3->prepare($sql);			        
				$stmt->execute(array('%'.$data['title'].'%'));
				$wines = $stmt->fetchAll();
		  } catch (PDOException $e) {
		    echo $e->getMessage();
		  }	
			return json_encode($wines, true);		
		
	}
	
}