<?php

/**
 * This class autonomously loads and performs all the defined checks
 */
class Checker {

  /**
   * List of checks to be performed
   *
   * @var array
   */
  protected $_checks = array();

  /**
   * List of issued errors
   *
   * @var array
   */
  protected $_errors = array();

  /**
   * Class constructor
   */
  public function __construct() {
    $this->_config = Config::getInstance();
  }

  /**
   * Loads checks to be executed and the runs all the checks
   * 
   * @return \Checker
   */
  public function run() {
    $this->retrieveChecksToPerform();
    $this->performChecks();
    return $this;
  }

  /**
   * Outputs check reporting
   * 
   * @param string $newline
   * @return string
   */
  public function reportResults($newline = "\n") {
    $res = sprintf("Total checks: %d, errors spotted: %d%s%s", count($this->_checks), $this->getErrorsNumber(), "$newline", "$newline");
    if ($this->hasErrors()) {
      foreach ($this->_errors as $check_name => $errors) {
        $res .= "$check_name (" . count($errors) . " errors)" . "$newline";
        $res .= implode("$newline", $errors) . "$newline" . "$newline";
      }
    } else {
      $res .= "Everthing is a-ok!";
    }
    return $res;
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  CHECKS HANDLING  //////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Retrieves all the necessary checks to be performed
   * 
   */
  protected function retrieveChecksToPerform() {
    $files = scandir(ROOT_DIR . "/includes/{$this->_getConf('checkfolder')}");
    foreach ($files as $file) {
      if (preg_match("/^Check(.+).php$/", $file) && $file != __CLASS__ . '.php') {
        $class_name = str_replace(".php", "", $file);
        $this->pushCheck(new $class_name());
      }
    }
  }

  /**
   * Adds a check to be performed
   * 
   * @param Check $check
   */
  public function pushCheck(Check $check) {
    $this->_checks[] = $check;
  }

  /**
   * Actually runs all the loaded checks
   * 
   */
  protected function performChecks() {
    foreach ($this->_checks as $check) {
      if ($check->isActive()) {
        $check->check();
        if ($check->hasErrors()) {
          $this->_errors[$check->getCheckName()] = $check->getErrorMessages();
        }
      }
    }
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  ERROR HANDLING  ///////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * States if some errors has been occured
   * 
   * @return boolean
   */
  public function hasErrors() {
    return (boolean) count($this->_errors);
  }

  /**
   * Tells the number of occurred errors
   * 
   * @return int
   */
  public function getErrorsNumber() {
    $res = 0;
    foreach ($this->_errors as $error_section) {
      $res += count($error_section);
    }
    return $res;
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
    return $this->_config->getConfiguration('checker_' . $conf_name);
  }

}