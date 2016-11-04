<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:54 PM
 */


class EmployeesEndPoint extends CollectionEndpoint
{
    public function post($request, $response) {
        $params = $request->getParsedBody();
        try {
            $query = "INSERT INTO employee (first_name,last_name,email,phone_no) VALUES (?,?,?,?)";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute(array(
                $params['first_name'],
                $params['last_name'],
                $params['email'],
                $params['phone_no']
            ));
            $this->container->logger->info('employee added', array('name' => $params['first_name'].' '.$params['last_name']));
            $response = $response->withStatus(201);
        } catch(Exception $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
        }

        return $response;
    }

    public function get($request, $response) {
        $id = $request->getAttribute('id');
        try {
            $query = "SELECT * FROM employee";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $response = $response->withStatus(200);
            $response->getBody()->write(json_encode($result));
        } catch(Exception $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
        }
        return $response;
    }

    public function delete($request, $response)
    {
        // TODO: Implement delete() method.
    }
}