<?php
// Routes

//$app->get('/[{name}]', function ($request, $response, $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});

$app->get('/', function ($request, $response, $args) {
    $lstEmployees = json_decode(file_get_contents('../database/employees.json'));

    $args['lstEmployees'] = $lstEmployees;

    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/{id}', function ($request, $response, $args) {
    $lstEmployees = json_decode(file_get_contents('../database/employees.json'));

    $id = $request->getAttribute('id');

    return $this->renderer->render($response, 'index.phtml', $args);
});