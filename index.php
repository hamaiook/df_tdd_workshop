<?php
require_once __DIR__.'/vendor/autoload.php'; 
require 'controllers/WineController.php';
require 'dao/WineDaoPdo.php';
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application(); 
$app['debug'] = true;
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app['wineDao'] = $app->share(function () {
    return new WineDaoPdo();
});
$app['wine.controller'] = $app->share(function() use ($app) {
    return new WineController($app);
});

$app->get('/wines', 'wine.controller:getAllWine');

$app->delete('/wines/{id}', 'wine.controller:deleteWine');

$app->post('/wines', 'wine.controller:insertWine');

$app->put('/wines/{id}', 'wine.controller:updateWine');

$app->post('/wines/search','wine.controller:searchWine'); 

$app->run(); 
