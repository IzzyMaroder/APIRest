<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('core/bootstrap.php');
class OrdersController
{
    
    public function read()
    {
        

        $request = new APIRequest;
        $request->decodeHttpRequest();

        $db = new db();
        $db->openConnection();

        $orders = new Orders($db);

        $recordset = $orders->selectAll();

        if ($recordset !== false) {
            http_response_code(201);
            echo json_encode($recordset);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No orders found"));
        }
    }

    public function create()
    {

        

        $request = new APIRequest;
        $request->decodeHttpRequest();
        $data = $request->getBody();

        $db = new db();
        $db->openConnection();

        $order = new Orders($db);

        if (
            !empty($data['date']) &&
            !empty($data['destination']) &&
            !empty($data['products'])
        ) {
            if ($order->create($data)) {
                http_response_code(201);
                echo json_encode(array("message" => "Order added"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Cannot add order"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Missing data"));
        }
    }

    public function update()
    {
        
        $request = new APIRequest;
        $request->decodeHttpRequest();
        $data = $request->getBody();

        $db = new db();
        $db->openConnection();

        $order = new Orders($db);

        if (
            !empty($data['id']) &&
            !empty($data['date']) &&
            !empty($data['destination']) &&
            !empty($data['products'])
        ) {
            if ($order->update($data)) {
                http_response_code(200);
                echo json_encode(array("message" => "Order updated"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Cannot update order"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Missing data"));
        }
    }

    public function delete()
    {
        

        $request = new APIRequest;
        $request->decodeHttpRequest();
        $data = $request->getBody();

        $db = new db();
        $db->openConnection();

        $order = new Orders($db);

        if (!empty($data['id'])) {
            if ($order->delete($data)) {
                http_response_code(200);
                echo json_encode(array("message" => "Order deleted"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Cannot delete the order"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Missing data"));
        }
    }
}
