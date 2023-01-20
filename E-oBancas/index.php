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
$router->get("/empresas", "Web:business");
/*
    $router->get("/perfil", "Web:profile");
    $router->get("/cache", "Web:bank");
    $router->get("/empresa", "Web:business");*/


// api users routes
$router->post("/login", "Api:login");
$router->post("/register", "Api:register");

$router->get("/users", "Api:getAll");
$router->get("/user/{id}", "Api:get");
$router->get("/user/{business}", "Api:getUserBusiness");

$router->put("/update/{id}", "Api:update");
$router->delete("/logout", "Api:logout");


// api business routes
$router->post("/create", "Api:create");

$router->get("/business", "Api:getAllBusiness");
$router->get("/business/{id}", "Api:getBusiness");

$router->put("/update/{id}", "Api:update");
$router->delete("/delete", "Api:delete");




$router->dispatch();