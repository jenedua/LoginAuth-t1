<?php

ob_start();
session_start();

require __DIR__."/vendor/autoload.php";

//echo "<h1>Olá MUNDO...</h1>";

use CoffeeCode\Router\Router;

$router = new Router(site());
$router->namespace("Source\Controllers");

//var_dump(asset("css/form.css",false));
//die;
//var_dump(site("name"));
/**
 * WEB
 */
$router->group(null);
$router->get("/", "Web:login", "web.login");
$router->get("/cadastrar", "Web:register", "web.register");
$router->get("/recuperar", "Web:forget", "web.forget");
$router->get("/senha/{email}/{forget}", "Web:reset", "web.reset");

/**
 * AUTH
 */
$router->group(null);
$router->post("/login", "Auth:login", "auth.login");
$router->post("/register", "Auth:register" , "auth.register");
$router->post("/forget", "Auth:forget" , "auth.forget");
$router->post("/reset", "Auth:reset" , "auth.reset");


 /**
  * AUTH SOCIAL
  */
  $router->group(null);
  $router->get("/facebook", "Auth:facebook", "auth.facebook");
  $router->get("/google", "Auth:google", "auth.google");


  /**
   * PROFILE
   */
  $router->group("/me");
  $router->get("/", "App:home", "app.home");
  $router->get("/sair", "App:logoff", "app.logoff");
  

   /**
    * ERRORS
    */
    $router->group("ops");
    $router->get("/{errcode}", "Web:error", "web.error");

    /**
     * ROUTE PROCESS
     */
    $router->dispatch();

    /**
     * ERRORS PROCESS
     */
    if($router->error())
    {
        $router->redirect("web.error", ["errcode" => $router->error()]);
    }




ob_end_flush();

