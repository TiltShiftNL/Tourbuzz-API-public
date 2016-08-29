<?php

$app->get('/berichten/{jaar}/{maand}/{dag}', function ($request, $response, $args) {
    var_dump($args);die;
});