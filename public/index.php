<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "pass";
$config['db']['dbname'] = "slim";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

//employees
$app->get('/employees', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    try {
        $query = "SELECT * FROM employee";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $response = $response->withStatus(200);
        $response->getBody()->write(json_encode($result));
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

$app->get('/employee/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    try {
        $query = "SELECT * FROM employee WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array($id));
        $result = $stmt->fetchAll();
        $response = $response->withStatus(200);
        $response->getBody()->write(json_encode($result[0]));
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

$app->post('/employees', function (Request $request, Response $response) {
    $params = $request->getParsedBody();
    try {
        $query = "INSERT INTO employee (first_name,last_name,email,phone_no) VALUES (?,?,?,?)";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            $params['first_name'],
            $params['last_name'],
            $params['email'],
            $params['phone_no']
        ));
        $response = $response->withStatus(201);
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }

    return $response;
});

$app->put('/employee/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $params = $request->getParsedBody();
    try {
        $query = "UPDATE employee SET first_name = ?, last_name = ?, email = ?, phone_no = ? Where id=?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            $params['first_name'],
            $params['last_name'],
            $params['email'],
            $params['phone_no'],
            $id
        ));
        $response = $response->withStatus(200);
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

$app->delete('/employee/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $params = $request->getParsedBody();
    try {
        $query = "DELETE FROM employee WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            $id
        ));
        $response = $response->withStatus(200);
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

//job
$app->get('/jobs', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    try {
        $query = "SELECT * FROM job";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $response = $response->withStatus(200);
        $response->getBody()->write(json_encode($result));
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

$app->get('/job/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    try {
        $query = "SELECT * FROM job WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array($id));
        $result = $stmt->fetchAll();
        $response = $response->withStatus(200);
        $response->getBody()->write(json_encode($result[0]));
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

$app->post('/jobs', function (Request $request, Response $response) {
    $params = $request->getParsedBody();
    try {
        $query = "INSERT INTO job (job_title,salary) VALUES (?,?)";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            $params['job_title'],
            $params['salary']
        ));
        $response = $response->withStatus(201);
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }

    return $response;
});

$app->put('/job/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $params = $request->getParsedBody();
    try {
        $query = "UPDATE job SET job_title = ?, salary = ? Where id=?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            $params['job_title'],
            $params['salary'],
            $id
        ));
        $response = $response->withStatus(200);
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});

$app->delete('/job/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $params = $request->getParsedBody();
    try {
        $query = "DELETE FROM job WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            $id
        ));
        $response = $response->withStatus(200);
    } catch(Exception $e) {
        $response = $response->withStatus(500);
        $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
    }
    return $response;
});


$app->run();