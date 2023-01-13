<?php

// show php errors
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

// composer autoload
require __DIR__ . "/vendor/autoload.php";
// autoload from project
require __DIR__ . "/Source/autoload.php";

use CoffeeCode\Router\Router;
//$router = new Router("http://localhost");
$router = new Router("http://localhost");

// controller routes
$router->namespace("Source\Controller");

$router->get("/", "Web:home");
$router->get("/home", "Web:home");
$router->get("/registro", "Web:register");
$router->get("/perfil", "Web:profile");
/*
    $router->get("/perfil", "Web:profile");
    $router->get("/cache", "Web:bank");
    $router->get("/empresa", "Web:business");*/


// api routes
$router->post("/user", "Api:register");
$router->delete("/user", "Api:logout");

$router->get("/users", "Api:getAll");
$router->get("/user/{id}", "Api:get");

$router->post("/user/login", "Api:login");
$router->put("/users/{id}", "Api:get");

$router->post("/empresa", "Api:register");
$router->delete("/empresa", "Api:logout");

$router->get("/empresas", "Api:getAll");
$router->get("/empresa/{id}", "Api:get");

$router->post("/empresa/login", "Api:login");
$router->put("/empresas/{id}", "Api:get");





$router->dispatch();