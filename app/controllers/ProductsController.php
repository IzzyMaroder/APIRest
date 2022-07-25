<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('core/bootstrap.php');
class ProductsController
{
    public function read()
    {
        

        $request = new APIRequest;
        $request->decodeHttpRequest();

        $db = new db();
        $db->openConnection();

        $products = new Products($db);

        $recordset = $products->selectAll();

        if ($recordset !== false) {
            http_response_code(201);
            echo json_encode($recordset);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No products found"));
        }
    }

    public function create()
    {
        

        $request = new APIRequest;
        $request->decodeHttpRequest();
        $data = $request->getBody();

        $db = new db();
        $db->openConnection();
        $product = new Products($db);

        if (
            !empty($data['name']) &&
            !empty($data['co2'])
        ) {
            if ($product->create($data)) {
                http_response_code(201);
                echo json_encode(array("message" => "Product added"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Cannot add product"));
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

        $product = new Products($db);

        if (
            !empty($data['id']) &&
            !empty($data['name']) &&
            !empty($data['co2'])
        ) {
            if ($product->update($data)) {
                http_response_code(200);
                echo json_encode(array("message" => "Product updated"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Cannot update product"));
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

        $product = new Products($db);
        if (!empty($data['id'])) {
            if ($product->delete($data)) {
                http_response_code(200);
                echo json_encode(array("message" => "Product deleted"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Cannot delete the product"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Missing data"));
        }
    }
}
