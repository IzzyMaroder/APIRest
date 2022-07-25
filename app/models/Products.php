<?php

class Products
{

    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function selectAll()
    {
        $sql = "
            SELECT products.id, products.name, products.co2 
            FROM products;";
        $st = $this->pdo->getConnection()->prepare($sql);
        $st->execute();
        if ($st->execute()) {
            $rows = array();
            while (($row = $st->fetch(PDO::FETCH_ASSOC)) !== false) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return false;
        }
    }

    function create(array $data)
    {
        $sql = "
            INSERT INTO products (
                name, 
                co2) 
            VALUES (
                :name, 
                :co2
            )";
        $st = $this->pdo->getConnection()->prepare($sql);
        $params = array(
            'name' => $data['name'],
            'co2' => $data['co2']
        );
        if ($st->execute($params)) {
            return true;
        }
    }

    function update(array $data)
    {

        $sql = " 
            UPDATE products 
            SET name = :name, co2 = :co2 
            WHERE id = :id";
        $st = $this->pdo->getConnection()->prepare($sql);
        $params = array(
            'id' => $data['id'],
            'name' => $data['name'],
            'co2' => $data['co2'],
        );
        if ($st->execute($params)) {
            return true;
        }
    }

    function delete(array $data)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $st = $this->pdo->getConnection()->prepare($sql);
        $params = array('id' => $data['id']);
        if ($st->execute($params)) {
            return true;
        }
    }
}
