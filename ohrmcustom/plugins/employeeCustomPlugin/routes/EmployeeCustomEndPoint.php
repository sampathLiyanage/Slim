<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:54 PM
 */


class EmployeeCustomEndPoint extends EmployeeEndPoint
{

    public function post($request, $response)
    {
        // TODO: Implement post() method.
    }

    public function put($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "UPDATE employee SET first_name = ?, last_name = ?, email = ?, phone_no = ?, date_of_birth = ? Where id=?";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute(array(
                $params['first_name'],
                $params['last_name'],
                $params['email'],
                $params['phone_no'],
                $params['date_of_birth'],
                $id
            ));
            $response = $response->withStatus(200);
        } catch(Exception $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
        }
        return $response;
    }

}