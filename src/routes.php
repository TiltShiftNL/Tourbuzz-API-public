<?php

$app->get('/berichten/{jaar}/{maand}/{dag}', 'App\Controller\BerichtenController:index');
$app->get('/berichten/{id}', 'App\Controller\BerichtenController:get');