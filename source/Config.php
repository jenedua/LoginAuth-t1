<?php

/**
 * SITE CONFIG
 */

use League\OAuth2\Client\Provider\Facebook;

define("SITE", [
    "name" => " Auth em MVV com PHP",
    "desc" => "Apprender a construir uma applicação de autenticação em MVC com php",
    "domain" => "localauth.com",
    "local" => "pt_BR",
    "root" =>"https://localhost/LoginAuth/t1"
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

define("MAIL", [
    "host"    => "smtp.sendgrid.net",
    "port"    => "587",
    "user"    => "apikey",
    "passwd"  =>"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",
    "from_name" => "Fedner Dabady",
    "from_email"  =>"fednerdab@gmail.com"

]);

/**
 * SOCIAL_LOGIN: FACEBOOK
 */
define("FACEBOOK_LOGIN", [
    'clientId'          => "453158252883335",
    'clientSecret'      => "c56cecc676266a92659f98fef8842b17",
    'redirectUri'       => SITE["root"]."/facebook",
    'graphApiVersion'   => "v12.0"

]);

/**
 * SOCIAL_LOGIN: GOOGLE
 */
define("GOOGLE_LOGIN", [
    'clientId'          => "456931629429-d90clsfgcdd9p5e7qrqvfbj3psckk1id.apps.googleusercontent.com",
    'clientSecret'      => "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",
    'redirectUri'       => SITE["root"]."/google"

]);

?>