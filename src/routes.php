<?php

$app->get('/', 'App\Controller\IndexController:index');

$app->get('/berichten', 'App\Controller\BerichtenController:index');
$app->get('/berichten/{jaar}/{maand}/{dag}', 'App\Controller\BerichtenController:index');
$app->get('/berichten/{id}', 'App\Controller\BerichtenController:get');
$app->post('/berichten', 'App\Controller\BerichtenController:post');
$app->delete('/berichten/{id}', 'App\Controller\BerichtenController:delete');
$app->delete('/berichten', 'App\Controller\BerichtenController:delete');

$app->get('/haltes', 'App\Controller\HaltesController:index');
$app->get('/haltes/{id}', 'App\Controller\HaltesController:index');

$app->get('/parkeerplaatsen', 'App\Controller\ParkeerController:index');
$app->get('/parkeerplaatsen/{id}', 'App\Controller\ParkeerController:index');

$app->get('/afbeeldingen', 'App\Controller\AfbeeldingController:transform');

$app->get('/poi', 'App\Controller\PoiController:index');

$app->get('/distance', 'App\Controller\DistanceController:distance');

$app->get('/auth', 'App\Controller\AuthController:token');
$app->post('/auth', 'App\Controller\AuthController:login');

$app->post('/accounts', 'App\Controller\AccountController:create');
$app->get('/accounts', 'App\Controller\AccountController:index');