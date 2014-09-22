<?php

/**
 * Abstract class to perform checks
 */
abstract class Check {

  /**
   * An array of errors
   *
   * @var array 
   */
  protected $_error_messages = array();

  /**
   * The database connection
   *
   * @var Database
   */
  protected $_database = NULL;

  /**
   * The configuration class
   *
   * @var Config
   */
  protected $_configs = NULL;

  /**
   * Return the name of the currently performed check
   */
  public abstract function getCheckName();

  /**
   * Return the description of the currently performed check
   */
  public abstract function getCheckDescription();

  /**
   * Performs a check
   */
  public abstract function check();

  /**
   * Tells if this check has to be done
   * 
   * @return boolean
   */
  public function isActive() {
    return TRUE;
  }

  /**
   * Class constructor
   */
  public function __construct() {
    
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  DATABASE CONNECTION  //////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * 
   * @return Database
   */
  public function getDatabase() {
    if (!isset($this->_database)) {
      $this->_database = Database::getInstance();
    }
    return $this->_database;
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  ERROR HANDLING  ///////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Tells whether there are errors or not
   * 
   * @return boolean
   */
  public function hasErrors() {
    return (boolean) count($this->_error_messages);
  }

  /**
   * Returns an error to be printed
   * 
   * @return string
   */
  public function printErrorMessages() {
    return implode("\n", $this->_error_messages);
  }

  /**
   * Returns all the errors
   * 
   * @return array
   */
  public function getErrorMessages() {
    return $this->_error_messages;
  }

  /**
   * Adds an error
   * 
   * @param string $error_message
   */
  public function pushErrorMessage($error_message) {
    $this->_error_messages[] = "- " . $error_message;
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  CONFIGURATION HANDLING  ///////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Returns the configuration class
   * 
   * @return Config
   */
  public function getConfigurations() {
    if (!isset($this->_configs)) {
      $this->_configs = Config::getInstance();
    }
    return $this->_configs;
  }

  /**
   * Loads a generic configuration
   *  
   * @param string $configuration
   * @return string
   */
  public function getConfiguration($configuration) {
    return $this->getConfigurations()->getConfiguration($configuration);
  }

  /**
   * Loads a configuration
   * 
   * @param string $conf_name
   * @return string
   */
  protected function _getConf($conf_name) {
    return $this->getConfiguration('checks_' . $conf_name);
  }

}
