<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/28/16
 * Time: 2:54 AM
 */
class EmployeeTaskEndPoint extends ResourceEndpoint
{

    public function post($request, $response) {
        // TODO: Implement post() method.
    }

    public function get($request, $response) {
        $id = $request->getAttribute('id');
        try {
            $query = "SELECT * FROM task WHERE id = ?";

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
    }

    public function put($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "UPDATE task SET name = ?, description = ? Where id=?";

            $stmt = $this->container->db->prepare($query);
            $stmt->execute(array(
                $params['name'],
                $params['description'],
                $id
            ));
            $response = $response->withStatus(200);
        } catch(Exception $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write('{"error":{"text":'. $e->getMessage() .'}}');
        }
        return $response;
    }

    public function delete($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "DELETE FROM task WHERE id = ?";

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