<?php

abstract class Check {

  protected $_error_messages = array();

  /**
   *
   * @var Database
   */
  protected $_database = NULL;
  protected $_configs = NULL;

//  public abstract function check();
  
  public abstract function getCheckName();

  public function hasErrors() {
    return (boolean) count($this->_error_messages);
  }

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

  /**
   * 
   * @return Config
   */
  public function getConfigurations() {
    if (!isset($this->_configs)) {
      $this->_configs = Config::getInstance();
    }
    return $this->_configs;
  }

  public function getConfiguration($configuration) {
    return $this->getConfigurations()->getConfiguration($configuration);
  }

  public function printErrorMessages() {
    return implode("\n", $this->_error_messages);
  }

  public function getErrorMessages() {
    return $this->_error_messages;
  }

  public function pushErrorMessage($error_message) {
    $this->_error_messages[] = "- ".$error_message;
  }

}
