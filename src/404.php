<?php

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("404");

    // Render index view
    return $this->renderer->render($response, '404.phtml', $args);
});
