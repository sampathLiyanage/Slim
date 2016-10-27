<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:54 PM
 */


class EmployeeEndPoint extends ResourceEndpoint
{

    public function post(Request $request, Response $response)
    {
        // TODO: Implement post() method.
    }

    public function get($request, $response) {
        $id = $request->getAttribute('id');
        try {
            $query = "SELECT * FROM employee WHERE id = ?";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute(array($id));
            $result = $stmt->fetchAll();
            $response = $response->withStatus(200);
            $response->getBody()->write(json_encode($result[0]));
        } catch(Exception $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
        }
        return $response;
    }

    public function put($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "UPDATE employee SET first_name = ?, last_name = ?, email = ?, phone_no = ? Where id=?";

            $stmt = $this->container->db->prepare($query);
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
    }

    public function delete ($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "DELETE FROM employee WHERE id = ?";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute(array(
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