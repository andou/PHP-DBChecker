<?php

define('CONFIG_FILE', ROOT_DIR . "/includes/config.ini");
//loading the autoloader class
require_once ROOT_DIR . "/includes/Autoloader.php";
$autoloader = new Autoloader;
$autoloader->register();
