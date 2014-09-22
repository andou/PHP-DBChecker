<?php

class Reporter {

  /**
   *
   * @var Config
   */
  protected $_config = NULL;
  protected static $instance = null;
  protected $_newline = '<br/>';

  /**
   * 
   * @return Reporter
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

  public function report(Checker $checker) {
    $results = $checker->reportResults($this->_newline);
    if ($this->_getConf('echo') == 'true') {
      $this->echoResults($results);
    }
    if ($this->_getConf('printfile') == 'true') {
      $this->saveFile($results);
    }
    if ($this->_getConf('sendmail') == 'true') {
      $sent = $this->sendMail($results);
    }
  }

  protected function _replaceEol($content) {
    return str_replace($this->_newline, PHP_EOL, $content);
  }

  protected function echoResults($results) {
    if (defined("ISCLI") && ISCLI === TRUE) {
      echo $this->_replaceEol($results);
    } else {
      echo $results;
    }
  }

  protected function sendMail($results) {
    return Mailer::getInstance()->sendMail($this->_replaceEol($results));
  }

  protected function saveFile($results) {
    return Logger::getInstance()->saveFile($this->_replaceEol($results));
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
    return $this->_config->getConfiguration('report_' . $conf_name);
  }

}