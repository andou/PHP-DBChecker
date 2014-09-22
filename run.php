#!/usr/bin/php
<?php
define('ISCLI', PHP_SAPI === 'cli');
if (ISCLI === true):
  if (isset($argv[1]) && $argv[1] === 'describe') {
    require_once 'describe.php';
  } else {
    require_once 'index.php';
  }
else:
  echo "ERROR: this script is callable only from PHPCLI environment.\n";
  exit(1);
endif;
exit(0);