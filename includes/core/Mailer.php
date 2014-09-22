<?php

/**
 * Sends mails
 */
class Mailer {

  /**
   *
   * @var Config
   */
  protected $_config = NULL;
  protected static $instance = null;

  /**
   * 
   * @return Mailer
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

  public function sendMail($content) {
    $to = $this->_getConf('mailto');
    $from = $this->_getConf('mailfrom');
    $_nicefrom = $this->_getConf('mailnicefrom');
    $nicefrom = $_nicefrom ? $_nicefrom : "Reporter";
    $obj = $this->_getConf('mailobj');
    return mail($to, $this->_replacePlaceholders($obj), $content, "From: $nicefrom <$from>\r\n");
  }

  protected function _replacePlaceholders($string) {
    $_string = str_replace("%data%", date("d/m/Y"), $string);
    return $_string;
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
    return $this->_config->getConfiguration('mail_' . $conf_name);
  }

}