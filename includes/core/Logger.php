<?php

/**
 * Writes log files 
 */
class Logger {

  /**
   *
   * @var Config
   */
  protected $_config = NULL;

  /**
   *
   * @var Logger
   */
  protected static $instance = null;

  /**
   * Returns an instance of a this class
   * 
   * @return Logger
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
    $this->_config = Config::getInstance();
  }

  /**
   * Saves a string to a file
   * 
   * @param string $content
   */
  public function saveFile($content) {
    $folder = ROOT_DIR . "/" . rtrim(ltrim($this->_getConf('folder'), "/"), "/") . "/";
    $date = date($this->_getConf('dateformat'));
    $filename = $folder . $date . "_" . $this->_getConf('filename');
    file_put_contents($filename, $content);
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  CONFIGURATION HANDLING  ///////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Loads a configuration
   * 
   * @param string $conf_name
   * @return string
   */
  protected function _getConf($conf_name) {
    return $this->_config->getConfiguration('logs_' . $conf_name);
  }

}