<?php

class TotCO2 {

	protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

	function select(array $data) {

		$params = array();

		$where = array();

		if (isset($data['startDate']) && isset($data['endDate'])) {

			$where[] = "(orders.date BETWEEN :startDate AND :endDate)";
			$params['startDate'] = $data['startDate'];
			$params['endDate'] = $data['endDate'];
		}

		if (isset($data['country'])) {

			$country = $data['country'];
			$where[] = "(orders.destination = :country)";
			$params['country'] = $country;
		}

        if (isset($data['id_product'])) {
			$id_product = $data['id_product'];
            $where[] = "(products.id = :id_product)";
            $params['id_product'] = $id_product;
        }

		$whereClause = '';
		if (count($where) > 0) {
			$whereClause = "WHERE " . join(' AND ', $where);
		}

		$sql= (
			"
				SELECT SUM(products.co2 * orders_rows.quantity) AS CO2spared

				FROM orders

                LEFT JOIN orders_rows
                    ON orders_rows.id_order = orders.id

                LEFT JOIN products
                    ON products.id = orders_rows.id_product

				{$whereClause}

			"
		);

		$st = $this->pdo->getConnection()->prepare($sql);
        if ($st->execute($params)) {
            $rows = array();
            while (($row = $st->fetch(PDO::FETCH_ASSOC)) !== false) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return false;
        }
	}

}
