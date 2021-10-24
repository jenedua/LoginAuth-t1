<?php

ob_start();
session_start();
require __DIR__."/vendor/autoload.php";
echo "<h1>Olá MUNDO...</h1>";

ob_end_flush();

