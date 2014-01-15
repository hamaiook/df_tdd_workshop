<?php
require_once __DIR__.'/vendor/autoload.php'; 
require 'WineController.php';
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application(); 
$app['debug'] = true;

$app->get('/wines', 'WineController::getAllWine');

$app->delete('/wines/{id}', 'WineController::deleteWine');

$app->post('/wines', 'WineController::insertWine');

$app->put('/wines/{id}', 'WineController::updateWine');

$app->post('/wines/search','WineController::searchWine'); 

$app->run(); 
