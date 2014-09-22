<?php

/**
 * Reads configurations from an ini file
 */
class Config {

  /**
   * An array of configurations
   *
   * @var array
   */
  protected $_configs;

  /**
   *
   * @var Config 
   */
  protected static $instance = null;

  /**
   * Returns an instance of a this class
   * 
   * @return Config
   */
  public static function getInstance() {
    if (self::$instance == null) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

  /**
   * Class constructor
   * 
   */
  protected function __construct() {
    if (!file_exists(CONFIG_FILE)) {
      die('You should specify a configuration file');
    }
    $this->_configs = parse_ini_file(CONFIG_FILE, TRUE);
  }

  /**
   * Returns a configuration reading it from an INI file.
   * 
   * @param type $configuration
   * @return boolean|string
   */
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