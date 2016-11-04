<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/28/16
 * Time: 2:56 AM
 */
class EmployeeTasksEndPoint extends CollectionEndpoint
{

    public function post($request, $response)
    {
        $params = $request->getParsedBody();
        try {
            $query = "INSERT INTO task (name,description) VALUES (?,?)";

            $stmt = $this->db->prepare($query);
            $stmt->execute(array(
                $params['name'],
                $params['description']
            ));
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
            $query = "SELECT * FROM task";

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