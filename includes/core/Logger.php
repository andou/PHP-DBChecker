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
  protected static $instance = null;

  /**
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

  protected function __construct() {
    $this->_config = Config::getInstance();
  }

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