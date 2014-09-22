#!/usr/bin/php
<?php
define('ISCLI', PHP_SAPI === 'cli');
if (ISCLI === true):
  require_once 'index.php';
else:
  echo "ERROR: this script is callable only from PHPCLI environment.\n";
  exit(1);
endif;
exit(0);