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
    $lstEmployeesFinal = [];

    $email = $request->getParam('email', '');

    if (!$email) {
        $lstEmployeesFinal = $lstEmployees;
    } else {
        foreach ($lstEmployees as $key => $employee) {
            if (strpos($employee->email, $email) !== false) {
                $lstEmployeesFinal[] = $employee;
            }
        }
    }

    $args['lstEmployees'] = $lstEmployeesFinal;
    $args['email'] = $email;

    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/{id}', function ($request, $response, $args) {
    $lstEmployees = json_decode(file_get_contents('../database/employees.json'));

    $id = $request->getAttribute('id');
    $employee = null;
    $strSkills = "";

    foreach ($lstEmployees as $key => $value) {
        if ($value->id == $id) {
            $employee = $value;
            break;
        }
    }

    if ($employee) {
        $skills = $employee->skills;

        foreach ($skills as $key => $skill) {
            $strSkills .= ",{$skill->skill}";
        }
    }

    $args['employee'] = $employee;
    $args['skills'] = substr($strSkills, 1);

    return $this->renderer->render($response, 'detail.phtml', $args);
});

$app->get('/{min}/{max}', function ($request, $response, $args) {
    $lstEmployees = json_decode(file_get_contents('../database/employees.json'));
    $min = $request->getAttribute('min', 0);
    $max = $request->getAttribute('max', 100000);

    $lstEmployeesFinal = [];

    foreach ($lstEmployees as $key => $employee) {
        $salary = (double)str_replace(['$', ','], ['', ''], $employee->salary);

        if ($salary > $min && $salary < $max) {
            $lstEmployeesFinal[] = $employee;
        }
    }

    $args['lstEmployees'] = $lstEmployeesFinal;
    $xml = $this->renderer->render($response, 'employees.phtml', $args);

    return $response->withStatus(200)
        ->withHeader('Content-Type', 'text/xml')
        ->write('', $xml);

});