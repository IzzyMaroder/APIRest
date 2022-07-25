<?php

include_once 'core/Router.php';
include_once 'core/APIRequest.php';
$routes = include_once 'routes.php';
die(var_dump("hello"));
$request = new APIRequest;
$request->decodeHttpRequest();

$fileContent = file(__DIR__.'/.env');
foreach($fileContent as $envVar){
       putenv(trim($envVar));} 

$router = new Router;
$router->load($routes);
$router->direct($request->getPath(), $request->getMethod());
