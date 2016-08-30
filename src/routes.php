<?php

$app->get('/berichten/{jaar}/{maand}/{dag}', 'App\Controller\BerichtenController:index');