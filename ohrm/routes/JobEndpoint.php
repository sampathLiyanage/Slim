<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:55 PM
 */


class JobEndPoint extends ResourceEndpoint
{

    public function post($request, $response) {
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
    }

    public function get($request, $response) {
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
    }

    public function put($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "UPDATE job SET job_title = ?, salary = ? Where id=?";

            $stmt = $this->container->db->prepare($query);
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
    }

    public function delete($request, $response) {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        try {
            $query = "DELETE FROM job WHERE id = ?";

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