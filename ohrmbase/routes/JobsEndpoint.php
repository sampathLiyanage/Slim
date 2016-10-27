<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 10/27/16
 * Time: 10:55 PM
 */


class JobsEndPoint extends CollectionEndpoint
{

    public function post($request, $response)
    {
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
            $query = "SELECT * FROM job";

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