<?php

class Orders
{

	protected $pdo;

	function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	function selectAll()
	{
		$sql = "
		SELECT
			orders.id,						
			orders.date,					
			orders.destination,			

			orders_rows.id_product,
			orders_rows.quantity,

			products.name,
			products.co2,

			products.co2 * orders_rows.quantity AS co2Risparmiata

		FROM orders

			LEFT JOIN orders_rows
				ON orders_rows.id_order = orders.id

			LEFT JOIN products
				ON products.id = orders_rows.id_product";

		$st = $this->pdo->getConnection()->prepare($sql);
		$st->execute();
		if ($st->execute()) {
			$rows = array();
			while (($row = $st->fetch(PDO::FETCH_ASSOC)) !== false) {
				$rows[] = $row;
			}

			$orders = array();
			$order = array();
			foreach ($rows as $row) {

				if (!isset($orders[(int)$row['id']])) {

					$order['id'] = (int)$row['id'];
					$order['date'] = $row['date'];
					$order['destination'] = $row['destination'];
					$order['products'] = array();

					$order['products'][] = array(
						'id_product' => $row['id_product'],
						'name' => $row['name'],
						'quantity' => (int)$row['quantity'],
						'co2' => (float)$row['co2'],
					);

					$orders[(int)$row['id']] = $order;
				} else {

					$orders[(int)$row['id']]['products'][] = array(
						'id_product' => $row['id_product'],
						'name' => $row['name'],
						'quantity' => (int)$row['quantity'],
						'co2' => (float)$row['co2'],
					);
				}
			}
			return $orders;
		} else {
			return false;
		}
	}

	function create(array $data)
	{
		$sql = "
			INSERT INTO orders (date, destination) 
			VALUES (:date, :destination)";

		$st = $this->pdo->getConnection()->prepare($sql);

		$params = array(
			'date' => $data['date'],
			'destination' => $data['destination'],
		);

		if ($st->execute($params)) {

			$id = $this->pdo->getConnection()->lastInsertId();

			$this->createOrderRows($id, $data['products']);

			return true;
		}
	}

	function update(array $data)
	{
		$sql = "
			UPDATE orders 
			SET date = :date, destination = :destination 
			WHERE id = :id";
		$st = $this->pdo->getConnection()->prepare($sql);

		$parameters = array(
			'id' => $data['id'],
			'date' => $data['date'],
			'destination' => $data['destination'],
		);

		if ($st->execute($parameters)) {

			$this->deleteOrderRows($data['id']);

			$this->createOrderRows($data['id'], $data['products']);

			return true;
		}
	}

	function delete(array $data)
	{

		$sql = "
			DELETE FROM orders 
			WHERE id = :id";
		$st = $this->pdo->getConnection()->prepare($sql);

		if ($st->execute(array('id' => $data['id']))) {

			$this->deleteOrderRows($data['id']);
			return true;
		}
	}

	protected function createOrderRows($id, $products)
	{

		foreach ($products as $row) {
			$sql = "
				INSERT INTO orders_rows
					(id_order, id_product, quantity)
				VALUES
					(:id_order, :id_product, :quantity)
			";

			$st = $this->pdo->getConnection()->prepare($sql);

			$parameters = array(
				'id_order' => $id,
				'id_product' => $row['id_product'],
				'quantity' => $row['quantity'],
			);

			if ($st->execute($parameters)) {
			}
		}
	}

	protected function deleteOrderRows($id)
	{

		$sql = "
			DELETE FROM orders_rows 
			WHERE id_order = :id";
		$st = $this->pdo->getConnection()->prepare($sql);

		$st->execute(array('id' => $id));
	}
}
