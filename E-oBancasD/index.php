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
$router = new Router("");

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
$router->post("/login", "Api:login");
$router->delete("/logout", "Api:logout");
$router->post("/register", "Api:register");

$router->get("/users", "Api:getAll");
$router->get("/users/{id}", "Api:get");


$router->dispatch();