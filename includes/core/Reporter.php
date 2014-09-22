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
    if ($this->_getConf('mailsend') == 'true') {
      $sent = $this->sendMail($results);
    }
  }

  protected function echoResults($results) {
    if (defined("ISCLI") && ISCLI === TRUE) {
      echo str_replace($this->_newline, PHP_EOL, $results);
    } else {
      echo $results;
    }
  }

  protected function sendMail($results) {
    $to = $this->_getConf('mailto');
    $from = $this->_getConf('mailfrom');
    $_nicefrom = $this->_getConf('mailnicefrom');
    $nicefrom = $_nicefrom ? $_nicefrom : "Reporter";
    $obj = $this->_getConf('mailobj');
    return mail($to, $this->replacePlaceholders($obj), str_replace($this->_newline, PHP_EOL, $results), "From: $nicefrom <$from>\r\n");
  }

  protected function replacePlaceholders($string) {
    $_string = str_replace("%data%", date("d/m/Y"), $string);
    return $_string;
  }

  protected function saveFile($results) {
    $folder = ROOT_DIR . "/" . rtrim(ltrim($this->_getConf('folder'), "/"), "/") . "/";
    $date = date($this->_getConf('dateformat'));
    $filename = $folder . $date . "_" . $this->_getConf('filename');
    file_put_contents($filename, str_replace($this->_newline, PHP_EOL, $results));
  }

  protected function _getConf($conf_name) {
    return $this->_config->getConfiguration('report_' . $conf_name);
  }

}