<?php
class WineDaoPdo{
	private $sqlite3 = null;
	
	function __construct(){
		$this->sqlite3 = new PDO('sqlite:messaging.sqlite3');	
	}
	
	function getAllWine(){
		$wines = null;
		try{
				$sql = "select * from wines";
				$this->sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->sqlite3->query($sql);
				$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
		 } catch (PDOException $e) {
		    echo $e->getMessage();
		 }	
		 return $wines;
	}
	function deleteWine($id){
		try{
				$sql = "delete from wines where id = :id";
				$this->sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->sqlite3->prepare($sql);
				$stmt->execute(array($id));	
		} catch (PDOException $e) {
		    echo $e->getMessage();
		}
	}
	
	function insertWine($data){
	 try{
		 		$sql = "insert into wines 
					(title,grapes,price,country,region,year,note) 
				  values 
					(:title,:grapes,:price,:country,:region,:year,:note)";
				$this->sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->sqlite3->prepare($sql);
				$stmt->execute($data);
			} catch (PDOException $e) {
		    echo $e->getMessage();
			}	
	}
	
	function updateWine($data){
		try{
				$sql = "update wines set title = :title, grapes = :grapes, price = :price, country = :country, region = :region, year = :year, note = :note where id = :id";
				$this->sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->sqlite3->prepare($sql);
				$stmt->execute($data);	
		  } catch (PDOException $e) {
		    echo $e->getMessage();
		  }	
	}
	
}
	
