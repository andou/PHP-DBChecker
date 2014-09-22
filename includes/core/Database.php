<?php

/**
 * Class to perform database queries.
 * It uses PDO
 */
class Database {

  /**
   *
   * @var Config
   */
  protected $_config = NULL;

  /**
   *
   * @var Database
   */
  protected static $instance = null;

  /**
   *
   * @var PDO 
   */
  protected $_conn = NULL;

  /**
   * Returns an instance of a this class
   * 
   * @return Database
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
    $this->_checkConfigurations();
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  QUERYING THE DATABASE  ////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Performs a query
   * 
   * @param string $sql_query
   * @return array
   */
  public function query($sql_query) {
    return $this->_getConnection()->query($sql_query);
  }

  /**
   * Performs a query
   * 
   * @param string $sql_query
   * @return array
   */
  public function fetchAll($sql_query) {
    $sth = $this->_getConnection()->prepare($sql_query);
    $sth->execute();
    return $sth->fetchAll();
  }

  //////////////////////////////////////////////////////////////////////////////
  /////////////////////////  CONNECTION HANDLING  //////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Returns the PDO DSN
   * 
   * @return type
   */
  protected function _getPDODsn() {
    return sprintf('mysql:host=%s;dbname=%s', $this->_getConf('host'), $this->_getConf('dbname'));
  }

  /**
   * Returns a Database connection
   * 
   * @return PDO
   */
  protected function _getConnection() {
    if (!isset($this->_conn)) {
      $this->_conn = new PDO($this->_getPDODsn(), $this->_getConf('user'), $this->_getConf('password'));
    }
    return $this->_conn;
  }

  /**
   * Checks all the needed configurations are set
   * 
   */
  protected function _checkConfigurations() {
    if (
            !$this->_getConf('host') ||
            !$this->_getConf('dbname') ||
            !$this->_getConf('user')
    ) {
      die('Check your database configurations');
    }
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
    return $this->getConfiguration('connection_' . $conf_name);
  }

}
