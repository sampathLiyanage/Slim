<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:54 PM
 */


class EmployeesCustomEndPoint extends EmployeesEndPoint
{
    public function post($request, $response) {
        $params = $request->getParsedBody();
        try {
            $query = "INSERT INTO employee (first_name,last_name,email,phone_no, date_of_birth) VALUES (?,?,?,?,?)";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute(array(
                $params['first_name'],
                $params['last_name'],
                $params['email'],
                $params['phone_no'],
                $params['date_of_birth']
            ));
            $this->container->logger->info('employee added', array('name' => $params['first_name'].' '.$params['last_name']));
            $response = $response->withStatus(201);
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