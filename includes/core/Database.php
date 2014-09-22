<?php

class Database {

  /**
   *
   * @var Config
   */
  protected $_config = NULL;
  protected static $instance = null;
  protected $_conn = NULL;

  public static function getInstance() {
    if (self::$instance == null) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

  protected function _getConnection() {
    if (!isset($this->_conn)) {
      $this->_conn = new PDO($this->_getPDODsn(), $this->_getConf('user'), $this->_getConf('password'));
    }
    return $this->_conn;
  }

  public function query($sql_query) {
    return $this->_getConnection()->query($sql_query);
  }

  public function fetchAll($sql_query) {
    $sth = $this->_getConnection()->prepare($sql_query);
    $sth->execute();
    return $sth->fetchAll();
  }

  protected function __construct() {
    $this->_config = Config::getInstance();
    $this->_checkConfigurations();
  }

  protected function _getConf($conf_name) {
    return $this->_config->getConfiguration('connection_' . $conf_name);
  }

  protected function _checkConfigurations() {
    if (
            !$this->_getConf('host') ||
            !$this->_getConf('dbname') ||
            !$this->_getConf('user') ||
            !$this->_getConf('password')
    ) {
      die('Check your database configurations');
    }
  }

  protected function _getPDODsn() {
    return sprintf('mysql:host=%s;dbname=%s', $this->_getConf('host'), $this->_getConf('dbname'));
  }

}
