<?php

define('ROOT_DIR', dirname(__FILE__));

require_once ROOT_DIR . "/includes/boot.php";

$checker = new Checker();
Reporter::getInstance()->report($checker->run());

