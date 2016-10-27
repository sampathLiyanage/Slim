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
        // TODO: Implement post() method.
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