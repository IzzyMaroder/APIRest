<?php

return $routes = [
    'GET' => [
        'orders' => 'OrdersController@read',
        'products' => 'ProductsController@read',
        'co2' => 'CO2Controller@read',
    ],
    'PUT' => [
        'orders' => 'OrdersController@update',
        'products' => 'ProductsController@update'
    ],
    'POST' => [
        'orders' => 'OrdersController@create',
        'products' => 'ProductsController@create'
    ],
    'DELETE' => [
        'orders' => 'OrdersController@delete',
        'products' => 'ProductsController@delete'
    ]
];