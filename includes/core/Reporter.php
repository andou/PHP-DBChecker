<?php

/**
 * This class is accountable of check results reporting
 */
class Reporter {

  /**
   *
   * @var Config
   */
  protected $_config = NULL;

  /**
   *
   * @var Reporter
   */
  protected static $instance = null;

  /**
   *
   * @var string
   */
  protected $_newline = '<br/>';

  /**
   * Returns an instance of a this class
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

  /**
   * Class constructor
   */
  protected function __construct() {
    $this->_config = Config::getInstance();
  }

  /**
   * Reports checks results
   * 
   * @param Checker $checker
   */
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

  /**
   * Replace end of line
   * 
   * @param string $content
   * @return string
   */
  protected function _replaceEol($content) {
    return str_replace($this->_newline, PHP_EOL, $content);
  }

  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////  OUTPUTS HANDLING  //////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Echoes output into stdout
   * 
   * @param string $results
   */
  protected function echoResults($results) {
    if (defined("ISCLI") && ISCLI === TRUE) {
      echo $this->_replaceEol($results);
    } else {
      echo $results;
    }
  }

  /**
   * Sends mail with checks report
   * 
   * @param string $results
   * @return boolean
   */
  protected function sendMail($results) {
    return Mailer::getInstance()->sendMail($this->_replaceEol($results));
  }

  /**
   * Writes a log file with checks report
   * 
   * @param string $results
   * @return int
   */
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