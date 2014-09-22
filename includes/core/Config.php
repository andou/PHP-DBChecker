<?php

class Config {

  protected $_configs;
  protected static $instance = null;

  public static function getInstance() {
    if (self::$instance == null) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

  protected function __construct() {
    if (!file_exists(CONFIG_FILE)) {
      die('You should specify a configuration file');
    }
    $this->_configs = parse_ini_file(CONFIG_FILE, TRUE);
  }

  public function getConfiguration($configuration = FALSE) {
    if (!$configuration) {
      return FALSE;
    }
    $path = explode("_", $configuration);

    $res = $this->_configs;

    foreach ($path as $pathpartial) {
      $res = isset($res[$pathpartial]) ? $res[$pathpartial] : FALSE;
    }
    return $res;
  }

}