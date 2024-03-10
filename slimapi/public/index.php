<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
// Create Container using PHP-DI
$container = new Container();
$container->set('EmployeeService', function () {
    return new EmployeeService();
});

// Instantiate app
AppFactory::setContainer($container);
$app = AppFactory::create();



// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);



// Define GET /employees endpoint
$app->get('/employees', function (Request $request, Response $response) {
    $employeeService = $this->get('EmployeeService');

    $name = $request->getQueryParams()['name'] ?? null;

    $employees = $employeeService->getEmployees($name);

    $response->getBody()->write(json_encode($employees));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

// Run application
$app->run();

// Mock EmployeeService class
class EmployeeService {
    public function getEmployees($name = null) {
       
        $employees = [
            ["id" => 1, "name" => "John", "role" => "admin"],
            ["id" => 2, "name" => "Jane", "role" => "software developer"],
           
        ];

        if ($name !== null) {
            $employees = array_filter($employees, function($employee) use ($name) {
                return stripos($employee['name'], $name) !== false;
            });
        }

        return array_values($employees); 
    }
   
}