<?php
use Symfony\Component\HttpFoundation\Request;

class WineController {
	private $wineDao = null;
	function __construct($app) {		
		$this->wineDao = $app['wineDao'];
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
			$wines = $this->wineDao->searchWine($data);		  
		} catch (PDOException $e) {
			return json_encode("search is not successful", true);	   
	  }	
		return json_encode($wines, true);	
	}
	
}