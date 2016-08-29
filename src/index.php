<?php

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Index '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
