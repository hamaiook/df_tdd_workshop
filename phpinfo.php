<?php
require_once __DIR__.'/vendor/autoload.php'; 
require 'WineController.php';
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application(); 
$app['debug'] = true;

$sqlite3 = new PDO('sqlite:messaging.sqlite3');


$app->get('/wines', 'WineController::getAllWine');

$app->delete('/wines/{id}', 'WineController::deleteWine');

$app->post('/wines', function(Request $request) use($app, $sqlite3) { 

 $data = json_decode($request->getContent(), true);
	try{
			$sql = "insert into wines 
				(title,grapes,price,country,region,year,note) 
			  values 
				(:title,:grapes,:price,:country,:region,:year,:note)";
			$sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $sqlite3->prepare($sql);
			$stmt->execute($data);
			$pdo = null;		
	  } catch (PDOException $e) {
	    echo $e->getMessage();
	  }	
		return json_encode("success", true);					
});

$app->put('/wines/{id}', function(Request $request, $id) use($app, $sqlite3) { 
	$data = json_decode($request->getContent(), true);
	$data["id"] = $id;
	var_dump($data);
	try{
			$sql = "update wines set title = :title, grapes = :grapes, price = :price, country = :country, region = :region, year = :year, note = :note where id = :id";
			$sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $sqlite3->prepare($sql);
			$stmt->execute($data);
			$pdo = null;		
	  } catch (PDOException $e) {
	    echo $e->getMessage();
	  }	
		return json_encode("success", true);					
});


$app->post('/wines/search', function(Request $request) use($app, $sqlite3) { 
	$wines = null;
 	$data = json_decode($request->getContent(), true);
	try{
			$sql = "select * from wines where title like :title";				
			$sqlite3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $sqlite3->prepare($sql);			        
			$stmt->execute(array('%'.$data['title'].'%'));
			$wines = $stmt->fetchAll();
			$pdo = null;	
	  } catch (PDOException $e) {
	    echo $e->getMessage();
	  }	
		return json_encode($wines, true);					
});

$app->run(); 
