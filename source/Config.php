<?php

/**
 * SITE CONFIG
 */
define("SITE", [
    "name" => " Auth em MVV com PHP",
    "desc" => "Apprender a construir uma applicação de autenticação em MVC com php",
    "domain" => "localauth.com",
    "local" => "pt_BR",
    "root" =>"http://localhost/LoginAuth/t1"
]);

/**
 * SITE MINIFY
 */
if ($_SERVER["SERVER_NAME"] == "localhost"){
    require __DIR__."/Minify.php";

}
/**
 * DATABASE CONNECT
 */

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "auth",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * CONFIG SOCIAL
 */
define("SOCIAL",[
    "facebook_page"    => "",
    "facebook_author"  => "",
    "facebook_appId"   => "",
    "twitter_creator"  => "",
    "twitter_site"     => ""

]);

/**
 * MAIL CONNECT
 */

define("MAIL", []);

/**
 * SOCIAL_LOGIN: FACEBOOK
 */
define("FACEBOOK_LOGIN", []);

/**
 * SOCIAL_LOGIN: GOOGLE
 */
define("GOOGLE_LOGIN", []);

?>