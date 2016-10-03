<?php

$app->get('/', 'App\Controller\IndexController:index');

$app->get('/berichten', 'App\Controller\BerichtenController:index');
$app->get('/berichten/{jaar}/{maand}/{dag}', 'App\Controller\BerichtenController:index');
$app->get('/berichten/{id}', 'App\Controller\BerichtenController:get');
$app->post('/berichten', 'App\Controller\BerichtenController:post');
$app->delete('/berichten', 'App\Controller\BerichtenController:delete');

$app->get('/haltes', 'App\Controller\HaltesController:index');
$app->get('/haltes/{id}', 'App\Controller\HaltesController:index');

$app->get('/parkeerplaatsen', 'App\Controller\ParkeerController:index');
$app->get('/parkeerplaatsen/{id}', 'App\Controller\ParkeerController:index');

$app->get('/afbeeldingen/{id}/', 'App\Controller\AfbeeldingController:transform');

$app->get('/poi', 'App\Controller\PoiController:index');

$app->get('/distance', 'App\Controller\DistanceController:distance');

$app->get('/auth', 'App\Controller\AuthController:token');
$app->post('/auth', 'App\Controller\AuthController:login');
$app->delete('/auth', 'App\Controller\AuthController:logout');

$app->post('/accounts', 'App\Controller\AccountController:create');
$app->get('/accounts', 'App\Controller\AccountController:index');
$app->get('/accounts/{username}', 'App\Controller\AccountController:single');
$app->put('/accounts', 'App\Controller\AccountController:update');
$app->delete('/accounts/{username}', 'App\Controller\AccountController:delete');

$app->post('/vergeten', 'App\Controller\VergetenController:vergeten');
$app->get('/vergeten/{token}', 'App\Controller\VergetenController:checkToken');
$app->put('/vergeten', 'App\Controller\VergetenController:changePasswordByToken');

$app->post('/mail', 'App\Controller\MailController:register');
$app->get('/mail/{token}', 'App\Controller\MailController:confirm');
$app->post('/mail/unsubscribe', 'App\Controller\MailController:unsubscribe');
$app->get('/mail/unsubscribe/{token}', 'App\Controller\MailController:unsubscribeConfirm');
$app->get('/mail', 'App\Controller\MailController:index');

$app->post('/telefoon', 'App\Controller\TelefoonController:register');
$app->delete('/telefoon', 'App\Controller\TelefoonController:unsubscribe');
$app->get('/telefoon', 'App\Controller\TelefoonController:index');